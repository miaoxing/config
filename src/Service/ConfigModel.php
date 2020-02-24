<?php

namespace Miaoxing\Config\Service;

use Miaoxing\Config\Metadata\ConfigTrait;
use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Services\Model\SoftDeleteTrait;
use Miaoxing\Services\ConstTrait;
use stdClass;

/**
 * 配置模型
 */
class ConfigModel extends BaseModelV2
{
    use ConstTrait;
    use ConfigTrait;
    use SoftDeleteTrait;

    const TYPE_STRING = 0;

    const TYPE_BOOL = 1;

    const TYPE_INT = 2;

    const TYPE_FLOAT = 3;

    const TYPE_ARRAY = 4;

    const TYPE_NULL = 5;

    const TYPE_EXPRESS = 6;

    /**
     * @var array
     */
    protected $typeNames = [
        self::TYPE_STRING => '字符串',
        self::TYPE_BOOL => '布尔值',
        self::TYPE_INT => '整数',
        self::TYPE_FLOAT => '小数',
        self::TYPE_ARRAY => '数组',
        self::TYPE_NULL => 'NULL',
        self::TYPE_EXPRESS => '表达式',
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
     * 保存一项配置
     *
     * @param array|\ArrayAccess $req
     * @return array
     */
    public function store($req)
    {
        if (strpos($req['name'], Config::DELIMITER) === false) {
            return $this->err('名称需包含分隔符(' . Config::DELIMITER . ')');
        }

        if ($req['type'] == static::TYPE_ARRAY) {
            json_decode($req['value']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->err('值需是JSON格式：' . json_last_error_msg());
            }
        }

        $this->findId($req['id']);
        $this->save($req);

        return $this->toRet();
    }

    /**
     * 类型名称
     *
     * @return string
     */
    protected function getTypeLabelAttribute()
    {
        return $this->getConstLabel('type', $this['type']);
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

        if ($value instanceof stdClass && isset($value->express)) {
            return $value->express;
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
    protected function convert($value, $type)
    {
        switch ($type) {
            case static::TYPE_STRING:
                return (string) $value;

            case static::TYPE_INT:
                return (int) $value;

            case static::TYPE_FLOAT:
                return (float) $value;

            case static::TYPE_BOOL:
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);

            case static::TYPE_ARRAY:
                return is_array($value) ? $value : json_decode($value, true);

            case static::TYPE_EXPRESS:
                $object = new stdClass();
                $object->express = (string) $value;

                return $object;

            default:
                return $value;
        }
    }
}
