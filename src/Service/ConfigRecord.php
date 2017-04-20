<?php

namespace Miaoxing\Config\Service;

use miaoxing\plugin\BaseModel;
use Miaoxing\Plugin\Constant;

class ConfigRecord extends BaseModel
{
    use Constant;

    const TYPE_STRING = 0;

    const TYPE_BOOL = 1;

    const TYPE_INT = 2;

    const TYPE_FLOAT = 3;

    const TYPE_ARRAY = 4;

    protected $typeTable = [
        self::TYPE_STRING => [
            'text' => '字符串',
        ],
        self::TYPE_BOOL => [
            'text' => '布尔值',
        ],
        self::TYPE_INT => [
            'text' => '整数',
        ],
        self::TYPE_FLOAT => [
            'text' => '小数',
        ],
        self::TYPE_ARRAY => [
            'text' => '数组',
        ],
    ];

    protected $table = 'configs';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $createAtColumn = 'created_at';

    protected $updateAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    /**
     * @return mixed
     */
    public function getPhpValue()
    {
        return $this->covert($this['value'], $this['type']);
    }

    /**
     * @param string $value
     * @param int $type
     * @return mixed
     */
    protected function covert($value, $type)
    {
        switch ($type) {
            case static::TYPE_STRING:
                return (string) $value;

            case static::TYPE_INT:
                return (int) $value;

            case static::TYPE_FLOAT:
                return (float) $value;

            case static::TYPE_BOOL:
                return (bool) $value;

            case static::TYPE_ARRAY:
                return json_decode($value, true);

            default:
                return $value;
        }
    }
}
