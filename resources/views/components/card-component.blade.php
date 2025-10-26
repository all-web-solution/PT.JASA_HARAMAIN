{{-- Hapus col-* dari sini, tambahkan $attributes->merge --}}
<div {{ $attributes->merge(['class' => '']) }} id="card-reponsive">
    <div class="card card-stat h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="justify-content-evenly">
                    <h6 class="card-title mb-3">{{ $title }}</h6>
                    <h3 class="card-subtitle fw-bold mb-2" style="color: var(--haramain-primary);">
                        {{ $count }}
                        </h3>
                    <p class="card-text {{ $textColor }} mb-0"><small>{{ $desc }}</small>
                    </p>
                    </div>
                <div class="bg-opacity-10 p-3 rounded">
                    <i class="bi {{ $icon }} fs-2" style="color: {{ $iconColor }};"></i>
                    </div>
                </div>
            </div>
        </div>
</div>
