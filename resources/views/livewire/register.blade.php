<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background">
    <div class="flex flex-col justify-center min-h-full px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="p-6 rounded-lg shadow-md bg-card">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="w-auto h-10 mx-auto" src="{{ asset('images/logo.png') }}" alt="Your Company">
                    <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-white">Register your account</h2>
                </div>

                <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
                    @if(session('status'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 text-sm text-red-600">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-6" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-white">Name</label>
                            <div class="mt-2">
                                <input id="name" name="name" type="text" autocomplete="name" required
                                       class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm
                                              ring-1 ring-inset
                                              focus:ring-2 focus:ring-inset focus:ring-indigo-600 bg-card sm:text-sm sm:leading-6"
                                       autofocus>
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-white">Email address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm
                                              ring-1 ring-inset
                                              focus:ring-2 focus:ring-inset focus:ring-indigo-600 bg-card sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-white">Password</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm
                                              ring-1 ring-inset 
                                              focus:ring-2 focus:ring-inset focus:ring-indigo-600 bg-card sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold
                                           leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline
                                           focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Register
                            </button>
                        </div>
                        <div>
                            <p class="mt-6 text-sm font-bold text-center text-gray-500">
                                Already have an account?
                                <a href="{{ url('admin') }}" class="font-bold leading-6 text-indigo-600 hover:text-indigo-500">Please Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
