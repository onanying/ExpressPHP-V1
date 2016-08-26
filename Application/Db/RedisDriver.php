<?php

/**
 * ------------------------------------------
 * redis 模型
 * @author 刘健 <59208859@qq.com>
 * ------------------------------------------
 *
 * 统一redis的配置与数据存储规范，便于扩展与修改
 *
 * # redis通常用于热数据与消息列队等场景
 * # list内存储array是采用json格式
 *
 */

class RedisDriver
{

    protected $redis; // redis对象
    protected $ip = '127.0.0.1'; // redis服务器ip地址
    protected $port = '6379'; // redis服务器端口
    protected $passwd = ''; // redis密码

    public function __construct($config = array())
    {
        $this->redis = new Redis();
        empty($config) or $this->connect($config);
    }

    // 连接redis服务器
    public function connect($config = array())
    {
        if (!empty($config)) {
            $this->ip = $config['ip'];
            $this->port = $config['port'];
            if (isset($config['passwd'])) {
                $this->passwd = $config['passwd'];
            }
        }
        $state = $this->redis->connect($this->ip, $this->port);
        if ($state == false) {
            die('redis connect failure');
        }
        if ($this->passwd != '') {
            $this->redis->auth($this->passwd);
        }
    }

    // 设置一条String
    public function setString($key, $text, $expire = null)
    {
        $key = 'string:' . $key;
        $this->redis->set($key, $text);
        if (!is_null($expire)) {
            $this->redis->setTimeout($key, $expire);
        }
    }

    // 获取一条String
    public function getString($key)
    {
        $key = 'string:' . $key;
        $text = $this->redis->get($key);
        return empty($text) ? null : $text;
    }

    // 删除一条String
    public function deleteString($key)
    {
        $key = 'string:' . $key;
        $this->redis->del($key);
    }

    // 设置一条array
    public function setArray($key, $arr, $expire = null)
    {
        $key = 'array:' . $key;
        $this->redis->hMset($key, $arr);
        if (!is_null($expire)) {
            $this->redis->setTimeout($key, $expire);
        }
    }

    // 获取一条Arrry
    public function getArray($key)
    {
        $key = 'array:' . $key;
        $arr = $this->redis->hGetAll($key);
        return empty($arr) ? null : $arr;
    }

    // 删除一条Array
    public function deleteArray($key)
    {
        $key = 'array:' . $key;
        $this->redis->del($key);
    }

    // 设置表格的一行数据
    public function setTableRow($table, $id, $arr, $expire = null)
    {
        $key = 'table:' . $table . ':' . $id;
        $this->redis->hMset($key, $arr);
        if (!is_null($expire)) {
            $this->redis->setTimeout($key, $expire);
        }
    }

    // 获取表格的一行数据，$fields可为字符或数组
    public function getTableRow($table, $id, $fields = null)
    {
        $key = 'table:' . $table . ':' . $id;
        if (is_null($fields)) {
            $arr = $this->redis->hGetAll($key);
        } else {
            if (is_array($fields)) {
                $arr = $this->redis->hmGet($key, $fields);
            } else {
                $arr = $this->redis->hGet($key, $fields);
            }
        }
        return empty($arr) ? null : $arr;
    }

    // 删除表格的一行数据
    public function deleteTableRow($table, $id)
    {
        $key = 'table:' . $table . ':' . $id;
        $this->redis->del($key);
    }

    // 推送一条数据至列表，头部
    public function pushList($key, $arr)
    {
        $key = 'list:' . $key;
        $this->redis->lPush($key, json_encode($arr));
    }

    // 从列表拉取一条数据，尾部
    public function pullList($key, $timeout = 0)
    {
        $key = 'list:' . $key;
        if ($timeout > 0) {
            $val = $this->redis->brPop($key, $timeout); // 该函数返回的是一个数组, 0=key 1=value
        } else {
            $val = $this->redis->rPop($key);
        }
        $val = is_array($val) && isset($val[1]) ? $val[1] : $val;
        return empty($val) ? null : $this->objectToArray(json_decode($val));
    }

    // 取得列表的数据总条数
    public function getListSize($key)
    {
        $key = 'list:' . $key;
        return $this->redis->lSize($key);
    }

    // 删除列表
    public function deleteList($key)
    {
        $key = 'list:' . $key;
        $this->redis->del($key);
    }

    // 使用递归，将stdClass转为array
    protected function objectToArray($obj)
    {
        if (is_object($obj)) {
            $arr = (array) $obj;
        }
        if (is_array($obj)) {
            foreach ($obj as $key => $value) {
                $arr[$key] = $this->objectToArray($value);
            }
        }
        return !isset($arr) ? $obj : $arr;
    }

}
