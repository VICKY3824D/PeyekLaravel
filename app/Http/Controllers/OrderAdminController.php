<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(){
        $orders = Order::all()->sortByDesc('created_at');

        return view('admin.order.index', compact('orders'));
    }

    public function bayar(Order $order){
        $order->update(['status' => 'diproses']);
        return redirect()->back();
    }

    public function selesai(Order $order){
        $order->update(['status' => 'selesai']);
        return redirect()->back();
    }


}
