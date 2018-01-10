<?php

namespace Miaoxing\Config;

use Miaoxing\Plugin\BasePlugin;

class Plugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    protected $name = '配置';

    public function onAppInit()
    {
        wei()->config->checkUpdate();
    }
}
