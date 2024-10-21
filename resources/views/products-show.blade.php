<x-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold mb-4">Detalhes do Pedido de Venda</h2>

        @if (session('error'))
            <div class="bg-red-500 text-white p-2 mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Vendedor</th>
                    <th class="py-2 px-4 border-b">Cliente</th>
                    <th class="py-2 px-4 border-b">Tipo de Pagamento</th>
                    <th class="py-2 px-4 border-b">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->salesOrder->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $saleOrderItems->salesOrder->user->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->salesOrder->customer->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->salesOrder->paymentType->name }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->salesOrder->total_amount }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr />
        <br>
        <table class="w-50 bg-white border border-gray-100">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Produto</th>
                    <th class="py-2 px-4 border-b">Preço</th>
                    <th class="py-2 px-4 border-b">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->id }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->product->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $saleOrderItems->price }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems->quantity }}</td>
                </tr>
            </tbody>
        </table>


        <a href="{{ route('sales_orders.store') }}" class="text-blue-600 hover:underline">Voltar para a lista de
            pedidos</a>
    </div>
</x-layout>
