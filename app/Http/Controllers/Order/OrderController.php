<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFormRequest;
use App\Models\DeliveryType;
use App\Models\Order;
use App\Models\PaymentMethod;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Processes\AssignCustomer;
use Domain\Order\Processes\AssignProducts;
use Domain\Order\Processes\ChangeStateToPending;
use Domain\Order\Processes\CheckProductQuantyties;
use Domain\Order\Processes\ClearCart;
use Domain\Order\Processes\DecreaseProductQuantyties;
use Domain\Order\Processes\OrderProcess;

class OrderController extends Controller
{
    public function checkout()
    {
        $items = cart()->getCartItems();

        if ($items->isEmpty()) {
            redirect()->route('home');
            // throw new \DomainException('Корзина пуста');
        }

        return view('order.checkout', [
            'items' => $items,
            'items_amount' => cart()->total(),
            'payment_methods' => PaymentMethod::all(),
            'delivery_types' => DeliveryType::all(),
        ]);
    }

    public function index()
    {
        $orders = auth()->check() ?
            auth()->user()->orders()
                ->with(['orderItems' => function ($query) {
                    $query->with('product');
                }])->get() :
            collect([]);

        return view('order.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $order
            ->load(['orderItems' => function ($query) {
                $query->with('product');
            }]);

        return view('order.show', compact('order'));
    }

    public function handle(OrderFormRequest $request, NewOrderAction $action)
    {
        $order = $action($request);

        (new OrderProcess($order))->processes([
            new CheckProductQuantyties(),
            new AssignCustomer(request('customer')),
            new AssignProducts(),
            new ChangeStateToPending(),
            new DecreaseProductQuantyties(),
            new ClearCart(),
        ])->run();

        return redirect()->route('home');
    }
}
