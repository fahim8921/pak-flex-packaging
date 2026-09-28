<div class="product-grid">
@foreach($selection as $key => $item)
<article class="product-card">
<a class="product-image-link" href="/products/{{ $key }}" aria-label="Explore {{ $item['name'] }}">@include('partials.product-art')<span class="circle-arrow">↗</span></a>
<div class="product-copy"><span class="eyebrow">{{ $item['label'] }}</span><h3><a href="/products/{{ $key }}">{{ $item['name'] }}</a></h3><p>{{ $item['description'] }}</p><a class="text-link" href="/request-a-quote?product={{ $key }}">Request a quote <span>→</span></a></div>
</article>
@endforeach
</div>
