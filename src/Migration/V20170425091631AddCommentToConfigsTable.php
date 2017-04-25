<?php

namespace Miaoxing\Config\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20170425091631AddCommentToConfigsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('configs')
            ->string('comment')->after('value')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('configs')
            ->dropColumn('comment')
            ->exec();
    }
}
