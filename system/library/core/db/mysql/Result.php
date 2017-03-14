<?php

namespace Library;

/**
 * mysqli结果集
 * @author 刘健 <code.liu@qq.com>
 */
class MysqliResult
{

    protected $mysqli_result = '';

    const MYSQLI_OBJECT = 0;
    const MYSQLI_ARRAY = 1;

    public $numRows = '';
    public $currentField = '';
    public $fieldCount = '';
    public $lengths = '';

    public function __construct($mysqli_result)
    {
        $this->mysqli_result = $mysqli_result;
        /* 赋值 */
        $this->numRows = $mysqli_result->num_rows;
        $this->currentField = $mysqli_result->current_field;
        $this->fieldCount = $mysqli_result->field_count;
        $this->lengths = $mysqli_result->lengths;
    }

    /**
     * 返回全部查询结果，无数据返回**空数组**
     */
    public function result($resultType = self::MYSQLI_OBJECT)
    {
        $tmp = array();
        while ($row = $this->nextRow($resultType)) {
            $tmp[] = $row;
        }
        return $tmp;
    }

    /**
     * 这个方法返回单独一行结果。如果你的查询不止一行结果，它只返回第一行
     */
    public function row($resultType = self::MYSQLI_OBJECT)
    {
        $this->mysqli_result->data_seek(0);
        return $this->nextRow($resultType);
    }

    /**
     * 返回下一行
     */
    public function nextRow($resultType = self::MYSQLI_OBJECT)
    {
        return $resultType == self::MYSQLI_OBJECT ? $this->mysqli_result->fetch_object() : $this->mysqli_result->fetch_assoc();
    }

}
