<div class="relative" x-data="{ isVisible: true, selected: {id: null, price: null} }" @click.away="isVisible = false">
    <input
        wire:model.debounce.300ms="search"
        type="text"
        class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        placeholder=""
        x-ref="search"
        id="x-select-id"
        @focus="isVisible = true"
        @keydown.escape.window = "isVisible = false"
        @keydown="isVisible = true"
        @keydown.shift.tab="isVisible = false"
    >
    <input type="hidden" x-bind:value="selected.id" name="product-id" id="product-id">
    <input type="hidden" x-bind:value="selected.price" name="product-price" id="product-price">
    <div wire:loading class="spinner top-0 right-0 mr-4 mt-1" style="position: absolute"></div>

    @if (strlen($search) >= 2)
        <div class="absolute w-full z-50 bg-white text-xs rounded mt-1" x-show.transition.opacity.duration.200="isVisible">
            @if (count($searchResults) > 0)
                <ul>
                    @foreach ($searchResults as $result)
                        <li class="border-b border-gray-700">
                            <div
                                @click="selected.id = {{$result['value']}}; selected.price = {{$result['price']}}; isVisible = false; document.querySelector('#x-select-id').value = '{{$result['title']}}'"
                                class="block hover:bg-gray-200 flex items-center transition ease-in-out duration-150 px-3 py-3"
                                @if ($loop->last) @keydown.tab="isVisible=false" @endif
                            >
                                <span class="ml-4">{{ $result['title'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">No results for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>
