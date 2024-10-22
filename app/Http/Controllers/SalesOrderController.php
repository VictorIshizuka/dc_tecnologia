<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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


        return view('sales-order-page', data: [
            'sales_orders' => $sales_orders,
            'sales_orderToEdit' => $sales_orderToEdit,
            'customers' => $customers,
            "products" => $products,
            'paymentTypes' => $paymentTypes,
        ]);
    }

    public function edit(Request $request, $id)
    {
        // dd($id);

        // $customers = Customer::all();
        // $products = Product::all();
        // $paymentTypes = PaymentType::all();
        // $sales_orders = SalesOrder::all();
        // $sales_orderToEdit = SalesOrderItem::where('sales_order_id', '=', $id)->with('salesOrder', 'product')->get();
        // $installments = Installment::where('sales_order_id', '=', $id)->get();
        // $sales_orderToEdit->installments = $installments;

        // return view('sales-order-edit-page', [
        //     'sales_orders' => $sales_orders,
        //     'sales_orderToEdit' => $sales_orderToEdit,
        //     'customers' => $customers,
        //     "products" => $products,
        //     'paymentTypes' => $paymentTypes,
        // ]);

        return redirect()->route('sales_orders.home')->with('erroEdit', 'Funcionalidade questionada.');
    }
    public function create()
    {

        $customers = Customer::all();
        $products = Product::all();
        $sales_orders = SalesOrder::all();

        return view('sales-order-page', ['customers' => $customers, "products" => $products]);
    }

    public function search(SearchRequest $request)
    {
        $search = $request->all();


        array_walk($search, function (&$value) {
            if (is_string($value)) {
                $value = ucfirst(strtolower($value));
            }
        });

        $salesOrderQuery = SalesOrder::query();


        $salesOrderQuery->when(!empty($search['sales_order_id']), function ($query) use ($search) {
            return $query->where('id', '=', $search['sales_order_id']);
        });

        $salesOrderQuery->when(!empty($search['sales_order_user']), function ($query) use ($search) {
            $user = User::where('name', 'LIKE', '%' . $search['sales_order_user'] . '%')->first();
            if ($user) {
                return $query->where('user_id', '=', $user->id);
            }
            return $query->whereNull('id');
        });

        $salesOrderQuery->when(!empty($search['payment_type']), function ($query) use ($search) {
            return $query->where('payment_type_id', '=', $search['payment_type']);
        });

        $salesOrderQuery->when(!empty($search['sales_order_product']), function ($query) use ($search) {
            $product = Product::where('name', 'LIKE', '%' . $search['sales_order_product'] . '%')->first();
            if ($product) {
                $salesOrderItems = SalesOrderItem::where('product_id', '=', $product->id)->pluck('sales_order_id');
                return $query->whereIn('id', $salesOrderItems);
            }
            return $query->whereNull('id');
        });

        // $salesOrderQuery->when(!empty($search['sales_order_installments']), function ($query) use ($search) {
        //     $installment = Installment::where('installment_number', '=', $search['sales_order_installments'])->first();
        //     if ($installment) {
        //         return $query->where('id', '=', $installment->sales_order_id);
        //     }
        //     return $query->whereNull('id');
        // });

        $salesOrderQuery->when(!empty($search['sales_order_due_date']), function ($query) use ($search) {
            $installments = Installment::where('due_date', 'LIKE', '%' . $search['sales_order_due_date'] . "%")->pluck('sales_order_id');
            return $query->whereIn('id', $installments);
        });

        $salesOrders = $salesOrderQuery->get();

        $customers = Customer::all();
        $products = Product::all();
        $paymentTypes = PaymentType::all();


        return view('sales-order-page', [
            'sales_orders' => $salesOrders,
            'sales_orderToEdit' => null,
            'customers' => $customers,
            'products' => $products,
            'paymentTypes' => $paymentTypes,
        ]);
    }


    public function show($id)
    {
        $saleOrderItems = SalesOrderItem::with(['salesOrder', 'product'])
            ->where('sales_order_id', $id)
            ->get();

        $installments = Installment::where('sales_order_id', '=', $id)->get();
        return view('sales-order-show', ['saleOrderItems' => $saleOrderItems, 'installments' => $installments]);
    }

    public function store(Request $request)
    {

        $itemsArray = json_decode($request->items, true);
        $installmentsArray = json_decode($request->installments, true);

        $totalAmount = 0;
        foreach ($itemsArray as $item) {
            $totalAmount += $item['product']['price'] * $item['quantity'];
        }
        $salesOrder = SalesOrder::create([
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'payment_type_id' => $request->payment_type,
            'total_amount' => $totalAmount,
        ]);


        foreach ($itemsArray as $item) {
            $product = Product::where('name', '=', $item['product']['name'])->get()[0];
            $price = $product->price;
            $quantity = $item['quantity'];
            $total = $price * $quantity;

            SalesOrderItem::create([
                'sales_order_id' => $salesOrder->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']['price'],
            ]);
        }

        if (count($installmentsArray) === 0) {


            Installment::create([
                'sales_order_id' => $salesOrder->id,
                'installment_number' => 1,
                'amount' => $totalAmount,
                'due_date' => date("Y/m/d H:i:s")
            ]);


            return redirect()->route('sales_orders.home')->with('success', 'Pedido criado com sucesso.');
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


        return redirect()->route('sales_orders.home')->with('success', 'Pedido criado com sucesso.');
    }

    // public function update(Request $request)
    // {

    //     // $itemsArray = json_decode($request->items, true);
    //     // $installmentsArray = json_decode($request->installments, true);

    //     // // $salesOrder['total_amount'] = $itemsArray[0]
    //     // $data = $request->only([
    //     //     'items',
    //     //     'installments_count',
    //     //     'installments',
    //     // ]);
    //     // // dd($request->all());


    //     // dd($data);




    //     // $salesOrder = SalesOrder::update([
    //     //     'total_amount' => $itemsArray[0]['product']['price'] * $itemsArray[0]['quantity'],
    //     // ]);


    //     // foreach ($itemsArray as $item) {
    //     //     $product = Product::find($item['product_id']);
    //     //     $price = $product->price;
    //     //     $quantity = $item['quantity'];
    //     //     $total = $price * $quantity;

    //     //     SalesOrderItem::create([
    //     //         'sales_order_id' => $salesOrder->id,
    //     //         'product_id' => $item['product_id'],
    //     //         'quantity' => $item['quantity'],
    //     //         'price' => $item['price'],
    //     //     ]);

    //     //     $salesOrder->total_amount += $total;
    //     // }

    //     // if (count($installmentsArray) === 0) {
    //     //     $total = $itemsArray[0]['price'] * $itemsArray[0]['quantity'];
    //     //     // dd($salesOrder);


    //     //     Installment::create([
    //     //         'sales_order_id' => $salesOrder->id,
    //     //         'installment_number' => 1,
    //     //         'amount' => $total,
    //     //         'due_date' => date("Y/m/d H:i:s")
    //     //     ]);

    //     //     $salesOrder->save();
    //     //     return redirect()->route('sales_orders.home')->with('success', 'Pedido criado com sucesso.');
    //     // }

    //     // foreach ($installmentsArray as $installment => $value) {
    //     //     $newString = explode('/', $value['due_date']);


    //     //     $date = date_create(implode('-', $newString));


    //     //     Installment::create([
    //     //         'sales_order_id' => $salesOrder->id,
    //     //         'installment_number' => $installment,
    //     //         'amount' => $value['value'],
    //     //         'due_date' => date_format($date, "Y/m/d H:i:s")
    //     //     ]);
    //     // }




    //     // $salesOrder->save();

    //     return redirect()->route('sales_orders.home')->with('success', 'Pedido criado com sucesso.');
    // }

    public function destroy($id)
    {


        $salesOrder = SalesOrder::find(id: $id);
        $salesOrderItem = SalesOrderItem::where('sales_order_id', '=', $id)->pluck('id');

        $installments = Installment::where('sales_order_id', '=', $id)->pluck('id');

        if ($installments) {
            Installment::destroy($installments);
            SalesOrderItem::destroy($salesOrderItem);
        }
        SalesOrder::destroy($salesOrder->id);
        return redirect()->route('sales_orders.home')->with('success', 'Pedido deletado com sucesso.');
    }


    public function createPDF($id)
    {
        $saleOrderItems = SalesOrderItem::with(['salesOrder', 'product'])
            ->where('sales_order_id', $id)
            ->get();

        $installments = Installment::where('sales_order_id', '=', $id)->get();

        $pdf = Pdf::loadView(view: 'sales-order-show-pdf', data: ['saleOrderItems' => $saleOrderItems, 'installments' => $installments]);
        return $pdf->stream();
    }
}