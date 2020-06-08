<?php

namespace Miaoxing\Config\Migration;

use Wei\Migration\BaseMigration;

class V20170413162605CreateConfigsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('configs')
            ->id()
            ->string('server', 32)
            ->tinyInt('type', 1)->comment('值的类型,默认0为字符串')
            ->string('name', 255)
            ->text('value')
            ->timestamps()
            ->userstamps()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('configs');
    }
}
