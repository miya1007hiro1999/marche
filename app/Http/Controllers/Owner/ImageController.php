<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use Closure;
use App\Http\Requests\UpLoadImageRequest;


class ImageController extends Controller
{
    public static function middleware(): array
    {
        return [
                'auth:owners',
                function (Request $request, Closure $next) {
                    // dd($next($request));
                    $id= $request->route()->parameter('image');//shopのid取得
                    if(!is_null($id)){
                        $imagesOwnerId = Image::findOrFail($id)->owner->id;
                        $imageId = (int)$imagesOwnerId;//キャスト 文字列→数値に変換
                        if($imageId !== Auth::id()){
                            abort(404);
                        } 
                    }
                    return $next($request);
                },
        ];
        

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::where('owner_id',Auth::id())
        ->orderBy('update_at','desc')
        ->paginate(20);

        return view('owner.images.index',
        compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpLoadImageRequest  $request)
    {
        dd($request);
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
