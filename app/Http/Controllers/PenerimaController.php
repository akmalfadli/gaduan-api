<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Penerima;

class PenerimaController extends Controller
{
    public function index()
    {
        $penerimas = Penerima::all();
 
        return response()->json([
            'success' => true,
            'data' => $penerimas
        ]);
    }
 
    public function show($id)
    {
        $penerima = Penerima::find($id);
 
        if (!$penerima) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $penerima->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required',
            'no_kk' => 'required',
            'nama' => 'required',
            'rt' => 'required',
            'rw' => 'required'
        ]);
 
        $penerima = new Penerima();
        $penerima->nik = $request->nik;
        $penerima->no_kk = $request->no_kk;
        $penerima->nama = $request->nama;
        $penerima->rt = $request->rt;
        $penerima->rw = $request->rw;
 
        if (auth()->user()){
            Penerima::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $penerima->toArray()
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
        $penerima = Penerima::find($id);
        
        if (!$penerima) {
            return response()->json([
                'success' => false,
                'message' => 'Penerima tidak ditemukan'
            ], 400);
        }
 
        $updated = $penerima->update($request->all());
        
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
        $penerima = Penerima::find($id);
 
        if (!$penerima) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($penerima->delete()) {
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