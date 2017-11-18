<?php
/**
 * Created by PhpStorm.
 * User: xjwhhh
 * Date: 2017/11/18
 * Time: 13:24
 */
class ResultMessage{
    public $result;

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

}