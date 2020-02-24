<?php

namespace Miaoxing\Config\Migration;

use Miaoxing\Services\Migration\BaseMigration;

class V20180109150456UpdateConfigsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('configs')
            ->dropColumn('server')
            ->softDeletable()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('configs')
            ->string('server', 32)
            ->dropColumn('deleted_at')
            ->dropColumn('deleted_by')
            ->exec();
    }
}
