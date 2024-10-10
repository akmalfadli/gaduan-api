<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kambing;

class KambingController extends Controller
{
    public function index()
    {
        $kambings = Kambing::all();
 
        return response()->json([
            'success' => true,
            'data' => $kambings
        ]);
    }
 
    public function show($id)
    {
        $kambing = Kambing::find($id);
 
        if (!$kambing) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $kambing->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag_id' => 'required',
            'jenis_kambing' => 'required',
           
        ]);
 
        $kambing = new Kambing();
        $kambing->tag_id = $request->tag_id;
        $kambing->winih_id = $request->winih_id;
        $kambing->jenis_kambing = $request->jenis_kambing;
        $kambing->tgl_lahir = $request->tgl_lahir;
 
        if (auth()->user()){
            Kambing::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $kambing->toArray()
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan..!'
            ], 500);
        }
    }
 
    public function update(Request $request, $id)
    {
        $kambing = Kambing::find($id);
        
        if (!$kambing) {
            return response()->json([
                'success' => false,
                'message' => 'Penerima tidak ditemukan'
            ], 400);
        }
 
        $updated = $kambing->update($request->all());
        
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
        $kambing = Kambing::find($id);
 
        if (!$kambing) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($kambing->delete()) {
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