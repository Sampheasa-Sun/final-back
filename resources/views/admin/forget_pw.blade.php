<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f9fafb] text-gray-900 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-2">Forgot Password</h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                Enter your email and we'll send you a reset link.
            </p>

            @if (session('status'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <label for="email" class="block text-sm font-medium mb-1">Email Address</label>
                <input id="email" name="email" type="email" required autofocus
                    class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="you@example.com">

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Send Reset Link
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('admin.login') }}" class="text-blue-600 text-sm hover:underline">
                    Back to Login
                </a>
            </div>
        </div>
    </div>

</body>

</html>
