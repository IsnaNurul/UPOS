<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pajak;
use App\Models\PaymentGateaway;
use App\Models\PaymentGateawayType;
use App\Models\Product;
use App\Models\Profile;
use App\Models\ServiceCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get today's and this month's sales data
        $todaySales = Order::whereDate('transactionTime', Carbon::today())
            ->sum('totalPrice');
        $monthSales = Order::whereMonth('transactionTime', Carbon::now()->month)
            ->sum('totalPrice');

        // Calculate average sale per transaction
        $totalTransactions = Order::count();
        $averageSale = $totalTransactions ? Order::sum('totalPrice') / $totalTransactions : 0;

        // Get today's transaction count
        $todayTransactions = Order::count();

        // Existing variables
        $profile = Profile::where('user_id', $userId)->exists();
        $pajak = Pajak::where('user_id', $userId)->exists();
        $payment_gateaway = PaymentGateaway::where('user_id', $userId)->exists();
        $service_fee = ServiceCharge::where('user_id', $userId)->exists();

        // Check if all steps are complete
        $status = !$profile || !$pajak || !$payment_gateaway || !$service_fee;
        // dd($payment_gateaway);

        // Mendapatkan semua jenis payment gateway yang belum digunakan oleh user tertentu
        $payment_gateaways = PaymentGateawayType::whereDoesntHave('paymentGateaways', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Get top-selling product categories
        $topCategories = OrderItem::join('products', 'order_items.productId', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('categories.name')
            ->orderByDesc('total_sold')
            ->take(5) // Adjust this number as needed to get top N categories
            ->pluck('total_sold', 'categories.name')
            ->toArray();

        // Get top selling products based on sales quantity
        $topSellingProducts = OrderItem::with('product')
            ->select('productId', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('productId')
            ->orderBy('total_sales', 'DESC')
            ->take(5) // Limit to top 5 products
            ->get();

        // Retrieve top members by total order value and number of purchases
        $topMembers = Member::select('members.id', 'members.name', 'members.email')
            ->join('orders', 'orders.memberId', '=', 'members.id')
            ->selectRaw('SUM(orders.totalPrice) as total_purchase, COUNT(orders.id) as purchase_count')
            ->groupBy('members.id', 'members.name', 'members.email')
            ->orderByDesc('total_purchase')
            ->limit(5)
            ->get();

        // Retrieve products with low stock (stock <= 5)
        $lowStockProducts = Product::where('stock', '<=', 100)
            ->select('name', 'stock', 'last_stock_update', 'id') // Use updated_at for restock information
            ->orderBy('stock', 'asc') // Optional: sorts by stock ascending
            ->get();

        // Get the daily sales for the current month
        $dailySales = Order::whereMonth('transactionTime', Carbon::now()->month)
            ->selectRaw('DAY(transactionTime) as day, SUM(totalPrice) as daily_sales')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Get weekly sales for the current month
        $weeklySales = Order::whereMonth('transactionTime', Carbon::now()->month)
            ->selectRaw('WEEK(transactionTime) as week, SUM(totalPrice) as weekly_sales')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Get monthly sales for the current year
        $monthlySales = Order::whereYear('transactionTime', Carbon::now()->year)
            ->selectRaw('MONTH(transactionTime) as month, SUM(totalPrice) as monthly_sales')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get yearly sales for the last 5 years
        $yearlySales = Order::selectRaw('YEAR(transactionTime) as year, SUM(totalPrice) as yearly_sales')
            ->groupBy('year')
            ->orderBy('year')
            ->limit(5)
            ->get();

        // Last transactions
        $lastTransactions = Order::with(['orderItems.product', 'member'])
            ->where('userId', $userId) // Assuming orders are tied to the user
            ->orderBy('transactionTime', 'desc')
            ->take(5)
            ->get();

        // dd($lastTransactions);

        return view('pages.dashboard', compact(
            'status',
            'payment_gateaways',
            'todaySales',
            'monthSales',
            'averageSale',
            'todayTransactions',
            'topCategories',
            'topSellingProducts',
            'topMembers',
            'lowStockProducts',
            'dailySales',
            'weeklySales',
            'monthlySales',
            'yearlySales',
            'lastTransactions'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'header_text' => 'required|string|max:255',
            'footer_text' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        $profile = new Profile();
        $profile->user_id = $userId;
        $profile->business_name = $request->input('business_name');
        $profile->header_text = $request->input('header_text');
        $profile->footer_text = $request->input('footer_text');

        // Jika file logo diunggah
        $logoPath = null;
        if ($request->logo) {
            $logoPath = time() . '.' . $request->logo->extension();
            $request->logo->storeAs('public/logo', $logoPath);
            $profile->logo = $logoPath;
        }

        $profile->save();

        return redirect()->to('/home#step2');
    }

    public function storeTax(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'value' => 'required|numeric|min:0|max:100',
        ]);

        $userId = Auth::id();

        // Store tax data
        $pajak = new Pajak();
        $pajak->jenis = $request->type;
        $pajak->value = $request->value;
        $pajak->user_id = $userId;
        $pajak->save();

        return redirect()->to('/home#step3');
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'api_key' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        // Store payment gateway data
        $payment = new PaymentGateaway();
        $payment->type_id = $request->type_id;
        $payment->api_key = $request->api_key;
        $payment->user_id  = $userId;
        $payment->save();

        return redirect()->to('/home#step4');
    }

    public function storeServiceFee(Request $request)
    {
        // dd($request);
        // Store the service fee in the database or any necessary model
        $userId = Auth::id();
        // Assuming you have a 'service_fees' table to store the fee or use a model related to the user
        $service_fee = new ServiceCharge();
        $service_fee->value = $request->value;
        $service_fee->user_id  = $userId;
        $service_fee->save();

        // Redirect back with success message
        return redirect()->route('home')->with('success', 'Service Fee updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
