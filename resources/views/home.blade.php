<x-layout>
    <div class="container mx-auto p-4">
        <form
            action="{{ isset($productToEdit) ? route('products.update', $productToEdit->id) : route('products.store') }}"
            method="POST" class="mb-4">
            @csrf
            @if (isset($productToEdit))
                @method('PUT')
            @endif

            <div class="flex space-x-2">
                <div class="flex flex-col w-1/3">
                    <input type="text" name="name"
                        value="{{ old('name', isset($productToEdit) ? $productToEdit->name : '') }}"
                        placeholder="Nome do Produto" class="border border-gray-300 p-2 w-full" required />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col w-1/5">
                    <input type="number" name="price" step="0.01"
                        value="{{ old('price', isset($productToEdit) ? $productToEdit->price : '') }}"
                        placeholder="Valor do Produto" class="border border-gray-300 p-2 w-full" required
                        inputmode="decimal" />
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col w-1/5">
                    <input type="number" name="stock"
                        value="{{ old('stock', isset($productToEdit) ? $productToEdit->stock : '') }}"
                        placeholder="Quantidade do Produto" class="border border-gray-300 p-2 w-full" required
                        inputmode="numeric" />
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white p-2">
                        {{ isset($productToEdit) ? 'Atualizar' : 'Adicionar' }}
                    </button>
                </div>
            </div>
        </form>
        @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-2 mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-3xl font-semibold mb-4">Lista de Itens</h2>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nome</th>
                    <th class="py-2 px-4 border-b">Quantidade</th>
                    <th class="py-2 px-4 border-b">Preço</th>
                    <th class="py-2 px-4 border-b">Total</th>
                    <th class="py-2 px-4 border-b">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $product['id'] }}</td>
                        <td class="py-2 px-4 border-b">{{ $product['name'] }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ number_format($product['stock'], 0, ',', '.') }}
                        </td>
                        <td class="py-2 px-4 border-b text-center">R$
                            {{ number_format($product['price'], 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b text-center">R$
                            {{ number_format($product['stock'] * $product['price'], 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b text-center">




                            <a href="{{ route('products.edit', $product->id) }}"
                                class="text-blue-600 hover:underline">Editar</a> |
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
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
</x-layout>
