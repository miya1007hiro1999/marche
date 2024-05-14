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
                    <form method="POST" action="{{ route('owner.shops.update', ['shop' => $shop->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class=" -m-2">
                            <div class="p-2 w-1/2 mx-auto elative">
                                <label for="name"
                                    class="leading-7 text-sm text-gray-600">店名 ※必須</label>
                                <input type="text" id="name" name="name" required
                                    value="{{ $shop->name }}"  
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="p-2 w-1/2 mx-auto relative">
                                <label for="information"
                                    class="leading-7 text-sm text-gray-600">店舗情報 ※必須</label>
                                <textarea id="information" name="information" required  rows="10"
                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ $shop->information }}
                                </textarea>
                            </div>
                            <div class="w-32 p-2 w1/2 mx-auto">
                                <div class="relative">    
                                    <x-shop-thumbnail :filename="$shop->filename"/>
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    <input type="file" id="image" name="image"
                                        accept="image/png,image/jpeg,image/jpg"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative flex justify-around">
                                    <input type="radio" name="is_selling" value="1" @if($shop->is_selling === 1){ checked } @endif>販売中
                                    <input type="radio" name="is_selling" value="0" @if($shop->is_selling === 0){ checked } @endif>停止中
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-around p-2 w-full mt-4">
                            <button type="submit"
                                class=" text-white bg-indigo-500 border-0 py-4 px-12 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                            <button type="button" onclick="location.href='{{ route('owner.shops.index') }}'"
                                class=" text-black bg-gray-500 border-0 py-4 px-12 focus:outline-none hover:bg-gray-700 rounded text-lg">戻る</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
