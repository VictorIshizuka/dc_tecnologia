<x-layout>
    <div class="container mx-auto p-4">
        <form
            action="{{ isset($customerToEdit) ? route('customers.update', $customerToEdit->id) : route('customers.store') }}"
            method="POST" class="mb-4" onsubmit="return formatFields();">
            @csrf
            @if (isset($customerToEdit))
                @method('PUT')
            @endif

            <!-- Campos do formulário -->
            <div class="flex space-x-2 justify-center">
                <input type="text" name="name"
                    value="{{ old('name', isset($customerToEdit) ? $customerToEdit->name : '') }}" placeholder="Nome"
                    class="border border-gray-300 p-2 w-1/5" required />
                @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="email" name="email"
                    value="{{ old('email', isset($customerToEdit) ? $customerToEdit->email : '') }}"
                    placeholder="E-mail" class="border border-gray-300 p-2 w-1/5" required />
                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="text" name="document" id="document"
                    value="{{ old('document', isset($customerToEdit) ? $customerToEdit->document : '') }}"
                    oninput="formatCNPJ(this)" placeholder="Documento" class="border border-gray-300 p-2 w-1/5"
                    required />
                @error('document')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="text" name="phone" id="phone"
                    value="{{ old('phone', isset($customerToEdit) ? $customerToEdit->phone : '') }}"
                    oninput="formatPhone(this)" placeholder="Telefone" class="border border-gray-300 p-2 w-1/5"
                    required />
                @error('phone')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <button type="submit" class="bg-blue-600 text-white p-2">
                    {{ isset($customerToEdit) ? 'Atualizar' : 'Adicionar' }}
                </button>
            </div>
        </form>

        @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-2 mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-3xl font-semibold mb-4">Lista de Clientes</h2>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nome</th>
                    <th class="py-2 px-4 border-b">E-mail</th>
                    <th class="py-2 px-4 border-b">Documento</th>
                    <th class="py-2 px-4 border-b">Telefone</th>
                    <th class="py-2 px-4 border-b">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $customer['id'] }}</td>
                        <td class="py-2 px-4 border-b">{{ $customer['name'] }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $customer['email'] }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $customer['document'] }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $customer['phone'] }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('customers.edit', $customer->id) }}"
                                class="text-blue-600 hover:underline">Editar</a> |
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
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
