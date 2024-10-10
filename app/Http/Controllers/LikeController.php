<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;


class LikeController extends Controller
{

    public function index()
    {
        $likes = Like::get();
        return response()->json([
            'success' => true,
            'data' => $likes
        ]);
    }


    public function store(Request $request)
    {
        $like = new Like();
        $like->user_id = $request->user_id;
        $like->post_id = $request->post_id;
        $like->save();
    }
}
