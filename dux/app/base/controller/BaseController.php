<?php

/**
 * 基础控制器
 */
namespace app\base\controller;

class BaseController extends \dux\kernel\Controller {

    protected $configDir;
    protected $publicUrl;
    protected $sysInfo;
    protected $session;

    public function __construct() {
        parent::__construct();
        $lock = ROOT_PATH . 'install.lock';
        if (!is_file($lock)) {
            $this->redirect(url('install/Index/index'));
            exit;
        }
        $this->configDir = APP_PATH . APP_NAME . 'config/';
        $this->publicUrl = ROOT_URL . '/public';
        $this->sysInfo = \Config::get('dux.use_info');
        //加载基础函数
        require_once(APP_PATH . 'base/util/Function.php');
        //引入当前模块配置
        $configFile = $this->configDir . 'config.php';
        $config = [];
        if (is_file($configFile)) {
            $config = require($configFile);
        }
        if (!empty($config)) {
            \Config::set($config);
        }

    }
    




}