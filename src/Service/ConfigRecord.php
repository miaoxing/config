<?php

namespace Miaoxing\Config\Service;

use Exception;
use League\Flysystem\Adapter\Local;
use miaoxing\plugin\BaseModel;
use Wei\Env;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

/**
 * @property Env $env
 */
class ConfigRecord extends BaseModel
{
    protected $table = 'configs';

    protected $providers = [
        'db' => 'app.db',
    ];

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

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->env->loadConfigFile($this->configFile);
    }

    public function write($server)
    {
        $configs = wei()->configRecord()->findAll(['server' => ['', $server]]);

        // 转为配置数组
        $data = [];
        foreach ($configs as $config) {
            list($service, $option) = explode('.', $config['name']);
            $data[$service][$option] = unserialize($config['value']);
        }

        return $this->writeConfigFile($data);
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
