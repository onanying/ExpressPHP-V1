<?php

/**
 * Mysql类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

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
            self::$pdo = new \PDO(
                'mysql:host=' . $conf['hostname'] . ';port=' . $conf['hostport'] . ';charset=' . $conf['charset'] . ';dbname=' . $conf['database'],
                $conf['username'],
                $conf['password'],
                [
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                ]
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

    // 查询
    public static function query($sql, $data = [])
    {
        self::connect();
        list($sql, $params, $values) = self::prepare($sql, $data);
        $statement = self::$pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindParam(':' . $key, $value);
        }
        foreach ($values as $key => $value) {
            $statement->bindValue($key + 1, $value);
        }
        $statement->execute();
        return $statement;
    }

    // 执行
    public static function execute()
    {
        self::connect();
    }

}
