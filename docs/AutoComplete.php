<?php

namespace MiaoxingDoc\Config {

    /**
     * @property    \Miaoxing\Config\Service\Config $config 配置服务
     *
     * @property    \Miaoxing\Config\Service\ConfigModel $configModel 配置模型
     * @method      \Miaoxing\Config\Service\ConfigModel|\Miaoxing\Config\Service\ConfigModel[] configModel()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\Config\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\Config\Service\Config $config */
    $config = wei()->config;

    /** @var Miaoxing\Config\Service\ConfigModel $configModel */
    $config = wei()->configModel;
}
