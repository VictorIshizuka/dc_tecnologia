<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();
        $customerToEdit = null;


        if ($request->has('edit')) {
            $customerToEdit = Customer::findOrFail($request->edit);
        }

        return view('customer-page', [
            'customers' => $customers,
            'customerToEdit' => $customerToEdit
        ]);
    }

    public function store(CreateCustomerRequest $r)
    {

        $data = $r->only(['name', 'document', 'email', 'phone']);
        Customer::create($data);

        return redirect()->route('customers.home')->with('success', 'Cliente criado com sucesso.');
    }

    public function edit(Request $request, $id)
    {
        $customers = Customer::all();
        $customerToEdit = Customer::findOrFail($id);
        return view('customer-page', [
            'customerToEdit' => $customerToEdit,
            'customers' => $customers,
            'id' => $id
        ]);
    }
    public function update(CreateCustomerRequest $r, $id)
    {

        $data = $r->only(['name', 'document', 'email', 'phone']);
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        // $customer = Customer::all();
        return redirect()->route('customers.home')->with('success', 'Cliente atualizado com sucesso.');
    }
    //

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.home')->with('success', 'Cliente removido com sucesso.');
    }
}
