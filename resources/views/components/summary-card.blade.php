@props(['title', 'value', 'description'])

<div {{ $attributes->merge(['class' => 'p-6 rounded-lg shadow bg-white']) }}>
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-gray-500 text-sm font-medium">{{ $title }}</h3>
            <p class="mt-2 text-3xl font-bold
                @if($title === 'Total Obat') text-green-500
                @elseif($title === 'Akan Kadaluarsa') text-yellow-500
                @elseif($title === 'Kadaluarsa') text-red-500
                @else text-gray-900
                @endif">
                {{ $value }}
            </p>
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        </div>
    </div>
</div>
