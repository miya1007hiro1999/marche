<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class ItemController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:users',
        ];

    }
    public function index()
    {
        $products = Product::availableItems()->get();

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
