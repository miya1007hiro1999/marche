<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Closure;
use Illuminate\Support\Facades\Storage; 


class ShopController extends Controller
{
    public static function middleware(): array
    {
        return [
                'auth:owners',
                function (Request $request, Closure $next) {
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
        $ownerId = Auth::id();
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

    public function update(Request $request, string $id)
    {
        $imageFile = $request->image; //一時保存
        if(!is_null($imageFile) && $imageFile->isValid()){
            Storage::putFile('public/shops', $imageFile); 
        }


    }


}
