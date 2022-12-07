<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
            return response()->json([
                'status' => 200,
                'data' => $barang
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = Barang::create([
            "name" => $request->name,
            "brand" => $request->brand,
            "description" => $request->description,
            "price" => $request->price,
            "stock" => $request->stock,
        ]);

        return response()->json([
            'success' => 201,
            'message' => 'data berhasil disimpan',
            'data' => $table
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            return response()->json([
                'status' => 200,
                'data' => $barang
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'id atas ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = barang::find($id);
        if($barang){
            $barang->name = $request->name ? $request->name : $barang->name;
            $barang->brand = $request->brand ? $request->brand : $barang->brand;
            $barang->description = $request->description ? $request->description : $barang->description;
            $barang->price = $request->price ? $request->price : $barang->price;
            $barang->stock = $request->stock ? $request->stock : $barang->stock;
            $barang->save();
            return response()->json([
                'status' => 200,
                'data' => $barang
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message'=> $id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = barang::where('id', $id)->first();
        if($barang){
            $barang->delete();
            return response()->json([
                'status' => 200,
                'data' => $barang
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message'=> 'id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
}
