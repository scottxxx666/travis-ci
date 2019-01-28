<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 08:37
 */

namespace Tests;

use App\IBookDao;
use App\Order;
use App\OrderService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    use  MockeryPHPUnitIntegration;
    private $book_spy;

    protected function setUp()
    {
        $this->book_spy = Mockery::spy(IBookDao::class);
        parent::setUp();
    }

    public function test_sync_book_orders_3_orders_only_2_book_order()
    {
        $orders = $this->givenOrders(['Book', 'Book', 'Else']);

        $this->whenSyncBookOrders($orders);

        $this->bookShouldInsert(2);
    }

    protected function givenOrders($types)
    {
        return array_map(function ($value) {
            $order = new Order();
            $order->type = $value;
            return $order;
        }, $types);
    }

    protected function bookShouldInsert($times): void
    {
        $this->book_spy->shouldHaveReceived('insert')->times($times);
    }

    protected function whenSyncBookOrders(array $orders): void
    {
        $target = Mockery::mock(OrderService::class, [$this->book_spy])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $target->shouldReceive('getOrders')->andReturn($orders);
        $target->syncBookOrders();
    }
}
