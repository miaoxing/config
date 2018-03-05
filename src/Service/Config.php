<?php

namespace Miaoxing\Config\Service;

use MiaoxingDoc\Config\AutoComplete;
use Wei\Cache;
use Wei\Env;
use Wei\RetTrait;
use Wei\Wei;

/**
 * 配置服务
 *
 * @property Cache cache
 * @property Wei|AutoComplete $wei
 * @property Env env
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
    protected $configFile = 'data/configs/%env%.php';

    /**
     * 存储在数据库,缓存中的版本键名
     *
     * @var string
     */
    protected $versionKey = 'config.version';

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
     * 批量更新配置
     *
     * @param array|\ArrayAccess $req
     * @return array
     * @throws \Exception
     */
    public function batchUpdate($req)
    {
        $reqConfigs = json_decode((string) $req['configs'], true);
        if (json_last_error()) {
            return $this->err('解析JSON失败:' . json_last_error_msg());
        }
        if (!is_array($reqConfigs)) {
            return $this->err('值必需是JSON数组');
        }

        $configs = $this->initModel();
        foreach ($reqConfigs as $name => $value) {
            $configs[] = $this->initModel()
                ->findOrInit(['name' => $req['name'] . static::DELIMITER . $name])
                ->fromArray([
                    // 优先设置type才能正确转换value的值
                    'type' => $this->detectType($value),
                    // TODO json中的value已经是正确的type了
                    'value' => $value,
                ]);
        }

        $configs->db->transactional(function () use ($configs) {
            $configs->save();
        });

        return $this->suc();
    }

    /**
     * 加载配置
     */
    public function load()
    {
        $configs = $this->getLocalConfigs();

        if ($this->needsUpdate($configs)) {
            $this->write();
            $configs = $this->getLocalConfigs();
        }

        $this->wei->setConfig($configs);
    }

    /**
     * 检查更新本地配置
     *
     * @return bool 是否更新了配置
     */
    public function checkUpdate()
    {
        $configs = $this->wei->getConfig();

        if ($this->needsUpdate($configs)) {
            $this->write();
            $configs = $this->getLocalConfigs();
            $this->wei->setConfig($configs);

            return true;
        }

        return false;
    }

    /**
     * 发布配置,可选同时设置一些配置
     *
     * @param array $data 要设置的配置
     * @return array
     */
    public function publish(array $data = [])
    {
        $data && $this->set($data);

        $this->updateVersion();

        $this->write();

        return $this->suc();
    }

    /**
     * 设置一项或多项配置的值
     *
     * @param string|array $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $item => $value) {
                $this->set($name, $value);
            }
        } else {
            $this->initModel()
                ->findOrInit(['name' => $name])
                ->save([
                    'type' => $this->detectType($value),
                    'value' => $value,
                ]);
        }

        return $this;
    }

    /**
     * 删除一项配置
     *
     * @param string $name
     * @return bool
     */
    public function remove($name)
    {
        $model = $this->initModel()->find(['name' => $name]);
        if ($model) {
            $model->destroy();

            return true;
        }

        return false;
    }

    /**
     * 将配置写入文件
     */
    public function write()
    {
        $file = $this->getConfigFile();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $configs = $this->initModel()->findAll();
        $content = $this->generateContent($configs);

        file_put_contents($file, $content);
    }

    /**
     * 获取配置文件
     *
     * @return string
     */
    public function getConfigFile()
    {
        return str_replace('%env%', $this->env->getName(), $this->configFile);
    }

    /**
     * 获取配置的版本号
     *
     * @return string
     */
    protected function getVersion()
    {
        $version = $this->cache->get($this->getVersionKey(), function () {
            return $this->initModel()->findOrInit(['name' => $this->getVersionKey()])->getPhpValue();
        });

        if (!$version) {
            $version = $this->updateVersion();
        }

        return $version;
    }

    /**
     * 更新配置的版本号
     *
     * @return string
     */
    protected function updateVersion()
    {
        $versionConfig = $this->initModel()
            ->findOrInit(['name' => $this->getVersionKey()])
            ->save([
                'value' => date('Y-m-d H:i:s'),
                'comment' => '配置版本号,用于判断是否需要更新配置',
            ]);

        $this->cache->set($this->getVersionKey(), $versionConfig['value']);

        return $versionConfig['value'];
    }

    /**
     * 获取本地的配置数组
     *
     * @return array
     */
    protected function getLocalConfigs()
    {
        if (is_file($file = $this->getConfigFile())) {
            return (array) require $file;
        } else {
            return [];
        }
    }

    /**
     * 判断本地的配置是否需要更改
     *
     * @param array $localConfigs
     * @return bool
     */
    protected function needsUpdate(array $localConfigs)
    {
        // 初始化版本号
        $version = $this->getVersion();

        list($service, $option) = explode(static::DELIMITER, $this->getVersionKey());

        return !isset($localConfigs[$service][$option]) || $localConfigs[$service][$option] < $version;
    }

    /**
     * 检测数据的类型
     *
     * @param mixed $value
     * @return int
     */
    protected function detectType($value)
    {
        return $this->typeMap[gettype($value)];
    }

    /**
     * 将数据库读出的对象生成文件内容
     *
     * @param @param ConfigModel[] $configs
     * @return string
     */
    protected function generateContent($configs)
    {
        $data = [];

        /** @var ConfigModel $config */
        foreach ($configs as $config) {
            // 从右边的点(.)拆分为两部分,兼容a.b.c的等情况
            $pos = strrpos($config->name, static::DELIMITER);
            $service = substr($config->name, 0, $pos);
            $option = substr($config->name, $pos + 1);

            $data[$service][$option] = $config->getPhpValue();
        }

        $content = "<?php\n\nreturn " . $this->varExport($data) . ";\n";

        return $content;
    }

    /**
     * 获取版本键名
     *
     * @return string
     */
    protected function getVersionKey()
    {
        return $this->versionKey;
    }

    /**
     * 初始化模型对象
     *
     * @return ConfigModel|ConfigModel[]
     */
    protected function initModel()
    {
        return $this->wei->configModel();
    }

    /**
     * @param mixed $var
     * @param string $indent
     * @return string
     * @see Base on https://stackoverflow.com/questions/24316347/how-to-format-var-export-to-php5-4-array-syntax
     */
    protected function varExport($var, $indent = '')
    {
        switch (gettype($var)) {
            case 'string':
                return '\'' . addcslashes($var, "\\\$\'\r\n\t\v\f") . '\'';
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = $indent . '    '
                        . ($indexed ? '' : $this->varExport($key) . ' => ')
                        . $this->varExport($value, "$indent    ");
                }

                return "[\n" . implode(",\n", $r) . ($r ? ',' : '') . "\n" . $indent . ']';
            case 'boolean':
                return $var ? 'true' : 'false';

            case 'object' && $var->express:
                return $var->express;

            default:
                return var_export($var, true);
        }
    }
}
