<?php

use G4MR\Configs;
use G4MR\Configs\Config;
use G4MR\Configs\Loader\YamlLoader;

require_once __DIR__ . '/loaders/PHPLoader.php';

class ConfigsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Config
     */
    private $config;

    public function __construct()
    {
        $this->config = new Config(new YamlLoader(__DIR__ . '/configs'));
        $this->php_config = new Config(new PHPLoader(__DIR__ . '/configs'));
    }

    public function testYAMLConfigLoadAllContents()
    {
        $data = $this->config->get('test');

        $this->assertNotEmpty($data);
    }

    public function testYAMLConfigDefaultValueOnInvalidItem()
    {
        $data = $this->config->get('test.fake_array_key', 'defaulted');

        $this->assertEquals('defaulted', $data);
    }

    public function testYAMLConfigValueIsNotEmpty()
    {
        $data = $this->config->get('test.users.0.username');

        $this->assertNotEmpty($data);
    }

    public function testYAMLConfigValueEqualsValue()
    {
        $data = $this->config->get('test.users.0.username');

        $this->assertEquals('Lamonte', $data);
    }

    public function testYAMLConfigNotEmptyWhenLoadedWithADifferentFileType()
    {
        $this->config->setExtension('ym');

        $data = $this->config->get('test.users.0.username');

        $this->assertNotEmpty($data);
    }

    public function testYAMLConfigItemObjectItemExists()
    {
        $test_data = $this->config->getItem('test');

        $this->assertNotEmpty($test_data->get('users.0.username'));
    }

    public function testYAMLConfigItemObjectItemValueEqualsValue()
    {
        $test_data = $this->config->getItem('test');

        $this->assertEquals('Lamonte', $test_data->get('users.0.username'));
    }

    public function testYAMLConfigSetItemObjectValueAndObjectHasNewValue()
    {
        $test_data = $this->config->getItem('test');
        $test_data->set('users.2', array('username' => 'Jane'));
        $test_data->testing = "hello";
        $test_data->db = [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
            'name' => 'dbname'
        ];

        print_r($test_data->get('db'));

        $this->assertEquals('Jane', $test_data->get('users.2.username'));
        $this->assertEquals('hello', $test_data->get('testing'));
    }

    public function testPHPLoaderAndValuesAndDataExists()
    {
        $data = $this->php_config->get('test');

        $this->assertNotEmpty($data);
    }

    public function testPHPLoaderDefaultValueOnInvalidItem()
    {
        $data = $this->php_config->get('test.fake_array_key', 'defaulted');

        $this->assertEquals('defaulted', $data);
    }

    public function testPHPLoaderValueIsNotEmpty()
    {
        $data = $this->php_config->get('test.users.0.username');

        $this->assertNotEmpty($data);
    }

    public function testPHPLoaderValueEqualsValue()
    {
        $data = $this->php_config->get('test.users.0.username');

        $this->assertEquals('Lamonte', $data);
    }

    public function testPHPLoaderNotEmptyWhenLoadedWithADifferentFileType()
    {
        $this->php_config->setExtension('php5');

        $data = $this->php_config->get('test.users.0.username');

        $this->assertNotEmpty($data);
    }

    public function testPHPLoaderItemObjectItemExists()
    {
        $test_data = $this->php_config->getItem('test');

        $this->assertNotEmpty($test_data->get('users.0.username'));
    }

    public function testPHPLoaderItemObjectItemValueEqualsValue()
    {
        $test_data = $this->php_config->getItem('test');

        $this->assertEquals('Lamonte', $test_data->get('users.0.username'));
    }
}