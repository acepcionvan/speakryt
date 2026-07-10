@props([
    'href',
    'label' => 'Back',
])

<a {{ $attributes->merge(['class' => 'group inline-flex items-center gap-2 rounded-lg border border-[#c4c6cf] bg-white px-4 py-2 text-sm font-bold text-[#022448] shadow-sm transition-all hover:border-[#d5e3ff] hover:bg-[#d5e3ff]']) }} href="{{ $href }}">
    <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
    <span>{{ $label }}</span>
</a>
