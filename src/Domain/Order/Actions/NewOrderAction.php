<?php

namespace Domain\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use App\Models\Order;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;

class NewOrderAction
{
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        $customer = $request->get('customer');

        if ($request->boolean('create_account')) {
            $registerAction(new NewUserDTO(
                $customer['first_name'] . ' ' . $customer['last_name'],
                $customer['email'],
                $customer['password'],
            ));
        }

        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'delivery_type_id' => $request->get('delivery_type_id'),
            'payment_method_id' => $request->get('payment_method_id'),
        ]);

        return $order;
    }
}
