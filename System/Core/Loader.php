<?php

/**
 * 加载类
 * @author 刘健 <59208859>
 */
class TP_Loader
{

    protected $instance;
    protected $base;

    public function __construct($base = null)
    {
        $this->instance = get_instance();
        $this->base = $base;
    }

    // 控制器
    public function controller($file_path, $params = null)
    {
        $info = __parse_path($file_path);
        $info['file_name'] = ucfirst(strtolower($info['file_name']));
        if (!$this->check_loaded($info['file_name'])) {
            // 包含文件
            __include('Controller' . $info['file_dir'], $info['file_name'], true);
            // 装载对象
            $this->load_object($info['file_name'], $params);
        }
    }

    // 模型
    public function model($file_path, $params = null)
    {
        $info = __parse_path($file_path);
        if (!$this->check_loaded($info['file_name'])) {
            // 包含文件
            __include('Model' . $info['file_dir'], $info['file_name']);
            // 装载对象
            $this->load_object($info['file_name'], $params);
        }
    }

    // 类库
    public function library($file_path, $params = null)
    {
        $info = __parse_path($file_path);
        if (!$this->check_loaded($info['file_name'])) {
            // 包含文件
            __include('Library' . $info['file_dir'], $info['file_name']);
            // 装载对象
            $this->load_object($info['file_name'], $params);
        }
    }

    // 数据库驱动
    public function db($file_path, $params = null)
    {
        $info = __parse_path($file_path);
        if (!$this->check_loaded($info['file_name'])) {
            // 包含文件
            __include('Db' . $info['file_dir'], $info['file_name']);
            // 装载对象
            $this->load_object($info['file_name'], $params);
        }
    }

    // 辅助函数
    public function helper($file_path)
    {
        $info = __parse_path($file_path);
        // 包含文件
        __include('Helper' . $info['file_dir'], $info['file_name']);
    }

    // 视图
    public function view($__file_path__, $data = null)
    {
        // 申明变量
        $keys = array_keys($data);
        foreach ($keys as $key) {
            $$key = $data[$key];
        }
        // 载入视图
        $__info__ = __parse_path($__file_path__);
        $__file_path__ = APP_PATH . 'View' . $__info__['file_dir'] . DIRECTORY_SEPARATOR . $__info__['file_name'] . '.php';
        if (!file_exists($__file_path__)) {
            show_error('[ Can not find a file ] ' . $__file_path__);
        }
        include $__file_path__;
    }

    // 装载对象
    protected function load_object($class_name, $params)
    {
        // 新建对象
        $this->instance->$class_name = (is_null($params) ? new $class_name : new $class_name($params));
        // 加入引用
        if (!is_null($this->base)) {
            $this->base->$class_name = &$this->instance->$class_name;
        }
    }

    // 检查载入状态
    protected function check_loaded($class_name)
    {
        return isset($this->instance->$class_name);
    }

}
