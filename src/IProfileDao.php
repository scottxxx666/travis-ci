<?php
/**
 * Created by PhpStorm.
 * User: kaokaokao
 * Date: 2019-01-18
 * Time: 23:44
 */

namespace App;

interface IProfileDao
{
    public function getPassword($account);
}