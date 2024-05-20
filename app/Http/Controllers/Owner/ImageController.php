<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use Closure;
use App\Http\Requests\UpLoadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage; 


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
                        $ownerId = Auth::id();
                        if($imageId !== $ownerId){
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
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at', 'desc') // 'update_at' ではなく 'updated_at' です
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
        // dd($request);
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)){
            foreach($imageFiles as $imageFile){
                $fileNameToStore = ImageService::upload($imageFile,'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                ]);
            }
        }

        return redirect()
        ->route('owner.images.index')
        -> with(['message'=>'画像登録を実施しました',
        'status'=> 'info']);;
    
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image= Image::findOrFail($id);
        return view('owner.images.edit',compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->name;
        $request->validate([
            'title' => [ 'string', 'max:50'],
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;

        $image->save();

        return redirect()
        ->route('owner.images.index')
        -> with(['message'=>'画像情報を更新しました',
        'status'=> 'info']);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = Image::findOrFail($id);
        $filePath = 'public/products/'.$image->filename;

        if(Storage::exists($filePath)){
            Storage::delete([$filePath]);
        }

        Image::findOrFail($id)->delete();
        return redirect()
        ->route('owner.images.index')
        ->with(['message'=>'画像を削除しました',
    'status'=>'alert']);
    }
}
