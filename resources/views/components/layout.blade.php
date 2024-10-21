<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title>Dashboard - Minha Aplicação</title>
</head>

<body class="bg-gray-100">
    <x-header />

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 mb-4 text-center">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{ $slot }}

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    });
</script>

</html>
