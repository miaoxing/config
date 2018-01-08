<?php

namespace Miaoxing\Config\Service;

use Wei\Cache;
use Wei\RetTrait;
use Wei\Wei;

/**
 * 配置服务
 *
 * @property Cache cache
 * @property Wei|\MiaoxingDoc\Config\AutoComplete $wei
 */
class Config extends \Wei\Config
{
    use RetTrait;

    const DELIMITER = '.';

    /**
     * 配置文件的路径
     *
     * @var string
     */
    protected $configFile = 'data/config-v2.php';

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

    public function load()
    {
        $configs = $this->getLocalConfigs();

        if ($this->needsUpdate($configs)) {
            $configs = $this->writeConfigs();
        }

        $this->wei->setConfig($configs);
    }

    /**
     * @return array
     */
    public function publish()
    {
        $this->updateVersion();

        $this->writeConfigs();

        return $this->suc();
    }

    public function writeConfigs()
    {
        $configs = $this->wei->configModel()->findAll();
        $configs = $this->generateConfigs($configs);

        file_put_contents($this->configFile, $this->generateContent($configs));

        return $configs;
    }

    protected function getVersion()
    {
        $version = $this->cache->get('config.version', function () {
            return $this->wei->configModel()->findOrInit(['name' => 'config.version'])->getPhpValue();
        });

        if (!$version) {
            $version = $this->updateVersion();
        }

        return $version;
    }

    protected function updateVersion()
    {
        $versionConfig =$this->wei->configModel()->findOrInit(['name' => 'config.version']);
        $versionConfig->save(['value' => date('Y-m-d H:i:s')]);
        $this->cache->set('config.version', $versionConfig['value']);

        return $versionConfig['value'];
    }

    protected function getLocalConfigs()
    {
        if (is_file($this->configFile)) {
            return require $this->configFile;
        } else {
            return [];
        }
    }

    protected function needsUpdate(array $configs)
    {
        if (!isset($configs['config']['version'])) {
            return true;
        }

        return $configs['config']['version'] < $this->getVersion();
    }

    protected function generateConfigs($configs)
    {
        $data = [];

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

    protected function generateContent($data)
    {
        return "<?php\n\nreturn " . var_export($data, true) . ";\n";
    }
}
