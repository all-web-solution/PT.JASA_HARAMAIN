<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT JASA HARAMAIN - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --haramain-primary: #0d47a1;
            --haramain-secondary: #1976d2;
            --haramain-light: #f8fafc;
            --haramain-accent: #42a5f5;
            --text-primary: #334155;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
        }

        .gradient-bg {
            background: linear-gradient(180deg, var(--haramain-primary) 0%, var(--haramain-secondary) 100%);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.3);
        }

        .shake {
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }
        @media screen and (max-width: 320px) {
            #title{
                font-size: 20px;
            }
            #bg-login{
                width: 300px;
            }
        }

    </style>
</head>

<body class="min-h-screen flex items-center justify-center gradient-bg">
    <div class="w-full max-w-md px-6 py-8 bg-white rounded-lg shadow-xl" id="bg-login">
        <div class="flex justify-center mb-8">
            <div class="bg-indigo-100 p-4 rounded-full">
                <i class="fas fa-user-shield text-indigo-600 text-4xl"></i>
            </div>
        </div>
        @if (session('failed'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">

                <span class="block sm:inline text-center">{{ session('failed') }}</span>
            </div>
        @endif
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2" id="title">PT JASA HARAMAIN</h1>
        <p class="text-center text-gray-600 mb-8">Please sign in to continue</p>

        <form id="loginForm" class="space-y-6" method="post" action="{{ route('sign_in') }}">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email"
                        class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none input-focus focus:border-indigo-500"
                        placeholder="Enter your email" required>
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password"
                        class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none input-focus focus:border-indigo-500"
                        placeholder="Enter your password" required>
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400 hover:text-indigo-600 cursor-pointer"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    Sign in
                </button>
            </div>
        </form>


        <div id="errorMessage" class="mt-4 hidden">
            <div class="bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p id="errorText" class="text-sm text-red-700"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
