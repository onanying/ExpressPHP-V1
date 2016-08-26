<?php

/**
 * 自动加载类
 * @author 刘健 <59208859>
 */
class Autoload
{

    protected $instance;
    protected $base;

    public function __construct($base = null)
    {
        $this->instance = &get_instance();
        $this->base = $base;
    }

    // 控制器
    public function controller($file_name, $params = null)
    {
        _include('Common', 'Controller');
        _include('Controller', $file_name);
        $this->newObject($file_name, $params);
    }

    // 模型
    public function model($file_name, $params = null)
    {
        _include('Common', 'Model');
        _include('Model', $file_name);
        $this->newObject($file_name, $params);
    }

    // 类库
    public function library($file_name, $params = null)
    {
        _include('Library', $file_name);
        $this->newObject($file_name, $params);
    }

    // 数据库驱动
    public function db($file_name, $params = null)
    {
        _include('Db', $file_name);
        $this->newObject($file_name, $params);
    }

    // 辅助函数
    public function helper($file_name)
    {
        _include('Helper', $file_name);
    }

    // 视图
    public function view($file_name, $data = null)
    {
        // 申明变量
        $keys = array_keys($data);
        foreach ($keys as $key) {
            $$key = $data[$key];
        }
        // 载入视图
        $file_path = APP_PATH . 'View' . DIRECTORY_SEPARATOR . $file_name . '.php';
        if (!file_exists($file_path)) {
            throw new Exception('Error 404');
        }
        include $file_path;
    }

    // 装载对象
    private function newObject($file_name, $params)
    {
        // 新建对象
        if (!isset($this->instance->$file_name)) {
            $this->instance->$file_name = (is_null($params) ? new $file_name : new $file_name($params));
        }
        // 加入引用
        if (!is_null($this->base)) {
            $this->base->$file_name = &$this->instance->$file_name;
        }
    }

}
