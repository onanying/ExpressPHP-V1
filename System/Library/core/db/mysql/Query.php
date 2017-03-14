<?php

namespace Library;

/**
 * mysqli驱动器
 * @author 刘健 <code.liu@qq.com>
 */
class MysqliDriver
{

    /* 内部参数 */
    protected $mysqli = '';
    protected $connectTimeout = 2;
    protected $transOpen = false;
    protected $allQuerySucc = false;

    /* 用户配置参数 */
    protected $host = 'localhost';
    protected $port = 3306;
    protected $username = 'root';
    protected $password = '';
    protected $database = '';
    protected $charset = 'utf8';
    protected $escapeString = true; // 转义字符串
    protected $backZeroAffect = true; // 事务内的sql影响数量为0，则rollback该事务

    /* 公共参数 */
    public $affectedRows = 0;

    public function __construct($config = array())
    {
        $this->mysqli = mysqli_init();
        empty($config) or $this->connect($config);
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }

    /**
     * 连接数据库
     * @param  array  $config [数据库配置参数]
     */
    public function connect($config = array())
    {
        // 配置参数
        foreach ($config as $key => $value) {
            if (isset($this->$key)) {
                $this->$key = $value;
            }
        }
        // 连接
        $this->mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $this->connectTimeout); // 设置超时时间
        $connect = @$this->mysqli->real_connect($this->host, $this->username, $this->password, $this->database, $this->port);
        if (!$connect) {
            throw new \Exception(sprintf('Connect Error: [%s] %s', $this->mysqli->connect_errno, $this->mysqli->connect_error));
        }
        // 设置编码
        if (!$this->mysqli->set_charset($this->charset)) {
            throw new \Exception(sprintf("Error loading character set utf8: [%s] %s", $this->mysqli->errno, $this->mysqli->error));
        }
    }

    /**
     * 执行查询
     */
    public function query()
    {
        // 获取参数
        $args = func_num_args();
        $argv = func_get_args();
        // 取出sql
        $sql = $argv[0];
        unset($argv[0]);
        // 处理字符串参数
        foreach ($argv as $key => $value) {
            if (!is_numeric($value)) {
                // 转义
                if ($this->escapeString) {
                    $argv[$key] = $this->mysqli->real_escape_string($argv[$key]);
                }
                // 加单引号
                $argv[$key] = "'{$argv[$key]}'";
            }
        }
        // 生成sql
        foreach ($argv as $key => $value) {
            if ($start = stripos($sql, '?')) {
                $sql = substr_replace($sql, $argv[$key], $start, 1);
            }
        }
        // 执行sql
        $resource = $this->mysqli->query($sql);
        // 设置影响的行数
        $this->affectedRows = $this->mysqli->affected_rows;
        // 返回数据
        if (is_bool($resource)) {
            if ($resource === false) {
                // sql执行失败
                throw new \Exception(sprintf("Error SQL: [%s] %s", $this->mysqli->errno, $this->mysqli->error));
            }
            if ($this->backZeroAffect && $this->transOpen && $this->affectedRows <= 0) {
                $this->allQuerySucc = false;
            }
            return $resource;
        } else {
            return new MysqliResult($resource);
        }
    }

    /**
     * 自动事务开始
     */
    public function transStart()
    {
        $this->transBegin();
    }

    /**
     * 自动事务完成 (自动提交或回滚)
     */
    public function transComplete()
    {
        if ($this->transStatus()) {
            $this->transCommit();
        } else {
            $this->transRollback();
        }
    }

    /**
     * 事务执行状态
     */
    public function transStatus()
    {
        return $this->allQuerySucc;
    }

    /**
     * 事务开始
     */
    public function transBegin()
    {
        $this->transOpen = true;
        $this->allQuerySucc = true;
        $this->mysqli->autocommit(false); // 关闭自动提交
    }

    /**
     * 事务提交
     */
    public function transCommit()
    {
        $this->mysqli->commit();
        $this->mysqli->autocommit(true); // 重新开启自动提交
        $this->transOpen = false;
    }

    /**
     * 事务回滚
     */
    public function transRollback()
    {
        $this->mysqli->rollback();
        $this->mysqli->autocommit(true); // 重新开启自动提交
        $this->transOpen = false;
    }

}
