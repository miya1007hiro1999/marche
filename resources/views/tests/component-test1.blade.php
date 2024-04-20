<x-tests.app>
    <x-slot name="header">
        ヘッダー
    </x-slot>
    テスト１

    <x-tests.card title="タイトル" content="本文" :message="$message"/>
    <x-tests.card title="タイトル2" />

</x-tests.app>