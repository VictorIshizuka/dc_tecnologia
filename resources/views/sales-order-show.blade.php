<x-layout title= "Detalhes - Pedido de Venda">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold mb-4">Detalhes do Pedido de Venda</h2>


        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('erroEdit'))
            <div class="bg-orange-500 text-white p-2 mb-4 text-center">
                {{ session('erroEdit') }}
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
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems[0]->id }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems[0]->salesOrder->user->name }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems[0]->salesOrder->customer->name }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">{{ $saleOrderItems[0]->salesOrder->paymentType->name }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        R${{ number_format($saleOrderItems[0]->salesOrder->total_amount, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr />
        <br>
        <h4 class="text-3xl font-semibold mb-4">Produtos do pedido de venda</h4>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Produto</th>
                    <th class="py-2 px-4 border-b">Quantidade</th>
                    <th class="py-2 px-4 border-b">Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleOrderItems as $saleOrderItem)
                    <tr>

                        <td class="py-2 px-4 border-b text-center">{{ $saleOrderItem->id }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrderItem->product->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrderItem->quantity }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            R${{ number_format($saleOrderItem->price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <hr />
        <h4 class="text-3xl font-semibold mb-4">Parcelas do pedido de venda</h4>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Parcelas</th>
                    <th class="py-2 px-4 border-b">valor</th>
                    <th class="py-2 px-4 border-b">Data de Vencimento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $installment)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $installment->id }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $installment->installment_number }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            R${{ number_format($installment->amount, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            {{ date('d/m/y', strtotime($installment->due_date)) }}</td>
                    </tr>
                @endforeach


            </tbody>
        </table>

        <a href="{{ route('sales_orders.store') }}" class="text-blue-600 hover:underline">Voltar para a lista de
            pedidos</a>
    </div>
</x-layout>
