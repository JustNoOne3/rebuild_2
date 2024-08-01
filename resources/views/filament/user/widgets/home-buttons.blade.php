
<x-filament-widgets::widget>
    <x-filament::section class="">
        <div class="grid grid-flow-col">
            @livewire('tele-modal')
            <x-filament::button wire:click="fwa" color="success" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/2.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap;">FLEXIBLE WORK ARRANGEMENT <br> / ALTERNATIVE WORK SCHEME <br> REPORT</a>
                </div>
            </x-filament::button>
        </div>
        <div class="grid grid-flow-col">
            {{-- <x-filament::button wire:click="teleReport" color="warning" size="xl" outlined style="margin: 15px;">
                <div class="grid grid-flow-rows">
                    <img src="{{asset('images/1.png')}}" alt="" class="mr-2 mx-auto" style="width: 240px;">
                    <a class="text-base text-center text-wrap" style="text-wrap: wrap;">TELECOMMUTING REPORT</a>
                </div>
            </x-filament::button> --}}
            @livewire('month13th-modal')
            @livewire('wair-modal')
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
