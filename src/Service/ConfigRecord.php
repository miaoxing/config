<?php

namespace Miaoxing\Config\Service;

use Exception;
use League\Flysystem\Adapter\Local;
use miaoxing\plugin\BaseModel;
use Miaoxing\Plugin\Constant;
use Wei\Env;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

/**
 * @property Env $env
 */
class ConfigRecord extends BaseModel
{
    use Constant;

    const TYPE_STRING = 0;

    const TYPE_BOOL = 1;

    const TYPE_INT = 2;

    const TYPE_FLOAT = 3;

    const TYPE_ARRAY = 4;

    protected $typeTable = [
        self::TYPE_STRING => [
            'text' => '字符串',
        ],
        self::TYPE_BOOL => [
            'text' => '布尔值',
        ],
        self::TYPE_INT => [
            'text' => '整数',
        ],
        self::TYPE_FLOAT => [
            'text' => '小数',
        ],
        self::TYPE_ARRAY => [
            'text' => '数组',
        ],
    ];

    protected $table = 'configs';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $createAtColumn = 'created_at';

    protected $updateAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    /**
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
    protected $denyServices = [
        'wei',
        'db',
    ];

    /**
     * @var string
     */
    protected $configFile = 'data/cache/config.php';

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->env->loadConfigFile($this->configFile);
    }

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

    public function write()
    {
        $configs = wei()->configRecord()->findAll();

        // 转为配置数组
        $data = [];
        foreach ($configs as $config) {
            list($service, $option) = explode('.', $config['name']);
            $data[$service][$option] = $this->covert($config['value'], $config['type']);
        }

        return $this->writeConfigFile($data);
    }

    /**
     * @param string $value
     * @param int $type
     * @return mixed
     */
    protected function covert($value, $type)
    {
        switch ($type) {
            case static::TYPE_STRING:
                return (string) $value;

            case static::TYPE_INT:
                return (int) $value;

            case static::TYPE_FLOAT:
                return (float) $value;

            case static::TYPE_BOOL:
                return (bool) $value;

            case static::TYPE_ARRAY:
                return json_decode($value, true);

            default:
                return $value;
        }
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
                $rets[] = $this->err('写入失败:'. $e->getMessage());
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
