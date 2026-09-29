@php
    $visual = match ($item['name']) {
        'PVC Packaging', 'Garment & Textile Packaging' => ['bedding-packaging.png', 'Bedsheets and a comforter in clear zippered packaging covers'],
        'Custom Printed Packaging', 'BOPP Packaging' => ['printed-packaging.png', 'Folded garments inside printed clear packaging bags'],
        'Polybags' => ['garment-packaging.png', 'Shirts and socks inside transparent protective polybags'],
        'PP Bags' => ['pp-bags.svg', 'Crystal-clear PP bags with self-adhesive flaps holding a folded shirt and socks'],
        'PL Bags' => ['pl-bags.svg', 'Plain and printed PL bags in different sizes'],
        'PEVA (PPE) Bags' => ['peva-bags.svg', 'Soft PEVA zipper bag with carry handle holding a folded comforter'],
        'Flyer Bags' => ['flyer-bags.jpg', 'Grey and white courier flyer bags with self-seal strips'],
        'EVA Bags (China)' => ['eva-bags.svg', 'Frosted matte EVA slider-zipper bags in three sizes'],
        'Non-Woven Bags' => ['nonwoven-bags.svg', 'Non-woven fabric loop-handle tote and D-cut bag with logo print areas'],
        default => ['film-packaging.png', 'Clear packaging film rolls beside wrapped cartons'],
    };
@endphp
<div class="product-photograph"><img src="/images/{{ $visual[0] }}" alt="{{ $visual[1] }}" width="1536" height="1024" loading="lazy"><small>ILLUSTRATIVE PRODUCT MOCKUP</small></div>
