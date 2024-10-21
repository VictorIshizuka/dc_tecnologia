<header class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Minha Aplicação</h1>
        <ul class="flex space-x-4">
            <li><a href="#" class="text-white hover:underline">Home</a></li>
            <li><a href="{{ route('customers.home') }}" class="text-white hover:underline">Clientes</a></li>
            <li><a href="{{ route('products.home') }}" class="text-white hover:underline">Produtos</a></li>
            <li><a href="{{ route('sales_orders.home') }}" class="text-white hover:underline">Pedidos</a></li>
            <li><a href="#" class="text-white hover:underline">Configurações</a></li>
            <li><a href="{{ route('logout') }}" class="text-white hover:underline">Sair</a></li>
        </ul>
    </div>
</header>
