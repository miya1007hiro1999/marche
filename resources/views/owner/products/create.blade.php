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
                    <form method="POST" action="{{ route('owner.products.store') }}">
                        @csrf
                        <div class=" -m-2">
                            <div class="p-2 w-1/2 mx-auto elative">
                                <select name="category" id="">
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach ($category->secondary as $secondary)
                                                <option value="{{ $secondary->id }}">
                                                    {{ $secondary->name }}
                                                </option>
                                            @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <x-select-image :images="$images" name="image1"/>
                        <x-select-image :images="$images" name="image2"/>
                        <x-select-image :images="$images" name="image3"/>
                        <x-select-image :images="$images" name="image4"/>
                        <div class="flex justify-around p-2 w-full mt-4">
                            <button type="submit"
                                class=" text-white bg-indigo-500 border-0 py-4 px-12 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
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

        images.forEach( image => {
            image.addEventListener('click',function(e){
                const imageName = e.target.dataset.id.substr(0,6)
                const imageId = e.target.dataset.id.replace(imageName + '_','')
                const imageFile = e.target.dataset.file
                const imagePath = e.target.dataset.path
                const modal = e.target.dataset.modal
                document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
                document.getElementById(imageName + '_hidden').value = imageId
                MicroModal.close(modal);
            },)
        });
    </script>
</x-app-layout>
