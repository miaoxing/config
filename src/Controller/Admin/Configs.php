<?php

namespace Miaoxing\Config\Controller\Admin;


use miaoxing\plugin\BaseController;

class Configs extends BaseController
{
    public function indexAction()
    {

    }

    public function updateAction()
    {
        return wei()->configRecord->write('dev');
    }
}
