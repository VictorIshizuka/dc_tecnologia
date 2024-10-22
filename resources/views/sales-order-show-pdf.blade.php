<div style="width: 100%; padding: 20px; font-family: Arial, sans-serif;">
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Detalhes do Pedido de Venda</h2>


    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">ID</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Vendedor</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Cliente</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Tipo de Pagamento</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">{{ $saleOrderItems[0]->id }}
                </td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                    {{ $saleOrderItems[0]->salesOrder->user->name }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                    {{ $saleOrderItems[0]->salesOrder->customer->name }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                    {{ $saleOrderItems[0]->salesOrder->paymentType->name }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                    R${{ number_format($saleOrderItems[0]->salesOrder->total_amount, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Produtos do pedido de venda</h4>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">ID</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Produto</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Quantidade</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saleOrderItems as $saleOrderItem)
                <tr>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        {{ $saleOrderItem->id }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        {{ $saleOrderItem->product->name }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        {{ $saleOrderItem->quantity }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        R${{ number_format($saleOrderItem->price, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Parcelas do pedido de venda</h4>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">ID</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Parcelas</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Valor</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">Data de Vencimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($installments as $installment)
                <tr>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">{{ $installment->id }}
                    </td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        {{ $installment->installment_number }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        R${{ number_format($installment->amount, 2, ',', '.') }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
                        {{ date('d/m/Y', strtotime($installment->due_date)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <p style="text-align: center;">Gerado por Minha Aplicação</p>

</div>
