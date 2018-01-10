<?php

namespace MiaoxingTest\Config\Service;

use Miaoxing\Config\Service\ConfigModel;
use Miaoxing\Plugin\Test\BaseTestCase;

class ConfigTest extends BaseTestCase
{
    protected static $testKey = 'testConfig.test';

    protected static $versionKey = 'testConfig.version';

    protected static $configFile = 'data/test.php';

    protected static $maxId;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // 禁用原来数据
        static::$maxId = wei()->configModel()->select('MAX(id)')->fetchColumn();
        wei()->configModel()->findAll()->destroy();

        wei()->config->setOption([
            'configFile' => static::$configFile,
            'versionKey' => static::$versionKey,
        ]);
    }

    public static function tearDownAfterClass()
    {
        // 删除测试数据
        wei()->configModel()
            ->unscoped()
            ->andWhere('id > ?', static::$maxId)
            ->delete();

        // 还原原来数据
        foreach (wei()->configModel()->unscoped()->findAll() as $config) {
            $config->restore();
        }

        if (is_file(static::$configFile)) {
            unlink(static::$configFile);
        }

        parent::tearDownAfterClass();
    }

    public function testSet()
    {
        $value = $this->getRandValue();
        wei()->config->set(static::$testKey, $value);

        $config = wei()->configModel()->find(['name' => static::$testKey]);
        $this->assertSame($value, $config->value);
        $this->assertSame(ConfigModel::TYPE_INT, $config->type);
    }

    public function testRemove()
    {
        $value = $this->getRandValue();
        wei()->config->set(static::$testKey, $value);

        $result = wei()->config->remove(static::$testKey);
        $this->assertTrue($result);

        $result = wei()->config->remove(static::$testKey);
        $this->assertFalse($result);
    }

    public function testWrite()
    {
        $value = $this->getRandValue();
        wei()->config->set(static::$testKey, $value);

        wei()->config->write();
        $this->assertFileExists(static::$configFile);

        $config = require static::$configFile;
        $this->assertEquals($value, $this->getTestValue($config), '文件中看到写入的值');
    }

    public function testLoad()
    {
        $value = $this->getRandValue();
        wei()->config->set(static::$testKey, $value);

        wei()->config->load();

        $this->assertSame($value, $this->getTestValue(wei()->getConfig()), '配置中看到加载的值');
    }

    public function testCheckUpdateWhenFileNotFound()
    {
        $this->removeVersionCache();
        if (is_file(static::$configFile)) {
            unlink(static::$configFile);
        }

        $result = wei()->config->checkUpdate();
        $this->assertTrue($result, '文件不存在,会更新');

        $this->assertFileExists(static::$configFile, '新生成了文件');

        $result = wei()->config->checkUpdate();
        $this->assertFalse($result, '文件已存在,不会再更新');
    }

    public function testCheckUpdateWhenVersionKeyNotFound()
    {
        $this->removeVersionCache();
        wei()->config->checkUpdate();
        $this->assertFileExists(static::$configFile, '先确保文件存在');

        $this->wei->setConfig('testConfig:version', null);
        $this->assertNull($this->wei->getConfig('testConfig:version'), '清空本地版本号');

        $result = wei()->config->checkUpdate();
        $this->assertTrue($result, '本地版本号不存在,会更新');

        $result = wei()->config->checkUpdate();
        $this->assertFalse($result, '本地版本号已存在,不会再更新');
    }

    public function testPublish()
    {
        // 移除版本号
        $this->removeVersionCache();
        wei()->config->remove(static::$versionKey);

        // 存入测试的值
        $value = $this->getRandValue();
        wei()->config->set(static::$testKey, $value);

        $ret = wei()->config->publish();
        $this->assertRetSuc($ret);
        $this->assertFileExists(static::$configFile, '发布后有文件');

        $config = require static::$configFile;
        $this->assertSame($value, $this->getTestValue($config), '文件中看到写入的值');

        $this->assertNotNull($config['testConfig']['version'], '发布后有版本号');
    }

    protected function removeVersionCache()
    {
        wei()->cache->remove(static::$versionKey);
    }

    protected function getRandValue()
    {
        return mt_rand(1, 10000);
    }

    protected function getTestValue($config)
    {
        return $config['testConfig']['test'];
    }
}
