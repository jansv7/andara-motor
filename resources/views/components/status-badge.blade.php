@props(['status'])

@php
    $config = match ($status) {
        'available' => [
            'label' => 'Tersedia',
            'classes' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'dot' => 'bg-emerald-600',
        ],
        'booked' => [
            'label' => 'Dipesan',
            'classes' => 'bg-amber-50 text-amber-900 border-amber-200',
            'dot' => 'bg-amber-500',
        ],
        'sold' => [
            'label' => 'Terjual',
            'classes' => 'bg-red-50 text-red-800 border-red-200',
            'dot' => 'bg-red-600',
        ],
        default => [
            'label' => ucfirst((string) $status),
            'classes' => 'bg-slate-100 text-slate-800 border-slate-200',
            'dot' => 'bg-slate-500',
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded border px-2.5 py-0.5 text-xs font-semibold tracking-tight '.$config['classes']]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $config['dot'] }}" aria-hidden="true"></span>
    {{ $config['label'] }}
</span>
