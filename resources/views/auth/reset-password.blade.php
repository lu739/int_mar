@extends('layouts.auth')

@section('title')
    Восстановить пароль
@endsection

@section('content')
    <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
        <h1 class="mb-5 text-lg font-semibold">Восстановление пароля</h1>
        <form class="space-y-3" action="{{route('password.update')}}" method="post">
            @csrf

            <input name="token" hidden value="{{request('token')}}">
            <x-forms.input
                name="email"
                type="email"
                placeholder="E-mail"
                value="{{ request('email') }}"
                :isError="$errors->has('email')"
                required
            />
            @error('email')
            <x-forms.error>{{$message}}</x-forms.error>
            @enderror

            <x-forms.input
                name="password"
                type="password"
                placeholder="Пароль"
                :isError="$errors->has('password')"
                required
            />
            @error('password')
            <x-forms.error>{{$message}}</x-forms.error>
            @enderror

            <x-forms.input
                name="password_confirmation"
                type="password"
                placeholder="Повторите пароль"
                :isError="$errors->has('password_confirmation')"
                required
            />

            <button type="submit" class="w-full btn btn-pink">Обновить пароль</button>
        </form>
    </div>
@endsection
