<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Panel Owner | {{ $store['store_name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-surface text-ink antialiased">
    <a href="#login-main" class="skip-link">Lewati ke form login</a>

    <div class="grid min-h-screen lg:grid-cols-12">
        {{-- Left Showroom Identity Column --}}
        <div class="hidden flex-col justify-between bg-ink p-10 text-white lg:col-span-5 lg:flex">
            <a href="{{ route('home') }}" class="inline-flex">
                <x-brand-mark theme="dark" :store-name="$store['store_name']" />
            </a>

            <div class="max-w-md space-y-4">
                <p class="text-xs font-semibold tracking-wide text-red-400">PANEL KHUSUS PEMILIK</p>
                <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-white">
                    Kelola stok motor dan data showroom dalam satu tempat.
                </h2>
                <p class="text-sm leading-relaxed text-slate-300">
                    Unit yang Anda tambahkan otomatis tampil di katalog publik dengan status real-time, sementara harga beli dan catatan modal tetap tersimpan aman khusus di panel ini.
                </p>
            </div>

            <p class="text-xs text-slate-400">
                {{ $store['store_name'] }} &middot; {{ $store['store_address'] }}
            </p>
        </div>

        {{-- Right Form Column --}}
        <main id="login-main" class="flex flex-col justify-center px-4 py-12 sm:px-8 lg:col-span-7">
            <div class="mx-auto w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex">
                        <x-brand-mark theme="light" :store-name="$store['store_name']" />
                    </a>
                </div>

                <div class="rounded-xl border border-line bg-white p-6 sm:p-8">
                    <h1 class="text-2xl font-extrabold tracking-tight text-ink">Masuk Panel Owner</h1>
                    <p class="mt-1.5 text-sm text-muted">
                        Gunakan email dan password akun Owner {{ $store['store_name'] }}.
                    </p>

                    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5" data-prevent-double-submit>
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-ink">
                                Email Owner <span class="text-brand" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                autocorrect="off"
                                autocapitalize="none"
                                spellcheck="false"
                                enterkeyhint="next"
                                placeholder="owner@andaramotor.test"
                                @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink placeholder:text-slate-400 focus:border-brand"
                            >
                            @error('email')
                                <p id="email-error" role="alert" class="mt-1.5 text-sm font-medium text-brand">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold text-ink">
                                    Password <span class="text-brand" aria-hidden="true">*</span>
                                </label>
                                <button
                                    type="button"
                                    data-password-toggle="password"
                                    aria-pressed="false"
                                    class="min-h-8 px-1 text-xs font-semibold text-muted underline hover:text-ink"
                                >
                                    Tampilkan
                                </button>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                enterkeyhint="done"
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                                class="mt-1.5 block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-ink focus:border-brand"
                            >
                            @error('password')
                                <p id="password-error" role="alert" class="mt-1.5 text-sm font-medium text-brand">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2.5">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                value="1"
                                @checked(old('remember'))
                                class="h-4 w-4 rounded border-slate-300 accent-brand"
                            >
                            <label for="remember" class="text-sm text-muted">
                                Tetap masuk di perangkat ini
                            </label>
                        </div>

                        <button type="submit" class="btn-primary w-full">
                            Masuk ke Panel Owner
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-muted hover:text-ink">
                        Kembali ke katalog publik {{ $store['store_name'] }}
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
