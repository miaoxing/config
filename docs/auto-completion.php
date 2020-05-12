<?php

/**
 * @property    Miaoxing\Config\Service\Config2 $config2 配置服务
 */
class Config2Mixin {
}

/**
 * @property    Miaoxing\Config\Service\ConfigModel $configModel 配置模型
 * @method      Miaoxing\Config\Service\ConfigModel|Miaoxing\Config\Service\ConfigModel[] configModel($table = null)
 */
class ConfigModelMixin {
}

/**
 * @mixin Config2Mixin
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

/** @var Miaoxing\Config\Service\Config2 $config2 */
$config2 = wei()->config2;

/** @var Miaoxing\Config\Service\ConfigModel $configModel */
$config = wei()->configModel();

/** @var Miaoxing\Config\Service\ConfigModel|Miaoxing\Config\Service\ConfigModel[] $configModels */
$configs = wei()->configModel();
