<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    
 public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['pemilik-komen'])->only('update', 'delete');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);
        
        $request['user_id'] = Auth::user()->id;
        $comment = Comments::create($request->all());     

        return new CommentsResource($comment);

    }

    public function update(Request $request, $id){

        $validated = $request->validate([
           'comments_content' => 'required',
        ]);

        $comments = Comments::FindOrFail($id);
        $comments -> update($request->all());

        return new CommentsResource($comments);

    }

    public function delete($id){

        $comments = Comments::FindOrFail($id);
        $comments->delete();

        return response()->json([
            'message' => 'Berhasil Menghapus Komen'
        ]);

    }

}
