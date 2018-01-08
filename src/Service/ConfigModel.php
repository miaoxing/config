<?php

namespace Miaoxing\Config\Service;

use Miaoxing\Config\Metadata\ConfigTrait;
use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Constant;

/**
 * 配置模型
 */
class ConfigModel extends BaseModelV2
{
    use Constant;
    use ConfigTrait;

    const TYPE_STRING = 0;

    const TYPE_BOOL = 1;

    const TYPE_INT = 2;

    const TYPE_FLOAT = 3;

    const TYPE_ARRAY = 4;

    const TYPE_NULL = 5;

    protected $typeTable = [
        self::TYPE_STRING => [
            'label' => '字符串',
        ],
        self::TYPE_BOOL => [
            'label' => '布尔值',
        ],
        self::TYPE_INT => [
            'label' => '整数',
        ],
        self::TYPE_FLOAT => [
            'label' => '小数',
        ],
        self::TYPE_ARRAY => [
            'label' => '数组',
        ],
        self::TYPE_NULL => [
            'label' => 'NULL',
        ],
    ];

    /**
     * @var string
     */
    protected $encoder = 'base64_encode';

    /**
     * @var string
     */
    protected $decoder = 'base64_decode';

    protected $virtual = [
        'type_label',
    ];

    protected function getTypeLabelAttribute()
    {
        return $this->getConstantLabel('type', $this['type']);
    }

    protected function getValueAttribute()
    {
        return call_user_func($this->decoder, $this->data['value']);
    }

    protected function setValueAttribute($value)
    {
        $this->data['value'] = call_user_func($this->encoder, $value);

        $name = 'value';
        $this->changedData[$name] = isset($this->data[$name]) ? $this->data[$name] : null;
        $this->isChanged = true;
    }

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
