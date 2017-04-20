<?php

namespace Miaoxing\Config\Controller\Admin;

use Miaoxing\Config\Service\ConfigRecord;
use miaoxing\plugin\BaseController;
use Wei\Request;

class Configs extends BaseController
{
    protected $controllerName = '配置管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    protected $displayPageHeader = true;

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $configs = wei()->configRecord();

                $configs
                    ->desc('id')
                    ->limit($req['rows'])
                    ->page($req['page']);

                // 数据
                $data = [];
                /** @var ConfigRecord $config */
                foreach ($configs->findAll() as $config) {
                    $data[] = $config->toArray() + [
                        'type_name' => $config->getConstantValue('type', $config['type'], 'text'),
                        ];
                }

                return $this->suc([
                    'data' => $data,
                    'page' => (int) $req['page'],
                    'rows' => (int) $req['rows'],
                    'records' => $configs->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $config = wei()->configRecord()->findId($req['id']);

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction(Request $req)
    {
        $config = wei()->configRecord()->findId($req['id']);
        $config->save($req);

        wei()->config->write();

        return $this->suc([
            'data' => $config,
        ]);
    }

    public function destroyAction($req)
    {
        $config = wei()->configRecord()->findOneById($req['id']);

        $config->destroy();

        wei()->config->write();

        return $this->suc();
    }
}
