<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller {
    public function index(){
        $totalRevenue = Order::where('status', 'delivered')->sum('grandtotal');
        $todayRevenue = Order::where('status', 'delivered')->whereDate('created_at', today())->sum('grandtotal');
        $yesterdayRevenue = Order::where('status', 'delivered')->whereDate('created_at', today()->subDay())->sum('grandtotal');
        $newOrdersToday = Order::whereDate('created_at', today())->count();
        //$recentOrders = Order::with('user')->where('status', 'delivered')->latest()->take(5)->get();
        $recentOrders = Order::with('user')->whereDate('created_at', today())->latest()->take(5)->get();

        $percentageChange = 0;
        if ($yesterdayRevenue > 0) {
            $percentageChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
        }

        return view('admin.dashboard.index', compact(
                'totalRevenue', 'todayRevenue',
                'percentageChange', 'newOrdersToday', 'recentOrders'
            ));
        
        //$admin = Auth::guard('admin')->user();
        //echo 'Welcome '.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }


    public function dashboardStats(Request $request) {
        $filter = $request->filter ?? 'year';

        $data = [];
        $growth = [];

        if ($filter == 'year') {
            $raw = Order::whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as label, SUM(grandtotal) as total')
                ->groupBy('label')
                ->pluck('total', 'label')
                ->toArray();

            // fill all months
            for ($i = 1; $i <= 12; $i++) {
                $data[$i] = $raw[$i] ?? 0;
            }
        }

        // =========================
        // WEEK (Mon → Sun)
        // =========================
        elseif ($filter == 'week') {
            $start = now()->startOfWeek();
            $end   = now()->endOfWeek();

            $raw = Order::whereBetween('created_at', [$start, $end])
                ->selectRaw('DAYOFWEEK(created_at) as label, SUM(grandtotal) as total')
                ->groupBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $map = [
                2 => 'Mon', 3 => 'Tue', 4 => 'Wed',
                5 => 'Thu', 6 => 'Fri', 7 => 'Sat', 1 => 'Sun'
            ];

            foreach ($map as $key => $day) {
                $data[$day] = $raw[$key] ?? 0;
            }
        }

        // =========================
        // TODAY (hourly)
        // =========================
        elseif ($filter == 'today') {
            $raw = Order::whereDate('created_at', today())
                ->selectRaw('HOUR(created_at) as label, SUM(grandtotal) as total')
                ->groupBy('label')
                ->pluck('total', 'label')
                ->toArray();

            for ($i = 0; $i < 24; $i++) {
                $data[$i] = $raw[$i] ?? 0;
            }
        }

        // =========================
        // MONTH (day-wise)
        // =========================
        else {
            $daysInMonth = now()->daysInMonth;
            $raw = Order::whereMonth('created_at', now()->month)
                ->selectRaw('DAY(created_at) as label, SUM(grandtotal) as total')
                ->groupBy('label')
                ->pluck('total', 'label')
                ->toArray();

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $data[$i] = $raw[$i] ?? 0;
            }
        }

        // =========================
        // ✅ GROWTH CALCULATION
        // =========================

        $prev = null;

        foreach ($data as $key => $value) {
            if ($prev !== null && $prev > 0) {
                $growth[$key] = round((($value - $prev) / $prev) * 100, 1);
            } else {
                $growth[$key] = 0;
            }
            $prev = $value;
        }

        return response()->json([
            'data' => $data,
            'growth' => $growth,
            'filter' => $filter
        ]);
    }


    public function recentOrders(Request $request) {
        $filter = $request->filter;

        $query = Order::with('user');

        $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);

        if ($filter == 'today') {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($filter == 'week') {
            $query->whereBetween('created_at', [
                Carbon::now()->subWeek(),
                Carbon::now()
            ]);
        }

        if ($filter == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month);
        }

        if ($filter == 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $orders = $query->latest()->take(5)->get();

        $html = view('admin.dashboard.recent-orders', compact('orders'))->render();

        return response()->json(['html' => $html]);
    }



    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
