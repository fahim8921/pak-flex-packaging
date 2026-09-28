<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;

Route::get('/', [WebsiteController::class, 'page']);
foreach (['about', 'products', 'industries', 'custom-packaging', 'quality', 'contact', 'request-a-quote', 'privacy', 'image-credits'] as $page) {
    Route::get('/'.$page, fn () => app(WebsiteController::class)->page($page));
}
Route::get('/products/{slug}', fn ($slug) => app(WebsiteController::class)->page('product', $slug));
Route::get('/industries/{slug}', fn ($slug) => app(WebsiteController::class)->page('industry', $slug));
Route::post('/request-a-quote', [WebsiteController::class, 'quote'])->middleware('throttle:5,1')->name('quote.submit');
Route::get('/sitemap.xml', function () {
    $paths = array_merge(['', 'about', 'products', 'industries', 'custom-packaging', 'quality', 'contact', 'request-a-quote'], array_map(fn ($s) => 'products/'.$s, array_keys(config('pakflex.products'))), array_map(fn ($s) => 'industries/'.$s, array_keys(config('pakflex.industries'))));
    return response(view('sitemap', compact('paths')), 200)->header('Content-Type', 'application/xml');
});
