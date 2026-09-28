@php
    $visual = match ($item['name']) {
        'PVC Packaging', 'Garment & Textile Packaging' => ['bedding-packaging.png', 'Bedsheets and a comforter in clear zippered packaging covers'],
        'Custom Printed Packaging', 'BOPP Packaging' => ['printed-packaging.png', 'Folded garments inside printed clear packaging bags'],
        'Polybags' => ['garment-packaging.png', 'Shirts and socks inside transparent protective polybags'],
        default => ['film-packaging.png', 'Clear packaging film rolls beside wrapped cartons'],
    };
@endphp
<div class="product-photograph"><img src="/images/{{ $visual[0] }}" alt="{{ $visual[1] }}" width="1536" height="1024" loading="lazy"><small>ILLUSTRATIVE PRODUCT MOCKUP</small></div>
