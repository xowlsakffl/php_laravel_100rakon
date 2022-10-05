<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Qna;
use App\SubscribOrder;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //현재 시간
        $today = Carbon::today();

        $chartData_1 = [];
        $chartData_2 = [];
        $i = 0;
        while($i < 8){
            $chartData_1[$i] = Order::whereDate('created_at', $today->subDays($i))->where('state', 9)->sum('total_amount');
            $chartData_2[$i] = User::whereDate('created_at', $today->subDays($i))->get()->count();
            $i++;
        }
        $chart1 = array_reverse(array_map('intval', array_values($chartData_1)));
        $chart2 = array_reverse(array_map('intval', array_values($chartData_2)));

        $orders = Order::latest()->take(10)->get();
        $subscribeOrders = SubscribOrder::latest()->take(10)->get();
        $qnas = Qna::latest()->take(10)->get();
        return view('admin.home', compact(['orders', 'subscribeOrders', 'qnas', 'chart1', 'chart2']));
    }
}
