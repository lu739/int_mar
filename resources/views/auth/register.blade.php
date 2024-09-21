@extends('layouts.auth')

@section('title')
    Регистрация
@endsection

@section('content')
    <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
        <h1 class="mb-5 text-lg font-semibold">Регистрация</h1>
        <form class="space-y-3" action="{{ route('register') }}" method="post">
            @csrf
            <x-forms.input
                name="name"
                placeholder="Имя и фамилия"
                value="{{ old('name') }}"
                :isError="$errors->has('name')"
                required
            />
            @error('name')
            <x-forms.error>{{$message}}</x-forms.error>
            @enderror

            <x-forms.input
                name="email"
                type="email"
                placeholder="E-mail"
                value="{{ old('email') }}"
                :isError="$errors->has('email')"
                required
            />
            @error('email')
            <x-forms.error>{{$message}}</x-forms.error>
            @enderror

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <x-forms.input
                        name="password"
                        type="password"
                        placeholder="Пароль"
                        value="{{ old('password') }}"
                        :isError="$errors->has('password')"
                        required
                    />
                    @error('password')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror
                </div>
                <div>
                    <x-forms.input
                        name="password_confirmation"
                        type="password"
                        placeholder="Повторно пароль"
                        value="{{ old('password') }}"
                        :isError="$errors->has('password')"
                        required
                    />
                    @error('password_confirmation')
                    <x-forms.error>{{$message}}</x-forms.error>
                    @enderror
                </div>
            </div>
            <button type="submit" class="w-full btn btn-pink">Зарегистрироваться</button>
        </form>

        <div class="mt-3">
            <a href="{{route('socialite.github')}}" class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
                <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.475 0 0 4.475 0 10a9.994 9.994 0 0 0 6.838 9.488c.5.087.687-.213.687-.476 0-.237-.013-1.024-.013-1.862-2.512.463-3.162-.612-3.362-1.175-.113-.287-.6-1.175-1.025-1.412-.35-.188-.85-.65-.013-.663.788-.013 1.35.725 1.538 1.025.9 1.512 2.337 1.087 2.912.825.088-.65.35-1.088.638-1.338-2.225-.25-4.55-1.112-4.55-4.937 0-1.088.387-1.987 1.025-2.688-.1-.25-.45-1.274.1-2.65 0 0 .837-.262 2.75 1.026a9.28 9.28 0 0 1 2.5-.338c.85 0 1.7.112 2.5.337 1.912-1.3 2.75-1.024 2.75-1.024.55 1.375.2 2.4.1 2.65.637.7 1.025 1.587 1.025 2.687 0 3.838-2.337 4.688-4.562 4.938.362.312.675.912.675 1.85 0 1.337-.013 2.412-.013 2.75 0 .262.188.574.688.474A10.017 10.017 0 0 0 20 10c0-5.525-4.475-10-10-10Z" clip-rule="evenodd"/>
                </svg>
                <span class="grow text-xxs md:text-xs font-bold text-center">GitHub</span>
            </a>
        </div>

        <div class="space-y-3 mt-5">
            <div class="text-xxs md:text-xs">Есть аккаунт? <a href="{{route('signIn')}}" class="text-white hover:text-white/70 font-bold underline underline-offset-4">Войти</a></div>
        </div>
        <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-20">
            <li>
                <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium" target="_blank" rel="noopener">Пользовательское соглашение</a>
            </li>
            <li class="hidden md:block">
                <div class="h-full w-[2px] bg-white/20"></div>
            </li>
            <li>
                <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium" target="_blank" rel="noopener">Политика конфиденциальности</a>
            </li>
        </ul>
    </div>
@endsection
