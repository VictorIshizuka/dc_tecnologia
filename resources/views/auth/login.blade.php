<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title>dc-tecnologia</title>
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-md p-8 w-96">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login</h2>
        <form action="{{ route('login_action') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mail:</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700">Senha:</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">Entrar</button>
        </form>
    </div>

</body>

</html>
