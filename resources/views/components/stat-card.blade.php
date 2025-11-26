@props(['title', 'value', 'icon', 'color', 'subtitle' => null])

@php
    $colors = [
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'rose' => 'bg-rose-50 text-rose-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'slate' => 'bg-slate-50 text-slate-600',
    ];
    $iconColor = $colors[$color] ?? 'bg-emerald-50 text-emerald-600';
@endphp

<div class="p-6 hover:shadow-lg transition-all duration-300 border-0 bg-white rounded-xl shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs text-slate-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="p-3 rounded-xl {{ $iconColor }}">
            <x-icon :name="$icon" class="w-6 h-6" />
        </div>
    </div>
</div>
