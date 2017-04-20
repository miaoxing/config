<?php

namespace Miaoxing\Config\Service;

use Wei\Env;
use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;
use Wei\RetTrait;

/**
 * @property Env $env
 */
class Config extends \Wei\Config
{
    use RetTrait;

    const SERVER_ALL = '';

    /**
     * 配置文件的路径
     *
     * @var string
     */
    protected $configFile = 'data/cache/config.php';

    /**
     * 写入配置文件的服务器
     *
     * @var array
     */
    protected $servers = [
        [
            'adapter' => 'local',
        ],
    ];

    /**
     * 不允许的配置名称
     *
     * @var array
     */
    protected $denyServices = [
        'wei',
        'db',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->env->loadConfigFile($this->configFile);
    }

    /**
     * @return array
     */
    public function write()
    {
        // 获取所有配置
        $configs = wei()->configRecord()->findAll();
        $servers = [];
        $serverConfigs = [];

        // 按服务器对配置分组
        foreach ($configs as $config) {
            $servers[$config['server']][] = $config;
        }

        // 生成默认配置
        $defaultConfig = $this->mergeConfig($servers[static::SERVER_ALL]);

        // 附加服务器自己的配置
        unset($servers[static::SERVER_ALL]);
        foreach ($servers as $server => $configs) {
            $serverConfigs[$server] = $this->mergeConfig($configs, $defaultConfig);
        }

        // 逐个服务器写入配置
        $this->writeConfigFile($serverConfigs);
    }

    public function mergeConfig($configs, $data = [])
    {
        /** @var ConfigRecord $config */
        foreach ($configs as $config) {
            list($service, $option) = explode('.', $config['name']);
            $data[$service][$option] = $config->getPhpValue();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getServerConfigs()
    {
        $data = [];
        $data[] = [
            'name' => '全部',
            'value' => '',
        ];

        foreach ($this->servers as $server) {
            $key = $this->getKey($server);
            $data[] = [
                'name' => $key,
                'value' => $key,
            ];
        }

        return $data;
    }

    protected function getKey($server)
    {
        if (isset($server['options']['host'])) {
            return $server['options']['host'];
        }

        return $server['adapter'];
    }

    protected function writeConfigFile($data)
    {
        $errors = [];
        foreach ($this->servers as $server) {
            $filesystem = $this->createFilesystem($server);
            $key = $this->getKey($server);

            try {
                $result = $filesystem->put($this->configFile, $this->generateContent($data[$key]));
                if (!$result) {
                    $errors[] = $this->err('写入失败', ['result' => $result]);
                }
            } catch (\LogicException $e) {
                $errors[] = $this->err('写入失败:' . $e->getMessage());
            }
        }

        if ($errors) {
            return $this->err('写入失败', ['errors' => $errors]);
        }

        return $this->suc();
    }

    protected function createFilesystem($server)
    {
        switch ($server['adapter']) {
            case 'local':
                $adapter = new Local(realpath(''));
                break;

            case 'sftp':
                $adapter = new SftpAdapter($server['options']);
                break;

            default:
                throw new Exception(sprintf('Unsupported adapter "%s"', $server['type']));
        }

        return new Filesystem($adapter);
    }

    protected function generateContent($data)
    {
        return "<?php\n\nreturn " . var_export($data, true) . ';';
    }
}
