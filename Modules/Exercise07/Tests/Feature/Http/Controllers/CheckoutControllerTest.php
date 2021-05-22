<?php

namespace Modules\Exercise04\Tests\Feature\Http\Controllers;

use Modules\Exercise07\Http\Controllers\CheckoutController;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testIndex()
    {
        $response = $this->get(action([CheckoutController::class, 'index']));
        $response->assertViewIs('exercise07::checkout.index');
    }

    /**
     * @param array $inputs Request data
     *
     * @dataProvider providerDataValidateCheckoutFailed
     */

    public function testCheckoutRequest($inputs)
    {
        $response = $this->post(action([CheckoutController::class, 'store']), $inputs);
        $response->assertStatus(302)
            ->assertSessionHasErrors();
    }

    public function providerDataValidateCheckoutFailed()
    {
        return [
            [['amount' => '']],
            [['amount' => 'text']],
            [['amount' => -1]],
        ];
    }

    /**
     * @param array $inputs Request data
     *
     * @dataProvider providerDataTestStore
     */

    public function testStore($inputs)
    {
        $response = $this->post(action([CheckoutController::class, 'store'], $inputs));
        $response->assertStatus(302);
        $this->assertTrue($response->isRedirection());
        $response->assertSessionHas('order');
    }

    public function providerDataTestStore()
    {
        return [
            [['amount'=> 5000]],
            [['amount'=> 5000, 'shipping_express' => "on"]],
            [['amount'=> 5000, 'premium_member' => "on"]],
            [['amount'=> 5000, 'premium_member' => "on", 'shipping_express' => "on"]],
            [['amount'=> 100, 'premium_member' => "on", 'shipping_express' => "on"]],
            [['amount'=> 100, 'shipping_express' => "on"]],
            [['amount'=> 100, 'premium_member' => "on"]],
            [['amount'=> 100]],
        ];
    }
}
