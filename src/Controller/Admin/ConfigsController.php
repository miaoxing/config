<?php

namespace Miaoxing\Config\Controller\Admin;

use Miaoxing\Config\Service\Config2;
use Miaoxing\Config\Service\ConfigModel;
use Miaoxing\Plugin\BaseController;
use Wei\Request;

class ConfigsController extends BaseController
{
    protected $displayPageHeader = true;

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $configs = wei()->configModel()
                    ->desc('id')
                    ->limit($req['rows'])
                    ->page($req['page'])
                    ->findAll();

                return $this->suc([
                    'data' => $configs,
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

    public function batchEditAction($req)
    {
        return get_defined_vars();
    }

    public function editAction($req)
    {
        $config = wei()->configModel()->findId($req['id']);

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction(Request $req)
    {
        $ret = wei()->configModel()->store($req);

        return $ret;
    }

    public function batchUpdateAction($req)
    {
        $ret = wei()->config->batchUpdate($req);

        return $ret;
    }

    public function destroyAction($req)
    {
        $config = wei()->configModel()->findOneById($req['id']);

        $config->destroy();

        return $this->suc();
    }

    public function publishAction()
    {
        $ret = wei()->config->publish();

        return $ret;
    }
}
