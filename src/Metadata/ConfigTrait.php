<?php

namespace Miaoxing\Config\Metadata;

/**
 * ConfigTrait
 *
 * @property int $id
 * @property bool $type 值的类型,默认0为字符串
 * @property string $name
 * @property mixed $value
 * @property string $comment
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $deletedAt
 * @property int $deletedBy
 * @internal will change in the future
 */
trait ConfigTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'type' => 'bool',
        'name' => 'string',
        'value' => 'mixed',
        'comment' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_at' => 'datetime',
        'deleted_by' => 'int',
    ];
}
