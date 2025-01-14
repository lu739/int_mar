<footer class="footer py-8 sm:py-12 xl:py-16">
    <div class="container">
        <div class="flex flex-wrap lg:flex-nowrap items-center">
            <div class="footer-logo order-0 basis-full sm:basis-1/2 lg:basis-1/3 shrink-0 text-center sm:text-left">
                <a href="{{route('home')}}" class="inline-block" rel="home">
                    <img src="{{\Illuminate\Support\Facades\Vite::asset("resources/images/logo.svg")}}" class="w-[155px] h-[38px]" alt="Logo">
                </a>
            </div><!-- /.footer-logo -->
            <div class="footer-copyright order-2 lg:order-1 basis-full lg:basis-1/3 mt-8 lg:mt-0">
                <div class="text-[#999] text-xxs xs:text-xs sm:text-sm text-center">Int Mar, {{\Carbon\Carbon::now()->year}} © Все права защищены.</div>
            </div><!-- /.footer-copyright -->
            <div class="footer-social order-1 lg:order-2 basis-full sm:basis-1/2 lg:basis-1/3 mt-8 sm:mt-0">
                <div class="flex flex-wrap items-center justify-center sm:justify-end space-x-6">
                    <a href="#" class="inline-flex items-center text-white hover:text-pink" target="_blank" rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{\Illuminate\Support\Facades\Vite::asset("resources/images/icons/youtube.svg")}}" alt="YouTube">
                        <span class="ml-2 lg:ml-3 text-xxs font-semibold">YouTube</span>
                    </a>
                    <a href="#" class="inline-flex items-center text-white hover:text-pink" target="_blank" rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{\Illuminate\Support\Facades\Vite::asset("resources/images/icons/telegram.svg")}}" alt="Telegram">
                        <span class="ml-2 lg:ml-3 text-xxs font-semibold">Telegram</span>
                    </a>
                </div>
            </div><!-- /.footer-social -->
        </div>
    </div><!-- /.container -->
</footer>

{{--@@include('../parts/mobile-menu.html')--}}

{{--@@include('../parts/modals.html')--}}
