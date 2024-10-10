<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Periksa;
class PeriksaController extends Controller
{
    public function index()
    {
        $periksas = auth()->user()->periksas;
 
        return response()->json([
            'success' => true,
            'data' => $periksas
        ]);
    }
 
    public function show($id)
    {
        $periksa = auth()->user()->periksa()->find($id);
 
        if (!$periksa) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $periksa->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_kambing' => 'required',
            'kondisi' => 'required',
            'tubuh' => 'required',
            'nilai' => 'required',
            'jenis_pakan' => 'required'
        ]);
 
        $periksa = new Periksa();
        $periksa->id_kambing = $request->title;
        $periksa->kondisi = $request->description;
        $periksa->tubuh = $request->tubuh;
        $periksa->nilai = $request->nilai;
        $periksa->jenis_pakan = $request->jenis_pakan;
        $periksa->deskripsi = $request->deskripsi;
 
        if (auth()->user()->periksas()->save($periksa))
            return response()->json([
                'success' => true,
                'data' => $periksa->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Galal menambahkan..!'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $periksa = auth()->user()->posts()->find($id);
 
        if (!$periksa) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        $updated = $periksa->fill($request->all())->save();
 
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
        $periksa = auth()->user()->periksa()->find($id);
 
        if (!$periksa) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($periksa->delete()) {
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