<a {{ $attributes->merge(['class' => 'w-max p-3 text-white bg-emerald-500 rounded-md focus:bg-emerald-600 focus:outline-none active:bg-emerald-900 focus:outline-none focus:border-emerald-900 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
