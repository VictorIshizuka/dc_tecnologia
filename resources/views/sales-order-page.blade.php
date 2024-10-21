<x-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold mb-4">Cadastro de Pedido de Venda</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form id="orderForm" method="POST" action="{{ route('sales_orders.store') }}">
            @csrf
            <div class="flex space-x-4 mb-4">
                <select name="customer_id" class="border border-gray-300 p-2 w-1/3" required>
                    <option value="" disabled selected>Selecione um Cliente</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}--{{ $customer->document }}</option>
                    @endforeach
                </select>

                <select id="productSelect" class="border border-gray-300 p-2 w-1/3">
                    <option value="" disabled selected>Selecione um Produto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}--ID:{{ $product->id }}
                        </option>
                    @endforeach
                </select>

                <input type="number" id="quantityInput" min="1" placeholder="Quantidade"
                    class="border border-gray-300 p-2 w-1/6" />
                <button type="button" id="addButton" class="bg-blue-600 text-white p-2">Adicionar</button>
            </div>

            <h3 class="text-xl mb-2">Itens Selecionados:</h3>
            <table class="min-w-full bg-white border border-gray-200 mb-4" id="orderTable">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Produto</th>
                        <th class="py-2 px-4 border-b">Quantidade</th>
                        <th class="py-2 px-4 border-b">Preço Unitário</th>
                        <th class="py-2 px-4 border-b">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Iadiciona os dados pelo js (NAO ACHEI UMA FORMA MELHOR E ACHEI VERBOSO DEMAIS, MAS JA ESTOU ESTUDANDO PARA MELHORAR ISSO)-->
                </tbody>
            </table>

            <input type="hidden" name="items" id="itemsInput" value="[]" />
            <div class="flex justify-end mb-4">
                <strong class="text-xl">Total Geral: R$ <span id="totalAmount">0.00</span></strong>
            </div>

            <h3 class="text-xl mb-2">Tipo de Pagamento:</h3>
            <select id="paymentType" name="payment_type" class="border border-gray-300 p-2 mb-4 w-1/3" required>
                <option value="" disabled selected>Selecione um Tipo de Pagamento</option>
                @foreach ($paymentTypes as $paymentType)
                    <option value="{{ $paymentType['id'] }}">{{ $paymentType['name'] }}</option>
                @endforeach
            </select>
            <div id="installmentsSection" style="display: none;">
                <h3 class="text-xl mb-2">Parcelas:</h3>
                <label for="installmentsCount" class="mb-2">Número de Parcelas:</label>
                <input type="number" id="installmentsCount" name="installments_count" min="1"
                    class="border border-gray-300 p-2 mb-4 w-1/4" />

                <label id="installmentNumber-label" for="installmentsDay" class="mb-2">Dia das Parcelas:</label>
                <input type="text" id="installmentNumber" placeholder="Procure pelo produto"
                    class="installmentNumber border border-gray-300 p-2 mb-4 w-1/4" name="" />

                <div id="installmentsList"></div>
            </div>

            <button type="submit" class="bg-green-600 text-white p-2 mt-4">Salvar Pedido</button>
        </form>
    </div>
    <div class="container mx-auto p-4">
        <form method="GET" action="{{ route('sales_orders.search') }}">
            @csrf
            <input type="text" name="sales_orders_id" class="border border-gray-300 p-2 mb-4 w-1/4" required />
            <button type="submit" class="bg-green-600 text-white p-2 mt-4">Procurar Pedido</button>
        </form>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Vendedor</th>
                    <th class="py-2 px-4 border-b">Cliente</th>
                    <th class="py-2 px-4 border-b">Tipo pagamento</th>
                    <th class="py-2 px-4 border-b">Total</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sales_orders as $saleOrder)
                    {{-- dd($sales_orders[0]->customer->name); --}}
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrder['id'] }}</td>
                        <td class="py-2 px-4 border-b">{{ $saleOrder['user']->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrder['customer']->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrder['paymentType']->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $saleOrder['total_amount'] }} </td>

                        <td>
                            <a href="{{ route('sales_orders.search', $customer->id) }}"
                                class="text-blue-600 hover:underline">View</a> |

                            <a href="{{ route('sales_orders.edit', $saleOrder->id) }}"
                                class="text-blue-600 hover:underline">Editar</a> |
                            <form action="{{ route('sales_orders.destroy', $saleOrder->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>


    </div>
    <script>
        const orderTable = document.getElementById('orderTable').getElementsByTagName('tbody')[0];
        const totalAmountElement = document.getElementById('totalAmount');
        const itemsInput = document.getElementById('itemsInput');
        const paymentType = document.getElementById('paymentType');
        const installmentsSection = document.getElementById('installmentsSection');
        const installmentsCountInput = document.getElementById('installmentsCount');
        const installmentsList = document.getElementById('installmentsList');
        const labelDateinstallment = document.getElementById('installmentNumber-label');
        const installments = document.getElementById('installments');
        let totalAmount = 0;
        let items = [];

        document.getElementById('addButton').addEventListener('click', function() {
            const productSelect = document.getElementById('productSelect');
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const quantityInput = document.getElementById('quantityInput');
            const quantity = parseInt(quantityInput.value);

            if (selectedOption.value && quantity > 0) {
                const productName = selectedOption.text;
                const price = parseFloat(selectedOption.getAttribute('data-price'));
                const total = price * quantity;

                // adiciona uma nova linha na tabela DEVERIA
                const newRow = orderTable.insertRow();
                newRow.innerHTML = `
                        <td class="py-2 px-4 border-b">${productName}</td>
                        <td class="py-2 px-4 border-b">${quantity}</td>
                        <td class="py-2 px-4 border-b">${price.toFixed(2)}</td>
                        <td class="py-2 px-4 border-b">${total.toFixed(2)}</td>
                    `;

                // atualiza o total geral
                totalAmount += total;
                totalAmountElement.textContent = totalAmount.toFixed(2);

                // atualiza o input escondido com os itens DEVERIA
                items = JSON.parse(itemsInput.value);
                items.push({
                    product_id: selectedOption.value,
                    price: price.toFixed(2),
                    quantity: quantity
                });
                itemsInput.value = JSON.stringify(items);
                // console.log(itemsInput.value)
                // limpa os campos
                productSelect.selectedIndex = 0;
                quantityInput.value = '';
            } else {
                alert('Por favor, selecione um produto e insira uma quantidade válida.');
            }
        });
        paymentType.addEventListener('change', function() {



            console.log(installmentsCountInput)
            if (this.value == "1") {
                installmentNumber.style.display = "block"
                labelDateinstallment.style.display = "flex"
            } else if (this.value != "1") {
                installmentNumber.style.display = "none"
                labelDateinstallment.style.display = "none"

            }
            if (this.value === '6' || this.value === '1') {

                installmentsSection.style.display = 'block';
            } else {
                labelDateinstallment.style.display = "none"
                installmentsSection.style.display = 'none';
                installmentsSection.style.display = 'none';
                installmentsList.innerHTML = '';
            }
        });

        function updateInstallmentValues() {
            let inputs = installmentsList.querySelectorAll('input.installment-amount');
            let sum = 0;

            // faz a soma atual dos valores das parcelas DEVERIA
            inputs.forEach(input => {
                sum += parseFloat(input.value.replace('R$', '').trim()) || 0;
            });

            let difference = totalAmount - sum;

            if (difference !== 0) {
                redistributeDifference(inputs, difference);
            }
        }

        // arrumar função para redistribuição de valores nas parcelas
        function redistributeDifference(inputs, difference) {
            for (let i = inputs.length - 1; i >= 0; i--) {
                let currentValue = parseFloat(inputs[i].value.replace('R$', '').trim()) || 0;
                let adjustedValue = currentValue + difference;
                if (adjustedValue >= 0) {
                    inputs[i].value = `R$ ${adjustedValue.toFixed(2)}`;
                    break;
                } else {
                    difference = adjustedValue;
                    inputs[i].value = 'R$ 0.00';
                }
            }
        }


        installmentsList.addEventListener('input', function(event) {
            if (event.target.classList.contains('installment-amount')) {
                updateInstallmentValues();
            }
        });


        installmentsCountInput.addEventListener('input', function() {
            // console.log('hapen')
            const count = parseInt(this.value);
            installmentsList.innerHTML = '';
            let newDate = new Date(new Date());
            let dateArray = [];
            const teste = paymentType.value === '6';
            if (count > 0) {
                const installmentAmount = (totalAmount / count).toFixed(2);
                let installmentInput = 0;
                console.log('hapen')
                for (let i = 1; i <= count; i++) {


                    newDate.setMonth(newDate.getMonth() + 1);
                    installmentsList.innerHTML += `
                    <div class="mb-2 flex">
                        <p>Parcela ${i}:</p>
                        <input type="text"  name="installmentValue${i}" class="installment-amount" value="R$ ${installmentAmount}" />
                        <input type="text"  name="installmentDueDate${i}" value="${newDate.toLocaleDateString()}" ${teste ? '' : 'disabled'} />
                    </div>
                `;


                }
                console.log(installmentInput)
            }
        });
        // função para pegar as parcelas e datas de vencimento DEVERIA
        function captureInstallmentsData() {
            const installments = [];

            // pega os campos das parcelas e das datas
            const installmentAmounts = document.querySelectorAll('input[name^="installmentValue"]');
            const installmentDueDates = document.querySelectorAll('input[name^="installmentDueDate"]');

            // cria um objeto para cada parcela ou deveria
            for (let i = 0; i < installmentAmounts.length; i++) {
                const amount = installmentAmounts[i].value.replace('R$', '').trim(); // tira R$
                const dueDate = installmentDueDates[i].value; //data vencimento

                // adicionando objetos no array de parcelas
                installments.push({
                    value: parseFloat(amount),
                    due_date: dueDate
                });
            }

            // Converte o array de parcelas em uma string JSON (importante)
            return JSON.stringify(installments);
        }

        //pegar dados antes de subimeter o form
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const installmentsInput = document.createElement('input');
            installmentsInput.type = 'hidden';
            installmentsInput.name = 'installments'; // campos que devriam ir para o back
            installmentsInput.value = captureInstallmentsData(); // pegar dados via função

            // input hiden adionado no form
            this.appendChild(installmentsInput);
        });
    </script>
</x-layout>