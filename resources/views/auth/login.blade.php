<!DOCTYPE html>
<html>
<head>
    <title>Login & Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-cover bg-center min-h-screen flex items-center justify-center" style="background-image: url('{{ asset('img/background.jpeg') }}');">
    <div class="bg-white bg-opacity-50 p-8 rounded-lg shadow-md w-full max-w-md">
        {{-- Form Login --}}
        <div id="login-form">
            <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
                <button type="submit" class="bg-blue-500 w-full text-white py-2 rounded hover:bg-blue-600">Login</button>
            </form>
            {{-- <div class="text-center mt-4">
                <button onclick="showRegister()" class="text-blue-600 hover:underline">Belum punya akun? Daftar di sini</button>
            </div> --}}
        </div>

        {{-- Form Register
        <div id="register-form" style="display: none;">
            <h2 class="text-2xl font-semibold text-center mb-6">Register</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Name" class="w-full mb-3 p-2 border rounded" required>
                <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
                <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full mb-3 p-2 border rounded" required>
                <button type="submit" class="bg-green-500 w-full text-white py-2 rounded hover:bg-green-600">Register</button>
            </form>
            <div class="text-center mt-4">
                <button onclick="showLogin()" class="text-blue-600 hover:underline">Sudah punya akun? Login di sini</button>
            </div>
        </div> --}}

        <hr class="my-6">
        <div class="text-center">
            <a href="{{ url('/') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</body>
</html>
