<?php
/**
 * Created by PhpStorm.
 * User: kaokaokao
 * Date: 2019-01-29
 * Time: 03:25
 */

namespace App;

interface IBookDao
{
    public function insert(Order $order);
}