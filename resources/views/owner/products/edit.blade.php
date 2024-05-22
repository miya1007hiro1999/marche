<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="error-index text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('owner.products.update',['product' => $product->id]) }}">
                        @csrf
                        <div class=" -m-2">
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                <input type="text" id="name" name="name" required value="{{ $product->name }}"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                                <textarea id="information" name="information" required rows="10"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ $product->information }}
                                </textarea>
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                                <input type="number" id="price" name="price" required value="{{ $product->price }}"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="sort_order" class="leading-7 text-sm text-gray-600">並び順 </label>
                                <input type="number" id="sort_order" name="sort_order" value="{{ $product->sort_order }}"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="current_quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                                <input type="hidden" id="current_quantity" name="current_quantity" required
                                    value="{{ $quantity }}"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded text-base outline-none text-gray-700 py-1 px-3 leading-8">{{$quantity}}</div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative flex justify-around">
                                    <input type="radio" name="type" value="1" checked>追加
                                    <input type="radio" name="type" value="2">削減
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="current_quantity" class="leading-7 text-sm text-gray-600">数量 ※必須</label>
                                <input type="number" id="quantity" name="quantity" required
                                    value="0"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <span >数量は１～９９で指定してください</span>
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗 </label>
                                <select name="shop_id" id="shop_id"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}" @if($shop->id === $product->shop_id) @endif>
                                            {{ $shop->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー </label>
                                <select name="category" id="category"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach ($category->secondary as $secondary)
                                                <option value="{{ $secondary->id }}" @if($secondary->id === $product->secondary_category_id) @endif>
                                                    {{ $secondary->name }}
                                                </option>
                                            @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <x-select-image :images="$images" name="image1" currentId="{{$product->image1}}" currentImage="{{$product->imageFirst->filename ?? ''}}"/>
                        <x-select-image :images="$images" name="image2" currentId="{{$product->image2}}" currentImage="{{$product->imageSecond->filename ?? ''}}" />
                        <x-select-image :images="$images" name="image3" currentId="{{$product->image3}}" currentImage="{{$product->imageThird->filename ?? ''}}"/>
                        <x-select-image :images="$images" name="image4" currentId="{{$product->image4}}" currentImage="{{$product->imageFourth->filename ?? ''}}"/>
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="relative flex justify-around">
                                <input type="radio" name="is_selling" value="1"  @if($product->is_selling === 1){ checked } @endif>販売中
                                <input type="radio" name="is_selling" value="0"  @if($product->is_selling === 1){ checked } @endif>停止中
                            </div>
                        </div>
                        <div class="flex justify-around p-2 w-full mt-4">
                            <button type="submit"
                                class=" text-white bg-indigo-500 border-0 py-4 px-12 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            <button type="button" onclick="location.href='{{ route('owner.products.index') }}'"
                                class=" text-black bg-gray-500 border-0 py-4 px-12 focus:outline-none hover:bg-gray-700 rounded text-lg">戻る</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        'use strict'
        const images = document.querySelectorAll('.image')

        images.forEach(image => {
            image.addEventListener('click', function(e) {
                const imageName = e.target.dataset.id.substr(0, 6)
                const imageId = e.target.dataset.id.replace(imageName + '_', '')
                const imageFile = e.target.dataset.file
                const imagePath = e.target.dataset.path
                const modal = e.target.dataset.modal
                document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
                document.getElementById(imageName + '_hidden').value = imageId
                MicroModal.close(modal);
            }, )
        });
    </script>
</x-app-layout>
