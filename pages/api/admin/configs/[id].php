<?php

use Miaoxing\Plugin\BasePage;
use Miaoxing\Plugin\Service\Config;
use Miaoxing\Plugin\Service\ConfigModel;
use Miaoxing\Services\Page\ItemTrait;
use Miaoxing\Services\Service\DestroyAction;
use Miaoxing\Services\Service\UpdateAction;
use Wei\V;

return new class () extends BasePage {
    use ItemTrait;

    protected $className = '配置';

    public function patch()
    {
        return UpdateAction::new()
            ->validate(function (ConfigModel $config, $req) {
                $v = V::defaultOptional();
                $v->setModel($config);
                $v->modelColumn('name', '名称')->notEmpty()->notModelDup();
                $v->modelColumn('type', '类型');
                $v->modelColumn('value', '值');
                $v->modelColumn('comment', '注释');
                return $v->check($req);
            })
            ->afterSave(function (ConfigModel $config) {
                Config::updateCache($config);
            })
            ->exec($this);
    }

    public function delete()
    {
        return DestroyAction::new()
            ->afterDestroy(function (ConfigModel $config) {
                Config::deleteCache($config);
            })
            ->exec($this);
    }
};
