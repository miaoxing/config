<?php

namespace Miaoxing\Config\Service;

use Miaoxing\Config\Metadata\ConfigTrait;
use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Plugin\Constant;

/**
 * 配置模型
 *
 * @property mixed $phpValue
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

    /**
     * @var array
     */
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
     * @var array
     */
    protected $defaultCasts = [
        'value' => 'mixed',
    ];

    /**
     * @var callable
     */
    protected $encoder = 'serialize';

    /**
     * @var callable
     */
    protected $decoder = 'unserialize';

    /**
     * @var array
     */
    protected $virtual = [
        'type_label',
    ];

    /**
     * 类型名称
     *
     * @return string
     */
    protected function getTypeLabelAttribute()
    {
        return wei()->configModel->getConstantLabel('type', $this['type']);
    }

    /**
     * 展示的值
     *
     * @return mixed
     */
    protected function getValueAttribute()
    {
        $value = $this->getPhpValue();

        if (is_scalar($value) || $value === null) {
            return $value;
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param mixed $value
     * @throws \Exception
     */
    protected function setValueAttribute($value)
    {
        $value = $this->convert($value, $this->get('type'));
        $this->data['value'] = call_user_func($this->encoder, $value);
    }

    /**
     * 获取实际使用的PHP变量值
     *
     * @return mixed
     */
    public function getPhpValue()
    {
        return $this->data['value'] ? call_user_func($this->decoder, $this->data['value']) : null;
    }

    /**
     * @param string $value
     * @param int $type
     * @return mixed
     */
    public function convert($value, $type)
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
