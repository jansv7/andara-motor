<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Owner') | Andara Motor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-surface text-ink antialiased">
    <a href="#owner-main" class="skip-link">Lewati ke konten utama</a>

    <div class="flex min-h-screen flex-col lg:flex-row">
        {{-- Desktop Sidebar --}}
        <aside class="hidden w-64 shrink-0 flex-col bg-ink text-white lg:flex">
            <div class="flex h-16 items-center border-b border-white/10 px-5">
                <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center">
                    <x-brand-mark theme="dark" />
                </a>
            </div>

            <nav aria-label="Navigasi Panel Owner" class="flex-1 space-y-6 px-3 py-5">
                <div>
                    <p class="px-3 text-xs font-semibold text-slate-400">Ringkasan</p>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a
                                href="{{ route('owner.dashboard') }}"
                                @if (request()->routeIs('owner.dashboard')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="7" height="9" rx="1" />
                                    <rect x="14" y="3" width="7" height="5" rx="1" />
                                    <rect x="14" y="12" width="7" height="9" rx="1" />
                                    <rect x="3" y="16" width="7" height="5" rx="1" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-slate-400">Inventori Showroom</p>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a
                                href="{{ route('owner.motorcycles.index') }}"
                                @if (request()->routeIs('owner.motorcycles.*')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="6.5" cy="16.5" r="3" />
                                    <circle cx="17.5" cy="16.5" r="3" />
                                    <path d="M9.5 16.5h5l2-6H12l-2-3H6" />
                                </svg>
                                <span>Unit Motor</span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('owner.brands.index') }}"
                                @if (request()->routeIs('owner.brands.*')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M4 7h16M4 12h16M4 17h10" />
                                </svg>
                                <span>Merek Motor</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="px-3 text-xs font-semibold text-slate-400">Situs Publik</p>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a
                                href="{{ route('home') }}"
                                class="flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M3 10.5 12 3l9 7.5" />
                                    <path d="M5 9.5V20h14V9.5" />
                                </svg>
                                <span>Beranda Publik</span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('catalog.index') }}"
                                class="flex min-h-11 items-center gap-3 rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <path d="M3 10h18" />
                                </svg>
                                <span>Katalog Publik</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="mb-3">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()?->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ auth()->user()?->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex min-h-11 w-full items-center justify-center gap-2 rounded-md border border-white/20 px-3 text-sm font-semibold text-white hover:bg-white/10"
                    >
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 border-b border-line bg-white">
                <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            data-menu-toggle
                            aria-controls="owner-mobile-nav"
                            aria-expanded="false"
                            aria-label="Buka menu navigasi panel"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-line bg-white text-ink hover:bg-surface lg:hidden"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                        </button>
                        <div>
                            <p class="text-xs font-semibold text-muted lg:hidden">Andara Motor</p>
                            <h1 class="text-base font-bold text-ink sm:text-lg">@yield('page_title', 'Panel Owner')</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3">
                        @yield('header_actions')
                        <a href="{{ route('catalog.index') }}" class="btn-secondary hidden text-sm sm:inline-flex">
                            Lihat Katalog
                        </a>
                    </div>
                </div>

                {{-- Mobile drawer --}}
                <nav
                    id="owner-mobile-nav"
                    aria-label="Navigasi Panel Owner Mobile"
                    hidden
                    class="border-t border-white/10 bg-ink px-4 py-4 text-white lg:hidden"
                >
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="{{ route('owner.dashboard') }}"
                                @if (request()->routeIs('owner.dashboard')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center rounded-md px-3 text-sm font-medium text-slate-200 hover:bg-white/10"
                            >
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('owner.motorcycles.index') }}"
                                @if (request()->routeIs('owner.motorcycles.*')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center rounded-md px-3 text-sm font-medium text-slate-200 hover:bg-white/10"
                            >
                                Unit Motor
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('owner.brands.index') }}"
                                @if (request()->routeIs('owner.brands.*')) aria-current="page" @endif
                                class="owner-nav-link flex min-h-11 items-center rounded-md px-3 text-sm font-medium text-slate-200 hover:bg-white/10"
                            >
                                Merek Motor
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('catalog.index') }}"
                                class="flex min-h-11 items-center rounded-md px-3 text-sm font-medium text-slate-300 hover:bg-white/10"
                            >
                                Katalog Publik
                            </a>
                        </li>
                    </ul>
                    <div class="mt-4 border-t border-white/10 pt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex min-h-11 w-full items-center justify-center rounded-md border border-white/20 px-3 text-sm font-semibold text-white hover:bg-white/10"
                            >
                                Keluar ({{ auth()->user()?->name }})
                            </button>
                        </form>
                    </div>
                </nav>
            </header>

            <main id="owner-main" class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-6xl">
                    <x-alert />
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
