<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Closure;
use Illuminate\Support\Facades\Storage; 
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\UpLoadImageRequest;
use App\Services\ImageService;


class ShopController extends Controller
{
    public static function middleware(): array
    {
        return [
                'auth:owners',
                function (Request $request, Closure $next) {
                    dd($next($request));
                    $id= $request->route()->parameter('shop');//shopのid取得
                    if(!is_null($id)){
                        $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                        $shopId = (int)$shopsOwnerId;//キャスト 文字列→数値に変換
                        $ownerId = Auth::id();
                        if($shopId !== $ownerId){
                            abort(404);
                        } 
                    }
                    return $next($request);
                },
        ];
        

    }


    public function index()
    {

        // phpinfo();
        // $ownerId = Auth::id();
        $shops = Shop::where('owner_id',Auth::id())->get();

        return view('owner.shops.index',
        compact('shops'));


    }

    public function edit(string $id)
    {

        $shop= Shop::findOrFail($id);
        return view('owner.shops.edit',compact('shop'));
        // dd(Shop::findOrFail($id));
    }

    public function update(UpLoadImageRequest $request, string $id)
    {
        // $request->name;
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string',  'max:1000',],
            'is_selling' => ['required', ],
        ]);

        // $manager = new ImageManager();
        $imageFile = $request->image; //一時保存
        if(!is_null($imageFile) && $imageFile->isValid()){
            $fileNameToStore = ImageService::upload($imageFile,'shops');
            // Storage::putFile('public/shops', $imageFile); 
            // $fileName = uniqid(rand().'_');
            // $extension = $imageFile->extension();
            // $fileNameToStore = $fileName.'.'.$extension;
            // $resizedImage = Image::read($imageFile)->resize(1920, 1080)->encode();
            // // dd($imageFile,$resizedImage);

            // Storage::put('public/shops/'.$fileNameToStore,$resizedImage);
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;

        if(!is_null($imageFile) && $imageFile->isValid()){
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return redirect()
        ->route('owner.shops.index')
        -> with(['message'=>'店舗情報を更新しました',
        'status'=> 'info']);;
    }
}
