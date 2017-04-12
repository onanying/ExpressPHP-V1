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

    // 连接
    public static function connect($conf = null)
    {
        if (is_null($conf)) {
            $conf = Config::get('mysql');
        } else {
            self::$pdo = null;
        }
        if (!isset(self::$pdo)) {
            $pdoConf = [
                \PDO::ATTR_EMULATE_PREPARES   => false,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => $conf['default_fetch'] == 'object' ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC,
                \PDO::ATTR_ORACLE_NULLS       => $conf['null_to_string'] ? \PDO::NULL_TO_STRING : \PDO::NULL_NATURAL,
            ];
            switch ($conf['column_name_mode']) {
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
        }
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

    // 执行一条 SQL 语句，并返回结果集
    public static function query($sql, $data = [])
    {
        self::connect();
        list($sql, $params, $values) = self::prepare($sql, $data);
        $statement                   = self::$pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindParam(':' . $key, $value);
        }
        foreach ($values as $key => $value) {
            $statement->bindValue($key + 1, $value);
        }
        $statement->execute();
        return new Statement($statement);
    }

    // 执行一条 SQL 语句，并返回受影响的行数
    public static function execute($sql, $data = [])
    {
        return self::query($sql, $data)->rowCount();
    }

    // 将下划线命名转换为驼峰式命名
    public static function camelCase($name, $ucfirst = false)
    {
        $name = ucwords(str_replace('_', ' ', $name));
        $name = str_replace(' ', '', lcfirst($name));
        return $ucfirst ? ucfirst($name) : $name;
    }

}
