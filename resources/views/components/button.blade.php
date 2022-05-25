<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full px-3 py-4 text-white bg-emerald-500 rounded-md focus:bg-emerald-600 focus:outline-none active:bg-emerald-900 focus:outline-none focus:border-emerald-900 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
