<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 08:35
 */

namespace App;

class OrderService
{
    private $filePath = __DIR__ . '/testOrders.csv';
    private $book;

    public function __construct(IBookDao $book = null)
    {
        $this->book = $book ?? new BookDao();
    }

    public function syncBookOrders()
    {
        $orders = $this->getOrders();
        // only get orders of book
        $ordersOfBook = array_filter($orders, function ($order) {
            return $order->type === 'Book';
        });

        foreach ($ordersOfBook as $order) {
            $this->book->insert($order);
        }
    }

    protected function getOrders()
    {
        // parse csv file to get orders
        return array_map(function ($line) {
            return $this->mapping($line);
        }, array_map('str_getcsv', file($this->filePath)));
    }

    private function mapping($line)
    {
        $order = new Order;
        $order->productName = $line[0];
        $order->type = $line[1];
        $order->price = (int)$line[2];
        $order->customerName = $line[3];

        return $order;
    }
}

