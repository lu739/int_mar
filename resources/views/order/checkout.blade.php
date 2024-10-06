@extends('layouts.app')

@section('content')

    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href="{{route('home')}}" class="text-body hover:text-pink text-xs">Главная</a></li>
        <li><a href="{{route('cart')}}" class="text-body hover:text-pink text-xs">Корзина покупок</a></li>
        <li><span class="text-body text-xs">Оформление заказа</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <h1 class="mb-8 text-lg lg:text-[42px] font-black">Оформление заказа</h1>

        <form action="{{route('order.handle')}}" method="post"
              class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">
            @csrf

            <!-- Contact information -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Контактная информация</h3>
                <div class="space-y-3">
                    <x-forms.input
                        name="customer[first_name]"
                        placeholder="Имя"
                        value="{{ old('customer.first_name') }}"
                        :isError="$errors->has('customer.first_name')"
                        required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                    />
                    @error('customer.first_name')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror

                    <x-forms.input
                        name="customer[last_name]"
                        placeholder="Фамилия"
                        value="{{ old('customer.last_name') }}"
                        :isError="$errors->has('customer[last_name]')"
                        required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                    />
                    @error('customer.last_name')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror

                    <x-forms.input
                        name="customer[phone]"
                        placeholder="Номер телефона"
                        value="{{ old('customer.phone') }}"
                        :isError="$errors->has('customer[phone]')"
                        required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                    />
                    @error('customer.phone')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror

                    <x-forms.input
                        name="customer[email]"
                        type="email"
                        placeholder="E-mail"
                        value="{{ old('customer.email') }}"
                        :isError="$errors->has('customer[email]')"
                        required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                    />
                    @error('customer.email')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror

                    <div x-data="{
                        createAccount: {{ old('create_account') ? 'true' : 'false' }}
                    }">
                        <div class="py-3 text-body">Вы можете создать аккаунт после оформления заказа</div>
                        <div class="form-checkbox">
                            <input name="create_account"
                                   type="checkbox"
                                   :checked="createAccount"
                                   id="checkout-create-account">
                            <label for="checkout-create-account" class="form-checkbox-label"
                                   @click="createAccount = ! createAccount">Зарегистрировать аккаунт</label>
                        </div>
                        <div
                            x-show="createAccount"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-4 space-y-3"
                        >
                            <x-forms.input
                                name="customer[password]"
                                type="password"
                                placeholder="Придумайте пароль"
                                value="{{ old('customer.password') }}"
                                :isError="$errors->has('customer[password]')"
                                required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                            />
                            @error('customer.password')
                            <x-forms.error>{{$message}}</x-forms.error>
                            @enderror

                            <x-forms.input
                                name="customer[password_confirmation]"
                                type="password"
                                placeholder="Повторите пароль"
                                value="{{ old('customer.password_confirmation') }}"
                                :isError="$errors->has('customer[password_confirmation]')"
                                required class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                            />
                            @error('customer.password_confirmation')
                            <x-forms.error>{{$message}}</x-forms.error>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
<h1>
    @foreach($errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
</h1>
            <!-- Shipping & Payment -->
            <div class="space-y-6 2xl:space-y-8">

                <!-- Shipping-->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Способ доставки</h3>
                    <div class="space-y-5">
                        @foreach($delivery_types as $delivery_type)
                        <div class="form-radio">
                            <input type="radio"
                                   name="delivery_type_id"
                                   value="{{$delivery_type->id}}"
                                   id="delivery_type-{{$delivery_type->id}}">
                            <label for="delivery_type-{{$delivery_type->id}}"
                                   class="form-radio-label">{{$delivery_type->title}}</label>
                            @error('delivery_type_id')
                            <x-forms.error>{{$message}}</x-forms.error>
                            @enderror
                            @if($delivery_type->id === 2)
                                <input type="text"
                                       name="customer[city]"
                                       class="w-full mt-2 mb-2 h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                       placeholder="Город">
                                <input type="text"
                                       name="customer[address]"
                                       class="w-full mb-2 h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                       placeholder="Адрес">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment-->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Метод оплаты</h3>
                    <div class="space-y-5">
                        @foreach($payment_methods as $payment_method)
                            <div class="form-radio">
                                <input type="radio"
                                       value="{{$payment_method->id}}"
                                       name="payment_method_id"
                                       id="payment-method-{{$payment_method->id}}" checked>
                                <label for="payment-method-{{$payment_method->id}}" class="form-radio-label">{{$payment_method->title}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Checkout -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Заказ</h3>
                <table class="w-full border-spacing-y-3 text-body text-xxs text-left" style="border-collapse: separate">
                    <thead class="text-[12px] text-body uppercase">
                    <th scope="col" class="pb-2 border-b border-body/60">Товар</th>
                    <th scope="col" class="px-2 pb-2 border-b border-body/60">К-во</th>
                    <th scope="col" class="px-2 pb-2 border-b border-body/60">Сумма</th>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td scope="row" class="pb-3 border-b border-body/10">
                                <h4 class="font-bold"><a href="{{route('product.show', $item->product->slug)}}" class="inline-block text-white hover:text-pink break-words pr-3">SteelSeries Aerox 3 Snow</a></h4>
    {{--                            <ul>--}}
    {{--                                <li class="text-body">Цвет: Белый</li>--}}
    {{--                                <li class="text-body">Размер (хват): Средний</li>--}}
    {{--                            </ul>--}}
                            </td>
                            <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->quantity}} шт.</td>
                            <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->price}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-xs font-semibold text-right">Всего: {{$items_amount}}</div>

                <div class="mt-8 space-y-8">

                    <!-- Summary -->
                    <table class="w-full text-left">
                        <tbody>
                        <tr>
                            <th scope="row" class="pb-2 text-xs font-medium">Доставка:</th>
                            <td class="pb-2 text-xs">600 ₽</td>
                        </tr>
{{--                        <tr>--}}
{{--                            <th scope="row" class="pb-2 text-xs font-medium">Промокод:</th>--}}
{{--                            <td class="pb-2 text-xs">15 398 ₽</td>--}}
{{--                        </tr>--}}
                        <tr>
                            <th scope="row" class="text-md 2xl:text-lg font-black">Итого:</th>
                            <td class="text-md 2xl:text-lg font-black">245 930 ₽</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Process to checkout -->
                    <button type="submit" class="w-full btn btn-pink">Оформить заказ</button>
                </div>
            </div>

        </form>
    </section>

@endsection
