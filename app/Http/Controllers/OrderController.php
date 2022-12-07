<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Barang;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
            return response()->json([
                'status' => 200,
                'data' => $order
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
        $barang = Barang::where('id', $request->id)->first();
        $order = Order::create([
            "fullname" => $request->fullname,
            "address" => $request->address,
            "totalprc" => $barang->price
        ]);

        if ($order){
            $transaksi = Transaction::create([
                "status" => "Menunggu Pembayaran"
            ]);
        }

        return response()->json([
            'success' => 201,
            'message' => 'order disimpan',
            'data' => $order,
            'status' => $transaksi
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
        $order = Order::find($id);
        $transaksi = Transaction::find($id);
        if ($order) {
            return response()->json([
                'status' => 200,
                'data' => $order,
                'transaki'=> $transaksi
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
        $order = Order::find($id);
        if($order){
            $order->fullname = $request->fullname ? $request->fullname : $order->fullname;
            $order->address = $request->address ? $request->address : $order->address;
            $order->save();
            return response()->json([
                'status' => 200,
                'data' => $order
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
        $order = Order::where('id',$id)->first();
        if($order){
            $order->delete();
            $transaksi = Transaction::where('id',$id)->first();
            $transaksi->delete();
            return response()->json([
                'status' => 200,
                'data' => $order,
                'transaksi'=> [$transaksi, "DIHAPUS"]
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message'=> 'id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
}
