<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>
    <div class="flex items-center justify-between gap-3 mb-2">
        <span class="text-body text-xxs font-medium">От, ₽</span>
        <span class="text-body text-xxs font-medium">До, ₽</span>
    </div>
    <div class="flex items-center gap-3">
        <input type="number"
               id="{{ $filter->id('from') }}"
               name="{{ $filter->name('from') }}"
               value="{{ $filter->requestValue('from', $filter->values()['from']) }}"
               class="w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
               placeholder="От">
        <span class="text-body text-sm font-medium">–</span>
        <input type="number"
               id="{{ $filter->id('to') }}"
               name="{{ $filter->name('to') }}"
               value="{{ $filter->requestValue('to', $filter->values()['to']) }}"
               class="w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
               placeholder="До">
    </div>
</div>


