<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Login - Askly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

        .askly-border {
            border-color: #4A90E2;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold askly-text">Askly Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Secure login for administrators</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-askly-blue focus:outline-none px-3 py-2">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-askly-blue focus:outline-none px-3 py-2">
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 text-white font-semibold rounded-md askly-blue hover:askly-blue transition duration-150 ease-in-out shadow">
                        Log In
                    </button>
                </div>
            </form>

            {{-- Uncomment if password reset is enabled --}}
            {{-- <div class="mt-4 text-center text-sm text-gray-600">
                <a href="{{ route('admin.password.request') }}" class="hover:underline askly-text">Forgot your password?</a>
            </div> --}}
        </div>

        <div class="mt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Askly. All rights reserved.
        </div>
    </div>
</body>

</html>
