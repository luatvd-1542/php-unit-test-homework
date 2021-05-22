<?php

namespace Modules\Exercise04\Tests\Unit\Services;

use Modules\Exercise05\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->orderService = app()->make(OrderService::class);
    }

    /**
     * @param array $params
     *
     *  @param array $result
     *
     * @dataProvider providerHandleDiscount
     */
    public function testHandleDiscount($params, $result)
    {
        $response = $this->orderService->handleDiscount($params);
       $this->assertEquals($result, $response);
    }

    public function providerHandleDiscount()
    {
        return [
            [
                ['price' => 1600, 'option_receive' => 1, 'option_coupon' => 1],
                ['price' => 1600, 'discount_pizza' => 'Khuyến mại pizza thứ 2', 'discount_potato' => 'Miễn phí khoai tây']
            ],
            [
                ['price' => 1400, 'option_receive' => 2, 'option_coupon' => 1],
                ['price' => 1120.0, 'discount_pizza' => null, 'discount_potato' => null]
            ],
            [
                ['price' => 1400, 'option_receive' => 2, 'option_coupon' => 2],
                ['price' => 1400, 'discount_pizza' => null, 'discount_potato' => null]
            ],
        ];
    }
}
