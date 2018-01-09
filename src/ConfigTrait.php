<?php

namespace Miaoxing\Config;

/**
 * @property array $configs
 */
trait ConfigTrait
{
    /**
     * 获取配置项或服务
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        // 如果是配置项,至少返回null
        if (isset($this->configs) && isset($this->configs[$name])) {
            if (isset($this->configs[$name]['default'])) {
                return $this->configs[$name]['default'];
            } else {
                return null;
            }
        }

        // 执行父类的服务获取流程
        return parent::__get($name);
    }
}
