<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $order = Order::where('customer_id', Auth::user()->id)->where('status', '!=', 0)->get();

        return $this->sendResponse('Success', 'cihuy', $order, 200);
    }
    
    public function detail($id)
    {
        $order = Order::where('id', $id)->first();
        $order_detail = OrderDetail::where('order_id', $order->id)->get();
        
        return $this->sendResponse('Success', 'cihuy', compact('order', 'order_detail'), 200);
    }
}
