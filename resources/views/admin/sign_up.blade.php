<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Sign Up - Askly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .askly-blue {
            background-color: #4A90E2;
        }
        .askly-blue:hover {
            background-color: #3a78c3;
        }
        .askly-text {
            color: #4A90E2;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center ">
        <div class="bg-white p-8 rounded-md shadow-md w-full max-w-xl">
            <h2 class="text-2xl font-bold text-center askly-text mb-6">Sign Up with Askly</h2>

            {{-- Validation Errors --}}
            @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/admin/register" method="POST" class="space-y-4">
                @csrf
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="firstName" id="firstName"
                            class="mt-1 block w-full rounded border-gray-300" value="{{ old('firstName') }}" required>
                    </div>
                    <div class="w-1/2">
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="lastName" id="lastName"
                            class="mt-1 block w-full rounded border-gray-300" value="{{ old('lastName') }}" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full rounded border-gray-300" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full rounded border-gray-300" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full rounded border-gray-300" required>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 text-white rounded askly-blue hover:askly-blue">
                    Create Admin Account
                </button>
            </form>

            <div class="mt-4 text-center text-sm">
                Already have an account? <a href="{{ route('admin.login') }}" class="askly-text hover:underline">Sign in</a>
            </div>
        </div>
    </div>
</body>

</html>
