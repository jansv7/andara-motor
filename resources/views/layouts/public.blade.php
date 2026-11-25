@php
    $storeProfile = $store ?? \App\Models\Setting::storeProfile();
    $waPhone = preg_replace('/\D+/', '', $storeProfile['whatsapp_number'] ?? '6281234567890');
    $waGeneralUrl = 'https://wa.me/'.$waPhone.'?text='.rawurlencode('Halo '.$storeProfile['store_name'].', saya ingin menanyakan stok motor bekas yang tersedia.');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="@yield('meta_description', $storeProfile['store_tagline'])">
    <meta name="theme-color" content="#111318">
    @yield('meta_tags')
    <title>@yield('title', $storeProfile['store_name'].' | Showroom Motor Bekas')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white text-ink antialiased @yield('body_class')">
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    <header class="sticky top-0 z-40 border-b border-line bg-white">
        {{-- Top utility strip matching reference header contrast --}}
        <div class="bg-ink text-white">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-2 text-xs sm:px-6 lg:px-8">
                <p class="font-medium text-slate-300">
                    {{ $storeProfile['store_address'] }} &middot; {{ $storeProfile['opening_hours'] }}
                </p>
                <a
                    href="{{ $waGeneralUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex min-h-8 items-center gap-1.5 rounded bg-brand px-3 py-1 text-xs font-semibold text-white hover:bg-brand-hover"
                >
                    Hubungi WhatsApp
                </a>
            </div>
        </div>

        {{-- Main white header row with logo, functional search bar, and real destinations --}}
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="shrink-0">
                <x-brand-mark theme="light" :store-name="$storeProfile['store_name']" />
            </a>

            <search class="hidden flex-1 max-w-xl md:block">
                <form action="{{ route('catalog.index') }}" method="GET" class="flex items-stretch overflow-hidden rounded-md border border-slate-300 bg-white focus-within:border-ink">
                    <label for="header-search-q" class="sr-only">Cari merek atau model motor</label>
                    <input
                        id="header-search-q"
                        name="q"
                        type="search"
                        value="{{ request('q') }}"
                        placeholder="Cari motor, misal Vario, NMAX, Honda..."
                        autocorrect="off"
                        spellcheck="false"
                        class="min-h-11 flex-1 border-0 bg-transparent px-3.5 text-sm text-ink placeholder:text-slate-500 focus:outline-none"
                    >
                    <label for="header-search-category" class="sr-only">Kategori motor</label>
                    <select
                        id="header-search-category"
                        name="category"
                        class="min-h-11 border-0 border-l border-line bg-surface pl-3.5 pr-9 text-sm font-medium text-ink focus:outline-none"
                    >
                        <option value="">Semua Kategori</option>
                        <option value="matic" @selected(request('category') === 'matic')>Matic</option>
                        <option value="sport" @selected(request('category') === 'sport')>Sport</option>
                        <option value="bebek" @selected(request('category') === 'bebek')>Bebek</option>
                        <option value="trail" @selected(request('category') === 'trail')>Trail</option>
                    </select>
                    <button
                        type="submit"
                        aria-label="Cari unit motor"
                        class="flex min-h-11 w-12 shrink-0 items-center justify-center bg-ink text-white hover:bg-ink-soft"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-3.5-3.5" />
                        </svg>
                    </button>
                </form>
            </search>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('owner.dashboard') }}" class="btn-secondary hidden text-sm md:inline-flex">
                        Panel Owner
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary hidden text-sm md:inline-flex">
                        Masuk Owner
                    </a>
                @endauth

                <button
                    type="button"
                    data-menu-toggle
                    aria-controls="public-mobile-menu"
                    aria-expanded="false"
                    aria-label="Buka menu navigasi"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-line bg-white text-ink hover:bg-surface md:hidden"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Dark secondary navigation bar (real destinations only, R-24) --}}
        <nav aria-label="Navigasi Utama" class="hidden border-t border-white/10 bg-ink md:block">
            <div class="mx-auto flex max-w-7xl items-center gap-1 px-4 sm:px-6 lg:px-8">
                <a
                    href="{{ route('home') }}"
                    @if (request()->routeIs('home')) aria-current="page" @endif
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Beranda
                </a>
                <a
                    href="{{ route('catalog.index') }}"
                    @if (request()->routeIs('catalog.index') && ! request('category')) aria-current="page" @endif
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Semua Unit
                </a>
                <a
                    href="{{ route('catalog.index', ['category' => 'matic']) }}"
                    @if (request()->routeIs('catalog.index') && request('category') === 'matic') aria-current="page" @endif
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Motor Matic
                </a>
                <a
                    href="{{ route('catalog.index', ['category' => 'sport']) }}"
                    @if (request()->routeIs('catalog.index') && request('category') === 'sport') aria-current="page" @endif
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Motor Sport
                </a>
                <a
                    href="{{ route('catalog.index', ['category' => 'bebek']) }}"
                    @if (request()->routeIs('catalog.index') && request('category') === 'bebek') aria-current="page" @endif
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Motor Bebek
                </a>
                <a
                    href="{{ route('home') }}#merek"
                    class="nav-link inline-flex min-h-11 items-center px-4 text-sm font-semibold text-slate-300 hover:text-white"
                >
                    Merek
                </a>
            </div>
        </nav>

        {{-- Mobile collapsible navigation & search --}}
        <div id="public-mobile-menu" hidden class="border-t border-white/10 bg-ink px-4 py-4 text-white md:hidden">
            <search>
                <form action="{{ route('catalog.index') }}" method="GET" class="mb-4 flex gap-2">
                    <label for="mobile-search-q" class="sr-only">Cari motor</label>
                    <input
                        id="mobile-search-q"
                        name="q"
                        type="search"
                        value="{{ request('q') }}"
                        placeholder="Cari merek atau model..."
                        class="min-h-11 flex-1 rounded-md border border-white/20 bg-white/10 px-3 text-sm text-white placeholder:text-slate-300"
                    >
                    <button type="submit" class="btn-primary px-4 text-sm">Cari</button>
                </form>
            </search>
            <nav aria-label="Navigasi Mobile" class="space-y-1">
                <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif class="flex min-h-11 items-center rounded px-3 text-sm font-semibold text-white hover:bg-white/10">Beranda</a>
                <a href="{{ route('catalog.index') }}" @if (request()->routeIs('catalog.index') && ! request('category')) aria-current="page" @endif class="flex min-h-11 items-center rounded px-3 text-sm font-semibold text-slate-200 hover:bg-white/10">Semua Unit</a>
                <a href="{{ route('catalog.index', ['category' => 'matic']) }}" class="flex min-h-11 items-center rounded px-3 text-sm font-semibold text-slate-200 hover:bg-white/10">Motor Matic</a>
                <a href="{{ route('catalog.index', ['category' => 'sport']) }}" class="flex min-h-11 items-center rounded px-3 text-sm font-semibold text-slate-200 hover:bg-white/10">Motor Sport</a>
                <a href="{{ route('catalog.index', ['category' => 'bebek']) }}" class="flex min-h-11 items-center rounded px-3 text-sm font-semibold text-slate-200 hover:bg-white/10">Motor Bebek</a>
                @auth
                    <a href="{{ route('owner.dashboard') }}" class="mt-2 flex min-h-11 items-center justify-center rounded border border-white/20 px-3 text-sm font-semibold text-white hover:bg-white/10">Panel Owner</a>
                @else
                    <a href="{{ route('login') }}" class="mt-2 flex min-h-11 items-center justify-center rounded border border-white/20 px-3 text-sm font-semibold text-white hover:bg-white/10">Masuk Owner</a>
                @endauth
            </nav>
        </div>
    </header>

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 bg-ink text-slate-300">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-12">
                <div class="space-y-3 md:col-span-5">
                    <x-brand-mark theme="dark" :store-name="$storeProfile['store_name']" />
                    <p class="max-w-sm text-sm leading-relaxed text-slate-300">
                        {{ $storeProfile['store_tagline'] }}. Seluruh spesifikasi surat, pajak, dan jarak tempuh ditampilkan transparan sesuai kondisi unit di showroom.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h3 class="text-sm font-bold text-white">Navigasi</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-white">Katalog Semua Unit</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'matic']) }}" class="hover:text-white">Unit Matic</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'sport']) }}" class="hover:text-white">Unit Sport</a></li>
                        @auth
                            <li><a href="{{ route('owner.dashboard') }}" class="hover:text-white">Panel Owner</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white">Masuk Panel Owner</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="md:col-span-4">
                    <h3 class="text-sm font-bold text-white">Showroom &amp; Kontak</h3>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div>
                            <dt class="sr-only">Alamat</dt>
                            <dd>{{ $storeProfile['store_address'] }}</dd>
                        </div>
                        <div>
                            <dt class="sr-only">Jam Operasional</dt>
                            <dd>{{ $storeProfile['opening_hours'] }}</dd>
                        </div>
                        <div class="pt-2">
                            <a
                                href="{{ $waGeneralUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-wa text-sm"
                            >
                                Chat WhatsApp Showroom
                            </a>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} {{ $storeProfile['store_name'] }}. Hak cipta dilindungi.</p>
                <p>Foto unit contoh melalui Wikimedia Commons (CC0 / CC BY / CC BY-SA).</p>
            </div>
        </div>
    </footer>
</body>
</html>
