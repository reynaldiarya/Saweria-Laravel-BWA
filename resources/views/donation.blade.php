<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-100">
        <div class="flex justify-center items-center h-screen w-full">

            <form class="w-full max-w-2xl" id="donation-form" action="{{ route('donate.store') }}" method="POST">
                <input type="hidden" name="user_id" value="{{ $user->uuid }}">
                @csrf
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="flex justify-between items-center gap-x-6">
                            <div>
                                <h2 class="text-base/7 font-semibold text-gray-900">Kamu akan mengirimkan dukungan pada
                                    {{ $user->name }}</h2>
                                <p class="mt-1 text-sm/6 text-gray-600">Silahkan lengkapi data ini</p>
                            </div>

                            @guest
                                <a href="{{ route('login') }}"
                                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Log in
                                </a>
                            @endguest
                        </div>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-full">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900">Nama</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        value="{{ auth()->check() ? auth()->user()->name : old('name') }}"
                                        @if (auth()->check()) readonly @endif>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-full">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                        @if (auth()->check()) readonly @endif>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="amount" class="block text-sm/6 font-medium text-gray-900">Nominal</label>
                                <div class="mt-2">
                                    <input type="text" name="amount" id="amount" required
                                        onkeyup="addCurrency(this)"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        value="{{ old('amount') }}">
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="message" class="block text-sm/6 font-medium text-gray-900">Pesan</label>
                                <div class="mt-2">
                                    <textarea name="message" id="message" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kirim</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function addCurrency(element) {
            // Ambil nilai input
            let value = element.value;
            // Hapus karakter selain angka
            value = value.replace(/[^\d]/g, '');
            // Tambahkan titik sebagai pemisah ribuan
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            // Tambahkan "Rp." di depan nilai
            value = "Rp" + value;
            // Assign nilai yang sudah diubah kembali ke input
            element.value = value;
        }
    </script>
</body>

</html>
