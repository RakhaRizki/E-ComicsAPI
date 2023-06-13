<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Http\Resources\PostsDetailResource;
use Illuminate\Http\Request;
use App\Models\posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    
    public function __construct(){
        $this->middleware(['auth:sanctum'])->only('store', 'update');
        $this->middleware(['pemilik-komik'])->only('update');
    }
    
    public function index (){

        $posts = posts::all();
        return PostsResource::collection($posts);

    }

    public function show($id){

        $post = posts::with('writer:id,username')->FindOrFail($id);
        return new PostsDetailResource($post);

    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(Request $request){

         $request->validate([
            'title' => 'required',
            'sinopsis_komik' => 'required',
        ]);

        if($request->file) {

            $validated = $request->validate([
                'file' => 'mimes:jpeg,jpg,png|max:10000'
            ]);

            $filename = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $filename. '.'. $extension );

            $request['image'] = $filename . '.'. $extension;
            $request['author'] = Auth::user()->id;
            $post = posts::create($request->all());

        }

         $request['author'] = Auth::user()->id;
         $post = posts::create($request->all());

        $post = posts::create([
            'title' => $request->input('title'),
            'sinopsis_komik' => $request->input('sinopsis_komik'),
            'author' => Auth::user()->id,   
            'cover_komik' => $filename. '.' .$extension,
        ]);

        return new PostsDetailResource($post->loadmissing('writer'));

    }

    public function update(Request $request, $id){

          $request -> validate([
            'title' => 'required|string',
        ]);

        $post = posts::FindOrFail($id);
        $post->update($request->all());

        return new PostsDetailResource($post->loadmissing('writer'));

    }

    public function delete($id){

        $post = posts::FindOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Berhasil Menghapus Komik'
        ]);
    
    }

}
