<?php

/**
 * Mysql类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

use sys\mysql\Statement;

class Mysql
{

    // pdo
    private static $pdo;

    // 回滚含有零影响行数的事务
    private static $rollbackZeroAffected;

    // 是否为事务
    private static $isTransaction;

    // 连接
    public static function connect($conf = null)
    {
        if (!isset(self::$pdo)) {
            if (is_null($conf)) {
                $conf = Config::get('mysql');
            }
            $pdoConf = [
                \PDO::ATTR_EMULATE_PREPARES   => false,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => $conf['default_fetch'] == 'object' ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC,
                \PDO::ATTR_ORACLE_NULLS       => $conf['null_to_string'] ? \PDO::NULL_TO_STRING : \PDO::NULL_NATURAL,
            ];
            switch ($conf['force_column_name']) {
                case 'lower':
                    $pdoConf[\PDO::ATTR_CASE] = \PDO::CASE_LOWER;
                    break;
                case 'upper':
                    $pdoConf[\PDO::ATTR_CASE] = \PDO::CASE_UPPER;
                    break;
                default:
                    $pdoConf[\PDO::ATTR_CASE] = \PDO::CASE_NATURAL;
                    break;
            }
            self::$pdo = new \PDO(
                'mysql:host=' . $conf['hostname'] . ';port=' . $conf['hostport'] . ';charset=' . $conf['charset'] . ';dbname=' . $conf['database'],
                $conf['username'],
                $conf['password'],
                $pdoConf
            );
            self::$rollbackZeroAffected = $conf['transaction']['rollback_zero_affected'];
        }
    }

    // 执行一条 SQL 语句，并返回结果集
    public static function query($sql, $data = [])
    {
        self::connect();
        self::connect();
        list($sql, $params, $values) = self::prepare($sql, $data);
        $statement                   = self::$pdo->prepare($sql);
        foreach ($params as $key => &$value) {
            $statement->bindParam($key, $value);
        }
        foreach ($values as $key => &$value) {
            $statement->bindValue($key + 1, $value);
        }
        $statement->execute();
        return new Statement($statement);
    }

    // 执行一条 SQL 语句，并返回受影响的行数
    public static function execute($sql, $data = [])
    {
        $affectedRows = self::query($sql, $data)->rowCount();
        if (self::$isTransaction && self::$rollbackZeroAffected && $affectedRows == 0) {
            throw new \Exception('事物内查询的影响行数为零');
        }
        return $affectedRows;
    }

    // 自动事务
    public static function transaction($func)
    {
        self::beginTransaction();
        try {
            $func();
            // 提交事务
            self::commit();
        } catch (\Exception $e) {
            // 回滚事务
            self::rollBack();
        }
    }

    // 开始事务
    public static function beginTransaction()
    {
        self::connect();
        self::$pdo->beginTransaction();
        self::$isTransaction = true;
    }

    // 提交事务
    public static function commit()
    {
        self::$pdo->commit();
        self::$isTransaction = null;
    }

    // 回滚事务
    public static function rollBack()
    {
        self::$pdo->rollBack();
        self::$isTransaction = null;
    }

    // 预处理
    private static function prepare($sql, $data)
    {
        $params = $values = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $tmp = [];
                foreach ($value as $k => $v) {
                    $tmp[]    = '?';
                    $values[] = $v;
                }
                $sql = str_replace(':' . $key, implode(',', $tmp), $sql);
            } else {
                $params[$key] = $value;
            }
        }
        return [$sql, $params, $values];
    }

}
