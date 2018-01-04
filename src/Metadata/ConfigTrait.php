<?php

namespace Miaoxing\Config\Metadata;

/**
 * ConfigTrait
 *
 * @property int $id
 * @property string $server
 * @property int $type 值的类型,默认0为字符串
 * @property string $name
 * @property string $value
 * @property string $comment
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 */
trait ConfigTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'server' => 'string',
        'type' => 'int',
        'name' => 'string',
        'value' => 'string',
        'comment' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];
}
