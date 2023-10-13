<div>
    <div x-data="{
        observe () {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        @this.call('fetchData')
                        observer.unobserve(entry.target)
                    }
                })
            }, {
                root: null
            })

            observer.observe(this.$el)
        }
    }"
    x-init="observe"></div>
    <input wire:model.debounce.500ms="search" type="text" class="mb-2 border border-gray-300 rounded-md" />
    <div class="grid grid-cols-3 gap-3">
        @foreach([0,1,2] as $eachIndex)
        <div x-data="{ hover: false }">
            @foreach($this->imgs[$eachIndex] as $ind => $eachImg)
                <div class="relative" x-on:mouseover="hover = true" x-on:mouseout="hover = false">
                    <img src="{{ $eachImg['urls']['thumb'] }}" class="w-full mb-2" />
                    <div x-show="hover" class="absolute p-5 top-0 left-0 right-0 bottom-0 flex flex-col justify-between">
                        <span></span>
                        <div class="flex justify-between">
                            <div class="flex grow items-center">
                                <img class="rounded-full" src="{{ $eachImg['user']['profile_image']['small'] }}" />
                                <span class="ml-1">{{ $eachImg['user']['name'] }}</span>
                            </div>
                            <button class="btn-primary btn-sm" wire:click="unsplashSelect({{ $eachIndex }}, {{ $ind }})">Insert image</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endforeach
        <div
            x-data="{
                observe () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadMore')
                            }
                        })
                    }, {
                        root: null
                    })
        
                    observer.observe(this.$el)
                }
            }"
            x-init="observe"
        ></div>
    </div>
</div>

