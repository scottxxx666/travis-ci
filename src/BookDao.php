<?php
/**
 * Created by PhpStorm.
 * User: kaokaokao
 * Date: 2019-01-29
 * Time: 03:42
 */

namespace App;

use Exception;

class BookDao implements IBookDao
{
    public function insert(Order $order)
    {
        // directly depend on some web service
        // $client = new HttpClient();
        // $response = $client->post("http://api.joey.io/Order", $order);
        // $response->statusCode();
        throw new Exception('Not implemented');
    }
}