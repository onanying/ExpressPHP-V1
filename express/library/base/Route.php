<?php

/**
 * Route类
 * @author 刘健 <code.liu@qq.com>
 */

namespace express\base;

class Route
{

    // 控制器命名空间
    public $controllerNamespace = 'www\controller';
    // 默认变量规则
    public $defaultPattern = '[\w-]+';
    // 路由变量规则
    public $patterns = [];
    // 路由规则
    public $rules = [
        ':controller/:action' => ':controller/:action',
    ];
    // 路由数据
    private $data = [];
    // 路由参数
    public $params = [];

    /**
     * 初始化
     * 生成路由数据，将路由规则转换为正则表达式，并提取路由参数名
     */
    public function init()
    {
        foreach ($this->rules as $rule => $action) {
            $fragment = explode('/', $rule);
            $params   = [];
            foreach ($fragment as $k => $v) {
                $prefix = substr($v, 0, 1);
                $fname  = substr($v, 1);
                if ($prefix == ':') {
                    if (isset($this->patterns[$fname])) {
                        $fragment[$k] = '(' . $this->patterns[$fname] . ')';
                    } else {
                        $fragment[$k] = '(' . $this->defaultPattern . ')';
                    }
                    $params[] = $fname;
                }
            }
            $this->data['/^' . implode('\/', $fragment) . '\/*$/i'] = [$action, $params];
        }
    }

    /**
     * 执行功能
     * @param  string $name
     */
    public function runAction($name)
    {
        $action = $this->matchAction($name);
        if ($action) {
            $action = "{$this->controllerNamespace}\\{$action}";
            // 实例化控制器
            $class     = dirname($action);
            $classPath = dirname($class);
            $className = $this->snakeToCamel(basename($class));
            $method    = $this->snakeToCamel(basename($action), true);
            $class     = "{$classPath}\\{$className}Controller";
            $method    = "action{$method}";
            try {
                $reflect = new \ReflectionClass($class);
            } catch (\ReflectionException $e) {
                throw new \express\exception\RouteException('控制器未找到', $class);
            }
            $controller = $reflect->newInstanceArgs();
            // 判断方法是否存在
            if (method_exists($controller, $method)) {
                // 执行控制器的方法
                return $controller->$method();
            }
        }
        throw new \express\exception\HttpException(404, 'URL不存在');
    }

    /**
     * 将蛇形命名转换为驼峰命名
     * @param  string  $name
     * @param  boolean $ucfirst
     * @return string
     */
    public static function snakeToCamel($name, $ucfirst = false)
    {
        $name = ucwords(str_replace('_', ' ', $name));
        $name = str_replace(' ', '', lcfirst($name));
        return $ucfirst ? ucfirst($name) : $name;
    }

    /**
     * 匹配功能
     * @param  [type] $name [description]
     * @return false or string
     */
    public function matchAction($name)
    {
        // 清空旧数据
        $this->params = [];
        // 匹配
        foreach ($this->data as $rule => $value) {
            list($action, $params) = $value;
            if (preg_match($rule, $name, $matches)) {
                // 保存参数
                foreach ($params as $k => $v) {
                    $this->params[$v] = $matches[$k + 1];
                }
                // 替换参数
                $fragment = explode('/', $action);
                foreach ($fragment as $k => $v) {
                    $prefix = substr($v, 0, 1);
                    $fname  = substr($v, 1);
                    if ($prefix == ':') {
                        if (isset($this->params[$fname])) {
                            $fragment[$k] = $this->params[$fname];
                        }
                    }
                }
                // 返回action
                return implode('\\', $fragment);
            }
        }
        return false;
    }

}
