<?php

namespace Miaoxing\Config\Controller\Admin;

use Miaoxing\Config\Service\Config;
use Miaoxing\Config\Service\ConfigRecord;
use Miaoxing\Plugin\BaseController;
use Wei\Request;

class Configs extends BaseController
{
    protected $controllerName = '配置管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
        'editBatch,updateBatch' => '批量更新',
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
                        'typeName' => $config->getConstantValue('type', $config['type'], 'text'),
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

    public function editBatchAction($req)
    {
        return get_defined_vars();
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
        if (strpos($req['name'], Config::DELIMITER) === false) {
            return $this->err('名称需包含分隔符(' . Config::DELIMITER . ')');
        }

        $config = wei()->configRecord()->findId($req['id']);
        $config->save($req);

        return $this->suc([
            'data' => $config,
        ]);
    }

    public function updateBatchAction($req)
    {
        $reqConfigs = json_decode($req['configs'], true);
        if (json_last_error()) {
            return $this->err('解析JSON失败:' . json_last_error_msg());
        }
        if (!is_array($reqConfigs)) {
            return $this->err('值必需是JSON数组');
        }

        $configs = wei()->configRecord();
        foreach ($reqConfigs as $name => $value) {
            $configs[] = wei()->configRecord()
                ->findOrInit([
                    'server' => $req['server'],
                    'name' => $req['name'] . Config::DELIMITER . $name,
                ])
                ->fromArray([
                    'value' => wei()->config->encode($value),
                    'type' => wei()->config->detectType($value),
                ]);
        }

        $configs->db->transactional(function () use ($configs) {
            $configs->save();
        });

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $config = wei()->configRecord()->findOneById($req['id']);

        $config->destroy();

        return $this->suc();
    }

    public function publishAction($req)
    {
        $ret = wei()->config->publish($req['server']);

        return $ret;
    }
}
