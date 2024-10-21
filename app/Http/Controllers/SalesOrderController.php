<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Installment;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    public function index($id = null)
    {

        $query = SalesOrder::query();


        $sales_orders = $query->get();

        $customers = Customer::all();
        $products = Product::all();
        $paymentTypes = PaymentType::all();
        $sales_orderToEdit = null;


        return view('sales-order-page', [
            'sales_orders' => $sales_orders,
            'sales_orderToEdit' => $sales_orderToEdit,
            'customers' => $customers,
            "products" => $products,
            'paymentTypes' => $paymentTypes,
        ]);
    }
    public function create()
    {

        $customers = Customer::all();
        $products = Product::all();
        $sales_orders = SalesOrder::all();

        return view('sales-order-page', ['customers' => $customers, "products" => $products]);
    }

    public function search(Request $request)
    {

        $request->validate([
            'sales_orders_id' => 'required|integer|exists:sales_orders,id',
        ]);

        // dd($installments);
        $saleOrderItems = SalesOrderItem::with(['salesOrder', 'product'])->find($request->sales_orders_id);
        if (!$saleOrderItems) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }

        $installments = Installment::with(['salesOrder'])->find($request->sales_orders_id);


        return view('sales-order-show', compact('saleOrderItems', 'installments'));
    }
    public function store(Request $request)
    {

        $itemsArray = json_decode($request->items, true);
        $installmentsArray = json_decode($request->installments, true);



        $salesOrder = SalesOrder::create([
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'payment_type_id' => $request->payment_type,
            'total_amount' => $request->installments_count,
        ]);


        foreach ($itemsArray as $item) {
            $product = Product::find($item['product_id']);
            $price = $product->price;
            $quantity = $item['quantity'];
            $total = $price * $quantity;

            SalesOrderItem::create([
                'sales_order_id' => $salesOrder->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $salesOrder->total_amount += $total;
        }
        foreach ($installmentsArray as $installment => $value) {
            $newString = explode('/', $value['due_date']);


            $date = date_create(implode('-', $newString));


            Installment::create([
                'sales_order_id' => $salesOrder->id,
                'installment_number' => $installment,
                'amount' => $value['value'],
                'due_date' => date_format($date, "Y/m/d H:i:s")
            ]);
        }


        $salesOrder->save();

        return redirect()->route('sales_orders.home')->with('success', 'Pedido criado com sucesso.');
    }
}
