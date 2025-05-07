@props(['title', 'value', 'description'])

@php
    $icon = '';
    if ($title == 'Total Obat') {
        $icon = 'medicine-total.png';
    } elseif ($title == 'Akan Kadaluarsa') {
        $icon = 'alert-circle.png';
    } elseif ($title == 'Kadaluarsa') {
        $icon = 'x-circle.png';
    } elseif ($title == 'Stok Menipis') {
        $icon = 'trending-down.png';
    }
    
    // Tentukan kelas warna berdasarkan judul
    $colorClass = '';
    if ($title == 'Total Obat') {
        $colorClass = 'text-total-obat';
    } elseif ($title == 'Akan Kadaluarsa') {
        $colorClass = 'text-akan-kadaluarsa';
    } elseif ($title == 'Kadaluarsa') {
        $colorClass = 'text-kadaluarsa';
    } elseif ($title == 'Stok Menipis') {
        $colorClass = 'text-stok-menipis';
    }
@endphp

<div class="col-sm-6 col-lg-3">
    <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-height: 150px; display: flex; flex-direction: column; justify-content: center;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <div class="d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--light-gray);">
                    <img src="{{ asset('assets/images/' . $icon) }}" alt="{{ $title }}" width="24" height="24">
                </div>
                <h5 class="card-title mb-0" style="font-size: 20px; font-weight: 500;">{{ $title }}</h5>
            </div>
            <p class="card-text {{ $colorClass }}" style="font-size: 31px; font-weight:500; margin-bottom: 5px;">
                {{ $value }}
            </p>
            <p class="card-text" style="font-size: 16px; font-weight:500; color: var(--dark-grey);">{{ $description }}</p>
        </div>
    </div>
</div>