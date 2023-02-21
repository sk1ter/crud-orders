<div>
    <div class="py-12" x-data="{products: []}" x-init="products = @json(old('products', $order?->product_list ?? []))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit.prevent="saveOrder">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Common information') }}
                        </h2>
                    </header>
                    <div class="flex w-full  mb-4">
                        <div class="flex-1 mr-4">
                            <div>
                                <x-input-label for="order_date" :value="__('Order date')"/>
                                <x-text-input id="order_date" name="order_date" wire:model="order_date" type="text"
                                              class="mt-1 block w-full"
                                              required autofocus autocomplete="off"/>
                                <x-input-error class="mt-2" :messages="$errors->get('order_date')"/>
                            </div>
                            <div>
                                <x-input-label for="phone" :value="__('Phone')"/>
                                <x-text-input id="phone" wire:model="phone" name="phone" type="text"
                                              class="mt-1 block w-full"
                                              autofocus autocomplete="off"/>
                                <x-input-error class="mt-2" :messages="$errors->get('phone')"/>
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')"/>
                                <x-text-input id="email" wire:model="email" name="phone" type="text"
                                              class="mt-1 block w-full"
                                              autofocus autocomplete="off"/>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                            </div>
                            <div>
                                <x-input-label for="address" :value="__('Address')"/>
                                <x-text-input id="address" wire:model="address" name="address" type="text"
                                              class="mt-1 block w-full"
                                              required autofocus autocomplete="off"/>
                                <x-input-error class="mt-2" :messages="$errors->get('address')"/>
                                <input type="hidden" wire:model="address_latitude" name="address_latitude"
                                       id="address_latitude"/>
                                <input type="hidden" wire:model="address_longitude" name="address_longitude"
                                       id="address_longitude"/>
                            </div>
                        </div>
                        <div class="flex-1" wire:ignore>
                            <div id="map" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                    <div>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Products') }}
                            </h2>
                        </header>
                        <div class="flex mb-4">
                            <div class="flex-1 mr-4">
                                <div class="relative">
                                    <x-input-label for="product_name" :value="__('Product')"/>
                                    <x-text-input id="product_name" name="product_name" type="text"
                                                  class="mt-1 block w-full"
                                                  autofocus autocomplete="off" wire:model="term"
                                                  wire:keyup="search"/>

                                    @if(!empty($term))
                                        <div x-on:click.away="$wire.clear()"
                                             class="absolute z-10 w-full overflow-x-auto max-h-72 divide-y divide-gray-200 bg-white rounded-t-none shadow-lg">
                                            @if(!empty($suggested_products))
                                                @foreach($suggested_products as $key => $product)
                                                    <div
                                                        wire:key="{{$product['id']}}"
                                                        wire:click="$emit('addProduct', {{$product['id']}})"
                                                        class="p-3 hover:bg-gray-300 cursor-pointer"
                                                    >{{ $product['name'] }}</div>
                                                @endforeach
                                            @else
                                                <div
                                                    class="p-3 hover:bg-gray-300 cursor-pointer">{{__('No results!')}}</div>
                                            @endif
                                        </div>
                                    @endif
                                    <x-input-error class="mt-2" :messages="$errors->get('products')"/>
                                </div>
                            </div>
                            <div class="flex-1"></div>
                        </div>
                        <table class="w-full mb-3 text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{__('Product name')}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__('Quantity')}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__('Price')}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__('Action')}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($products))
                                @foreach($products as $idx => $product)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$product['name']}}
                                            <input type="hidden" name="product[id]" value="{{$product['id']}}">
                                        </th>
                                        <th scope="row" wire:
                                            x-on:blur="$wire.emit('quantityChange', {id: {{$product['id']}}, quantity: $event.target.innerHTML})"
                                            contenteditable=""
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$product['quantity'] ?? 0}}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{number_format($product['price'] / 100)}}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <button class="text-blue-600"
                                                    wire:click="deleteProduct({{$product['id']}})">[{{__('Delete')}}]
                                            </button>
                                        </th>
                                    </tr>
                            @endforeach
                            @endif
                            <tfoot>
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="px-6 py-3 text-base">{{__('Total')}}</th>
                                {{--                                <td class="px-6 py-3">3</td>--}}
                                <td colspan="2" class="px-6 py-3">{{$this->overall_amount}}</td>
                            </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

</div>
@section('js')
    @vite(['resources/js/page-specific/order-store.js'])
    <script src="https://api-maps.yandex.ru/2.1/?apikey=28433c1b-ec9c-4a65-b16c-b74ceca19825&lang=ru_RU"
            type="text/javascript">
    </script>
    <script>
        document.addEventListener('livewire:load', function () {
            const that = @this;
            ymaps.ready(init);
            let selected = [that.address_latitude ?? 55.72281362564907, that.address_longitude ?? 37.6300436401367]

            function init() {
                let myPlacemark = createPlacemark(selected)
                myMap = new ymaps.Map('map', {
                    center: selected,
                    zoom: 10
                }, {
                    searchControlProvider: 'yandex#search'
                });
                myMap.geoObjects.add(myPlacemark);
                getAddress(myPlacemark.geometry.getCoordinates());
                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    that.setAddressLatitude(coords[0] ?? "")
                    that.setAddressLongitude(coords[1] ?? "")
                    if (myPlacemark) {
                        myPlacemark.geometry.setCoordinates(coords);
                    } else {
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        myPlacemark.events.add('dragend', function () {
                            getAddress(myPlacemark.geometry.getCoordinates());
                        });
                    }
                    getAddress(coords);
                });

                // Creating a placemark
                function createPlacemark(coords) {
                    return new ymaps.Placemark(coords, {
                        iconCaption: 'searching...'
                    }, {
                        preset: 'islands#violetDotIconWithCaption',
                        draggable: true
                    });
                }

                function getAddress(coords) {
                    myPlacemark.properties.set('iconCaption', 'searching...');
                    ymaps.geocode(coords).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0);
                        that.setAddress(firstGeoObject.getAddressLine())
                        myPlacemark.properties
                            .set({
                                iconCaption: [
                                    firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                    firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                                ].filter(Boolean).join(', '),
                                balloonContent: firstGeoObject.getAddressLine()
                            });
                    });
                }
            }
        })

    </script>
@stop
