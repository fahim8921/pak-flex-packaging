<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PackagingWebsiteTest extends TestCase
{
    public function test_all_business_pages_render_and_unknown_products_are_not_found(): void
    {
        foreach (['/', '/about', '/products', '/industries', '/quality', '/custom-packaging', '/contact', '/request-a-quote', '/privacy', '/image-credits'] as $path) {
            $this->get($path)->assertOk()->assertSee('PakFlex Packaging');
        }
        foreach (array_keys(config('pakflex.products')) as $slug) $this->get('/products/'.$slug)->assertOk()->assertSee('Available according to requirement');
        foreach (array_keys(config('pakflex.industries')) as $slug) $this->get('/industries/'.$slug)->assertOk();
        $this->get('/products/unknown')->assertNotFound();
        $this->get('/industries/unknown')->assertNotFound();
        $this->get('/sitemap.xml')->assertOk()->assertSee('/products/garment-packaging');
    }

    private function enquiry(): array
    {
        return ['name' => 'Test Buyer', 'company' => 'Example Textile', 'email' => 'buyer@example.com', 'phone' => '+92 300 0000000', 'country' => 'Pakistan', 'product' => 'polybags', 'consent' => '1'];
    }

    public function test_quote_is_saved_privately_with_an_artwork_file_and_reference(): void
    {
        Storage::fake('local');
        $response = $this->post('/request-a-quote', $this->enquiry() + ['artwork' => UploadedFile::fake()->create('specification.pdf', 100, 'application/pdf')]);
        $response->assertRedirect('/request-a-quote')->assertSessionHas('reference');
        $reference = session('reference');
        $disk = Storage::disk('local');
        $record = json_decode($disk->get('enquiries/'.$reference.'/enquiry.json'), true);
        $this->assertSame('buyer@example.com', $record['email']);
        $disk->assertExists($record['artwork_path']);
        $this->get('/storage/'.$record['artwork_path'])->assertNotFound();
    }

    public function test_invalid_quotes_and_unsafe_uploads_are_rejected(): void
    {
        Storage::fake('local');
        $this->post('/request-a-quote', [])->assertSessionHasErrors(['name', 'email', 'product', 'consent']);
        $this->post('/request-a-quote', array_replace($this->enquiry(), ['product' => 'made-up', 'artwork' => UploadedFile::fake()->create('script.php', 1, 'text/plain')]))->assertSessionHasErrors(['product', 'artwork']);
        $this->post('/request-a-quote', $this->enquiry() + ['artwork' => UploadedFile::fake()->create('large.pdf', 10241, 'application/pdf')])->assertSessionHasErrors('artwork');
        $this->assertEmpty(Storage::disk('local')->allFiles('enquiries'));
    }

    public function test_failed_storage_does_not_report_success(): void
    {
        Storage::shouldReceive('disk')->with('local')->once()->andReturnSelf();
        Storage::shouldReceive('put')->once()->andReturn(false);
        $this->post('/request-a-quote', $this->enquiry())->assertSessionHasErrors('submission')->assertSessionMissing('reference');
    }

    public function test_configured_sales_notification_and_whatsapp_reference(): void
    {
        Storage::fake('local');
        \Illuminate\Support\Facades\Mail::fake();
        config(['pakflex.enquiry_email' => 'sales@example.com', 'mail.default' => 'smtp']);
        $this->post('/request-a-quote', $this->enquiry())->assertRedirect('/request-a-quote')->assertSessionHas('whatsapp_summary');
        $reference = session('reference');
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\PackagingEnquiry::class, fn ($mail) => $mail->hasTo('sales@example.com') && $mail->enquiry['reference'] === $reference);
        $this->assertStringContainsString('sent', Storage::disk('local')->get('enquiries/'.$reference.'/notification.json'));
        $this->get('/request-a-quote')->assertSee('Follow up on WhatsApp')->assertSee($reference);
    }

    public function test_email_failure_keeps_saved_enquiry_for_retry(): void
    {
        Storage::fake('local');
        config(['pakflex.enquiry_email' => 'sales@example.com', 'mail.default' => 'smtp']);
        \Illuminate\Support\Facades\Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('Mail service unavailable'));
        $this->post('/request-a-quote', $this->enquiry())->assertRedirect('/request-a-quote')->assertSessionHas('reference');
        $directory = 'enquiries/'.session('reference');
        Storage::disk('local')->assertExists($directory.'/enquiry.json');
        $this->assertStringContainsString('failed', Storage::disk('local')->get($directory.'/notification.json'));
    }
}
