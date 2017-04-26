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
        [
            'adapter' => 'local',
        ],
    ];

    /**
     * @var array
     */
    protected $typeMap = [
        'string' => ConfigRecord::TYPE_STRING,
        'boolean' => ConfigRecord::TYPE_BOOL,
        'integer' => ConfigRecord::TYPE_INT,
        'double' => ConfigRecord::TYPE_FLOAT,
        'array' => ConfigRecord::TYPE_ARRAY,
        'object' => ConfigRecord::TYPE_ARRAY,
        'resource' => ConfigRecord::TYPE_INT,
        'NULL' => ConfigRecord::TYPE_NULL,
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
    public function publish()
    {
        $serverConfigs = $this->getServers();

        // 获取所有配置
        $configs = wei()->configRecord()->findAll();

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
        return $this->writeConfigFile($plainConfigs);
    }

    public function mergeConfig($configs, $data = [])
    {
        if (!$configs) {
            return $data;
        }

        /** @var ConfigRecord $config */
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

    protected function writeConfigFile($data)
    {
        $errors = [];
        foreach ($this->getServers() as $serverId => $server) {
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
