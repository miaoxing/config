<?php

namespace Miaoxing\Config\Service;

use Wei\Env;
use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;
use Wei\RetTrait;

/**
 * 配置服务
 *
 * @property Env $env
 */
class ConfigV1 extends \Wei\Config
{
    use RetTrait;

    const SERVER_ALL = '';

    const DELIMITER = '.';

    /**
     * 配置文件的路径
     *
     * @var string
     */
    protected $configFile = 'data/config.php';

    /**
     * 写入配置文件的服务器
     *
     * @var array
     */
    protected $servers = [
        'local' => [
            'adapter' => 'local',
        ],
    ];

    /**
     * @var array
     */
    protected $typeMap = [
        'string' => ConfigModel::TYPE_STRING,
        'boolean' => ConfigModel::TYPE_BOOL,
        'integer' => ConfigModel::TYPE_INT,
        'double' => ConfigModel::TYPE_FLOAT,
        'array' => ConfigModel::TYPE_ARRAY,
        'object' => ConfigModel::TYPE_ARRAY,
        'resource' => ConfigModel::TYPE_INT,
        'NULL' => ConfigModel::TYPE_NULL,
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

        // If the config service is not constructed, the service container can't set config for it
        if (!$this->wei->isInstanced('configV1')) {
            $this->wei->set('configV1', $this);
        }

        $this->env->loadConfigFile($this->configFile);
    }

    /**
     * @param string $publishServer 要发布的服务器名称,默认全部
     * @return array
     */
    public function publish($publishServer = '')
    {
        $serverConfigs = $this->getServers();

        // 获取所有配置
        $configs = wei()->configModel()->findAll();

        // 初始化服务器数组,确保每个服务器都会更新
        $servers = [
            static::SERVER_ALL => [],
        ];
        foreach ($serverConfigs as $name => $set) {
            if ($set['adapter'] === 'set') {
                continue;
            }
            $servers[$name] = [];
        }

        // 按服务器和集群对配置分组
        foreach ($configs as $config) {
            if ($serverConfigs[$config['server']]['adapter'] === 'set') {
                foreach ($serverConfigs[$config['server']]['servers'] as $serverId) {
                    $servers[$serverId][] = $config;
                }
            } else {
                $servers[$config['server']][] = $config;
            }
        }

        // 生成全局配置
        $allConfig = $this->mergeConfig($servers[static::SERVER_ALL]);

        // 附加服务器自己的配置
        $plainConfigs = [];
        unset($servers[static::SERVER_ALL]);
        foreach ($servers as $server => $configs) {
            $plainConfigs[$server] = $this->mergeConfig($configs, $allConfig);
        }

        // 逐个服务器写入配置
        return $this->writeConfigFile($plainConfigs, $publishServer);
    }

    protected function mergeConfig($configs, $data = [])
    {
        if (!$configs) {
            return $data;
        }

        /** @var ConfigModel $config */
        foreach ($configs as $config) {
            // 从右边的点(.)拆分为两部分,兼容a.b.c的等情况
            $pos = strrpos($config['name'], static::DELIMITER);
            $service = substr($config['name'], 0, $pos);
            $option = substr($config['name'], $pos + 1);

            $data[$service][$option] = $config->getPhpValue();
        }

        return $data;
    }

    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @return array
     */
    public function getServerOptions()
    {
        $servers = $this->getServers();

        $options = [];
        $options[] = [
            'name' => '全部',
            'value' => '',
        ];

        foreach ($servers as $key => $server) {
            $options[] = [
                'name' => $key,
                'value' => $key,
            ];
        }

        return $options;
    }

    /**
     * 检测数据的类型
     *
     * @param mixed $value
     * @return int
     */
    public function detectType($value)
    {
        return $this->typeMap[gettype($value)];
    }

    /**
     * 转换数据为可存储的字符串
     *
     * @param mixed $value
     * @return string
     */
    public function encode($value)
    {
        if (!is_scalar($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $value;
    }

    protected function filterServers($publishServer)
    {
        $servers = $this->getServers();
        if (!$publishServer) {
            return $servers;
        }

        if (!isset($servers[$publishServer])) {
            return [];
        }

        // 一组服务器的情况
        if ($servers[$publishServer]['adapter'] == 'set') {
            return array_intersect_key($servers, array_flip($servers[$publishServer]['servers']));
        }

        // 只有一台服务器的情况
        return [$publishServer => $servers[$publishServer]];
    }

    protected function writeConfigFile($data, $publishServer)
    {
        $servers = $this->filterServers($publishServer);

        $errors = [];
        foreach ($servers as $serverId => $server) {
            // 没有该服务器的配置则跳过
            if (!isset($data[$serverId]) || !$data[$serverId]) {
                continue;
            }

            $filesystem = $this->createFilesystem($server);
            try {
                $result = $filesystem->put($this->configFile, $this->generateContent($data[$serverId]));
                if (!$result) {
                    $errors[] = $this->err([
                        'message' => '写入失败',
                        'serverId' => $serverId,
                    ]);
                }
            } catch (\LogicException $e) {
                $errors[] = $this->err([
                    'message' => '写入失败:' . $e->getMessage(),
                    'localIp' => wei()->request->getServer('SERVER_ADDR'),
                ]);
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
        return "<?php\n\nreturn " . var_export($data, true) . ";\n";
    }
}
