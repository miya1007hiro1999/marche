<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Image;
use App\Models\SecondaryCategory;
use App\Models\Owner;


class ProductCOntroller extends Controller
{
    public static function middleware(): array
    {
        return [
                'auth:owners',
                function (Request $request, Closure $next) {
                    // dd($next($request));
                    $id= $request->route()->parameter('product');//shopのid取得
                    if(!is_null($id)){
                        $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                        $productId = (int)$productsOwnerId;//キャスト 文字列→数値に変換
                        if($productId !==  Auth::id()){
                            abort(404);
                        } 
                    }
                    return $next($request);
                },
        ];
        
    }
    public function index()
    {
      //  $products = Owner::findOrFail(Auth::id())->shop->product;

        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id',Auth::id())->get();

        // dd($ownerInfo);
        // foreach($ownerInfo as $owner){
        //     foreach($owner->shop->product as $product){
        //         dd($product->imageFirst->filename);
        //     }
        //     // dd($owner->shop->product);
        // }


        return view('owner.products.index',compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
