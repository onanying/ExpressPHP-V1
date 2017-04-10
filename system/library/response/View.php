<?php

/**
 * View类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys\response;

class View
{

    // 模板变量
    private $data = [];

    // 模板地址
    private $template;

    public function __construct($template = null, $data = [])
    {
        $this->template = $template;
        $this->data     = $data;
    }

    // 创建实例
    public static function create($template = null, $data = [])
    {
        return new self($template, $data);
    }

    // 设置模板地址
    public function fetch($template)
    {
        $this->template = $template;
        return $this;
    }

    // 变量赋值
    public function assign($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    // 输出
    public function output()
    {
        if (isset($this->template)) {
            echo self::import($this->template, $this->data);
        }
        exit;
    }

    // 导入视图文件
    protected static function import($template, $data)
    {
        // 传入变量
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        // 生成视图
        $filePath = APP_PATH . str_replace('.', DS, $template) . '.php';
        if (!is_file($filePath)) {
            throw new \sys\exception\ViewException('视图文件不存在', $template);
        }
        include $filePath;
        return ob_get_clean();
    }

    // 判断视图是否存在
    public static function has($template)
    {
        $filePath = APP_PATH . str_replace('.', DS, $template) . '.php';
        return is_file($filePath);
    }

}
