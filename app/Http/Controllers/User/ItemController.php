<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PrimaryCategory;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Closure;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Jobs\SendThanksMail;

class ItemController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:users',
            function (Request $request, Closure $next) {
                // dd($next($request));
                $id = $request->route()->parameter('item'); 
                if(!is_null($id)){ 
                $itemId = Product::availableItems()->where('products.id', $id)->exists();
                    if(!$itemId){ 
                        abort(404);
                    }
                }
                return $next($request);
            },
        ];

        
    }
    public function index(Request $request)
    {
        //同期的処理
        // $email = 'test@example.com';
        // Mail::to($email)->send(new TestMail());

        //非同期処理
        SendThanksMail::dispatch();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        $products = Product::availableItems()
        ->selectCategory($request->category ?? '0')
        ->searchKeyword($request->keyword)
        ->sortOrder($request->sort)
        ->paginate($request->pagination ?? '20');

        $sortOrder = Product::SORT_ORDER;
        // dd($stocks);
        // $products = Product::all();
        return view('user.index', compact('products','categories','sortOrder'));
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
