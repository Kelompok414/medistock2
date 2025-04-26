<div class="col-sm-6 col-lg-3">
    <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-height: 150px; display: flex; flex-direction: column; justify-content: center;">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 20px; font-weight: 500;">{{ $title }}</h5>
            <p class="card-text" style="font-size: 31px; font-weight:500; margin-bottom: 5px; 
                color: @if($title == 'Total Obat') var(--primary) 
                     @elseif($title == 'Akan Kadaluarsa') var(--warning)
                     @elseif($title == 'Kadaluarsa') var(--danger)
                     @elseif($title == 'Stok Menipis') var(--black)
                     @else var(--primary) @endif;">
                {{ $value }}
            </p>
            <p class="card-text" style="font-size: 16px; font-weight:500; color: var(--dark-grey);">{{ $description }}</p>
        </div>
    </div>
</div>