@props(['theme' => 'light', 'storeName' => 'Andara Motor'])

@php
    $isDark = $theme === 'dark';
@endphp

<span class="inline-flex items-center gap-2.5">
    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-brand text-white" aria-hidden="true">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="6.5" cy="16.5" r="3.5" />
            <circle cx="17.5" cy="16.5" r="3.5" />
            <path d="M10 16.5h4l2.5-6.5H12l-2-3H6" />
            <path d="M16.5 10h2.5" />
        </svg>
    </span>
    <span class="flex flex-col leading-none">
        <span class="text-base font-extrabold tracking-tight {{ $isDark ? 'text-white' : 'text-ink' }}">
            {{ strtoupper($storeName) }}
        </span>
        <span class="mt-0.5 text-[11px] font-semibold tracking-wide {{ $isDark ? 'text-slate-300' : 'text-muted' }}">
            SHOWROOM MOTOR BEKAS
        </span>
    </span>
</span>