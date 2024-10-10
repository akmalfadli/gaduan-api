<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use File;

class PostController extends Controller
{
    public function index()
    {
        // $posts = auth()->user()->posts()->likes()->orderBy('updated_at', 'desc')->take(5)->get();
        $posts = Post::with('like', 'comment')->get();
 
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
 
    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 400);
    }

    public function hitlike(Request $request)
    {
        $like = Like::where('post_id', $request->post_id)->increment('like_count');

        if (auth()->user()->likes())
            return response()->json([
                'success' => true,
                'data' => $like
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
        ]);
 
        //URL to display image
        //http://10.10.10.113:8000/storage/images/

        $image_path = $request->file('image')->store('images', 'public');
        $post = new Post();
        $post->description = $request->description;
        $post->image = $image_path;

        
        $ret = auth()->user()->posts()->save($post);
        $like = new Like();
        $like->post_id = $ret->id;
        $like->save();

        if (auth()->user()->posts()->save($post))
            return response()->json([
                'success' => true,
                'data' =>  $post->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        $updated = $post->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}