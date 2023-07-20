<?php

namespace Miaoxing\Config;

use Miaoxing\Admin\Service\AdminMenu;
use Miaoxing\Plugin\BasePlugin;

class ConfigPlugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    protected $name = '配置';

    public function onAdminMenuGetMenus(AdminMenu $menu)
    {
        $setting = $menu->child('setting');
        $configs = $setting->addChild()->setLabel('配置管理')->setUrl('admin/configs');
        $configs->addChild()->setLabel('添加')->setUrl('admin/configs/new');
        $configs->addChild()->setLabel('编辑')->setUrl('admin/configs/[id]/edit');
        $configs->addChild()->setLabel('删除')->setUrl('admin/configs/[id]/delete');

        $configs = $setting->addChild()->setLabel('全局配置管理')->setUrl('admin/global-configs');
        $configs->addChild()->setLabel('添加')->setUrl('admin/global-configs/new');
        $configs->addChild()->setLabel('编辑')->setUrl('admin/global-configs/[id]/edit');
        $configs->addChild()->setLabel('删除')->setUrl('admin/global-configs/[id]/delete');
    }
}
