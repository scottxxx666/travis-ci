<?php
/**
 * Created by PhpStorm.
 * User: kaokaokao
 * Date: 2019-01-18
 * Time: 23:49
 */

namespace App;

interface ITokenDao
{
    public function getRandom($account);
}