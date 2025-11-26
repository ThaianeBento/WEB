@props(['title', 'subtitle' => null, 'actionLabel' => null, 'onAction' => null, 'backTo' => null, 'icon' => null])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-4">
        @if($backTo)
            <a href="{{ $backTo }}" class="inline-flex items-center justify-center rounded-full w-10 h-10 hover:bg-slate-100 transition-colors">
                <x-icon name="ArrowLeft" class="w-5 h-5 text-slate-600" />
            </a>
        @endif
        <div>
            <div class="flex items-center gap-3">
                @if($icon)
                    <div class="p-2 rounded-xl bg-emerald-100">
                        <x-icon :name="$icon" class="w-6 h-6 text-emerald-600" />
                    </div>
                @endif
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $title }}</h1>
            </div>
            @if($subtitle)
                <p class="text-slate-500 mt-1 {{ $icon ? 'ml-12' : '' }}">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    @if($actionLabel && $onAction)
        <button 
            @click="{{ $onAction }}" 
            class="inline-flex items-center justify-center h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200"
        >
            <x-icon name="Plus" class="w-4 h-4 mr-2" />
            {{ $actionLabel }}
        </button>
    @endif
</div>
