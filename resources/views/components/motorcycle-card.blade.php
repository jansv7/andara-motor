@props(['motorcycle', 'whatsappNumber' => null])

@php
    $photoUrl = $motorcycle->primaryPhotoUrl();
    $waUrl = $motorcycle->whatsappUrl($whatsappNumber);
@endphp

<article class="unit-card flex h-full flex-col overflow-hidden rounded-lg border border-line bg-white">
    <a href="{{ route('catalog.show', $motorcycle->slug) }}" class="relative block aspect-[4/3] w-full overflow-hidden bg-surface">
        @if ($photoUrl)
            <img
                src="{{ $photoUrl }}"
                alt="{{ $motorcycle->fullName() }} tahun {{ $motorcycle->year }} warna {{ $motorcycle->color }}"
                width="640"
                height="480"
                loading="lazy"
                decoding="async"
                class="unit-photo h-full w-full object-cover"
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 bg-surface px-4 text-center text-muted">
                <svg class="h-10 w-10 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <circle cx="6.5" cy="16.5" r="3.5" />
                    <circle cx="17.5" cy="16.5" r="3.5" />
                    <path d="M10 16.5h4l2.5-6.5H12l-2-3H6" />
                </svg>
                <span class="text-xs font-medium">Foto unit belum diunggah</span>
            </div>
        @endif

        <div class="absolute left-3 top-3">
            <x-status-badge :status="$motorcycle->status" />
        </div>
    </a>

    <div class="flex flex-1 flex-col p-4">
        <div class="mb-1 flex items-center justify-between gap-2 text-xs font-medium text-muted">
            <span>{{ $motorcycle->brand?->name }}</span>
            <span class="tabular-nums">{{ $motorcycle->code }}</span>
        </div>

        <h3 class="text-base font-bold leading-snug text-ink">
            <a href="{{ route('catalog.show', $motorcycle->slug) }}" class="hover:text-brand">
                {{ $motorcycle->fullName() }}
            </a>
        </h3>

        <p class="mt-1.5 text-sm text-muted tabular-nums">
            {{ $motorcycle->year }} &middot; {{ $motorcycle->engine_cc }} cc &middot; {{ $motorcycle->formattedMileage() }}
        </p>

        <div class="mt-3 flex flex-wrap items-baseline gap-2 border-t border-line pt-3">
            <p class="text-lg font-extrabold tracking-tight text-ink tabular-nums">
                {{ $motorcycle->formattedSellingPrice() }}
            </p>
            <span class="rounded bg-surface px-2 py-0.5 text-xs font-semibold text-muted">
                {{ $motorcycle->is_negotiable ? 'Nego' : 'Harga Pas' }}
            </span>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-2 pt-1">
            <a
                href="{{ route('catalog.show', $motorcycle->slug) }}"
                class="btn-secondary px-3 text-sm"
            >
                Lihat Detail
            </a>
            <a
                href="{{ $waUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-primary px-3 text-sm"
            >
                Tanya WA
            </a>
        </div>
    </div>
</article>