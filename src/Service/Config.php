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
        $configs = wei()->configRecord()->findAll();

        // 转为配置数组
        $data = [];
        foreach ($configs as $config) {
            list($service, $option) = explode('.', $config['name']);
            $data[$service][$option] = $config->getPhpValue();
        }

        return $this->writeConfigFile($data);
    }

    /**
     * @return array
     */
    public function getServers()
    {
        $data = [];
        $data[] = [
            'name' => '全部',
            'value' => '',
        ];

        foreach ($this->servers as $server) {
            if (isset($server['options']['host'])) {
                $data[] = [
                    'name' => $server['options']['host'],
                    'value' => $server['options']['host'],
                ];
            } else {
                $data[] = [
                    'name' => $server['adapter'],
                    'value' => $server['adapter'],
                ];
            }
        }

        return $data;
    }

    protected function writeConfigFile($data)
    {
        $rets = [];
        foreach ($this->servers as $server) {
            $filesystem = $this->createFilesystem($server);
            try {
                $result = $filesystem->put($this->configFile, $this->generateContent($data));
                if (!$result) {
                    $rets[] = $this->err('写入失败', ['result' => $result]);
                }
            } catch (\LogicException $e) {
                $rets[] = $this->err('写入失败:' . $e->getMessage());
            }
        }

        if ($rets) {
            return $this->err('写入失败', ['rets' => $rets]);
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
