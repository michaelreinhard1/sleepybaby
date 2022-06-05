@if (session('success'))
<div class="bg-white shadow-sm sm:rounded-lg absolute transform -translate-y-1/2 -translate-x-1/2 top-32 left-1/2">
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative w-max sm:w-fit">
        {{ session('success') }}
    </div>
</div>
@endif