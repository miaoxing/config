<?php

namespace Miaoxing\Config\Service;

use Wei\Env;
use Wei\RetTrait;

/**
 * 配置服务
 *
 * @property Env $env
 */
class ConfigV1 extends \Wei\Config
{
    use RetTrait;

    /**
     * 配置文件的路径
     *
     * @var string
     */
    protected $configFile = 'data/config.php';

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
}
