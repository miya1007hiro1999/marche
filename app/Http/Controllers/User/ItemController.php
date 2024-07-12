<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Closure;

class ItemController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:users',
            function (Request $request, Closure $next) {
                // dd($next($request));
                $id= $request->route()->parameter('item');//shopのid取得
                if(!is_null($id)){
                    $itemId = Product::availableItems()->where('products.id',$id)->exists();
                    if($itemId){
                        abort(404);
                    } 
                }
                return $next($request);
            },
        ];

        
    }
    public function index(Request $request)
    {
        $products = Product::availableItems()
        ->sortOrder($request->sort)
        ->paginate($request->pagination ?? '20');

        // dd($stocks);
        // $products = Product::all();
        return view('user.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $quantity =  Stock::where('product_id' , $product->id)
        ->sum('quantity');

        if($quantity > 9){
            $quantity =9;
        }

        return view('user.show', compact('product' , 'quantity'));
    }
}
