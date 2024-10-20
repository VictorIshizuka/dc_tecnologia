<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::all();
        $productToEdit = null;


        if ($request->has('edit')) {
            $productToEdit = Product::findOrFail($request->edit);
        }

        return view('home', [
            'products' => $products,
            'productToEdit' => $productToEdit
        ]);
    }

    public function store(CreateProductRequest $r)
    {
        $data = $r->only(['name', 'stock', 'price']);
        Product::create($data);

        return redirect()->route('products.home')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Request $request, $id)
    {
        $products = Product::all();
        $productToEdit = Product::findOrFail($id);
        return view('home', [
            'productToEdit' => $productToEdit,
            'products' => $products,
            'id' => $id
        ]);
    }
    public function update(CreateProductRequest $r, $id)
    {

        $data = $r->only(['name', 'stock', 'price']);
        $product = Product::findOrFail($id);
        $product->update($data);
        $products = Product::all();
        return redirect()->route('products.home')->with('success', 'Produto atualizado com sucesso.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.home')->with('success', 'Produto removido com sucesso.');
    }


    public function calculateTotal($id, $quantity)
    {
        $product = Product::findOrFail($id);
        $totalPrice = $product->price * $quantity;

        return response()->json([
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity,
            'total_price' => number_format($totalPrice, 2)
        ]);
    }
}
