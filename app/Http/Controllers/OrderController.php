<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Product;
use Auth;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($id)
    {
        $product = Product::where('id', $id)->first();

        if ($product) {
            return $this->sendResponse('Success', 'Berhasil', $product, 200);
        }
        return $this->sendResponse('Error', 'Not Found', NULL, 404);
    }

    public function order(Request $request, $id)
    {

        $product = Product::where('id', $id)->first();
        $tanggal = Carbon::now();
        
        // dd($product->status);
        if (empty($product)) {
            # code...
            return $this->sendResponse('ERROR', 'Product tidak ada', NULL, 404);
        }
        // validasi jika melebihi stok
        if ($request->jumlah_barang > $product->status) {
            # code...
            return $this->sendResponse('Tidak ada', 'Kosong', NULL, 404);
        }

        // cek validasi
        $cek_order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        // simpan ke database order
        if (empty($cek_order)) {
            # code...
            $order = new Order();
            $order->customer_id = Auth::user()->id;
            $order->tanggal = $tanggal;
            $order->status = 0;
            $order->harga = 0;
            
            $order->save();
        }
        
        // simpan ke database order_detail
        $new_order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();

        // cek order detail
        $cek_order_detail = OrderDetail::where('product_id', $product->id)->where('order_id', $new_order->id)->first();
        
        if (empty($cek_order_detail)) {
            # code...
            $order_detail = new OrderDetail();
            $order_detail->product_id = $product->id;
            $order_detail->order_id = $new_order->id;
            $order_detail->jumlah_barang = $request->jumlah_barang;
            $order_detail->harga = $product->harga*$request->jumlah_barang;
            
            $order_detail->save();
        } else {
            $order_detail = OrderDetail::where('product_id', $product->id)->where('order_id', $new_order->id)->first();

            $order_detail->jumlah_barang = $order_detail->jumlah_barang*$request->jumlah_barang;
            // harga sekarang
            $harga_new_order_detail = $product->harga*$request->jumlah_barang;

            $order_detail->harga = $order_detail->harga+$harga_new_order_detail;
            
            $order_detail->update();
        }

        // jumlah total 
        $order = Order::where('customer_id', Auth::user()->id)->where('status', 0)->first();
        $order->harga = $order->harga+$product->harga*$request->jumlah_barang;
        $order->update();

        return $this->sendResponse('Success', 'Berhasil diorder', $product, 200);      
    }
}
