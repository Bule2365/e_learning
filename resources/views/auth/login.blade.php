<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-96">
        <h1 class="text-2xl font-bold text-center text-gray-800">Login</h1>

        @if ($errors->any())
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="id" class="block text-gray-700 text-sm font-bold mb-2">ID:</label>
                <input type="text" name="id" id="id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                Login
            </button>
        </form>
    </div>
</body>

</html>