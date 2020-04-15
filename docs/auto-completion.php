<?php

/**
 * @property    Miaoxing\Config\Service\Config $config 配置服务
 */
class ConfigMixin {
}

/**
 * @property    Miaoxing\Config\Service\ConfigModel $configModel 配置模型
 * @method      Miaoxing\Config\Service\ConfigModel|Miaoxing\Config\Service\ConfigModel[] configModel($table = null)
 */
class ConfigModelMixin {
}

/**
 * @mixin ConfigMixin
 * @mixin ConfigModelMixin
 */
class AutoCompletion {
}

/**
 * @return AutoCompletion
 */
function wei()
{
    return new AutoCompletion;
}

/** @var Miaoxing\Config\Service\Config $config */
$config = wei()->config;

/** @var Miaoxing\Config\Service\ConfigModel $configModel */
$config = wei()->configModel();

/** @var Miaoxing\Config\Service\ConfigModel|Miaoxing\Config\Service\ConfigModel[] $configModels */
$configs = wei()->configModel();
