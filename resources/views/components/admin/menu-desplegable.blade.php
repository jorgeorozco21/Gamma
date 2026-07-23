@props(['id' => 'dropdown-menu'])
<div id="{{ $id }}" class="absolute right-0 mt-10 w-56 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-2xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 overflow-hidden">
    <div class="py-2">
        {{ $slot }}
    </div>
</div>