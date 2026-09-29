<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WebsiteController extends Controller
{
    public function page(string $page = 'home', ?string $slug = null)
    {
        $company = config('pakflex');
        $product = $page === 'product' ? ($company['products'][$slug] ?? null) : null;
        $industry = $page === 'industry' ? ($company['industries'][$slug] ?? null) : null;
        abort_if(($page === 'product' && !$product) || ($page === 'industry' && !$industry), 404);
        $titles = ['home' => 'Polybags, Films & Flexible Packaging Pakistan', 'about' => 'Packaging Built Around Your Requirements', 'products' => 'Our Packaging Range', 'industries' => 'Packaging for Your Industry', 'custom-packaging' => 'Packaging Designed Around Your Product', 'quality' => 'Quality Starts With Consistent Specifications', 'contact' => 'Let’s Discuss Your Packaging Requirement', 'request-a-quote' => 'Tell Us What You Need', 'privacy' => 'Enquiry Privacy', 'image-credits' => 'Image Credits'];
        $title = $product['name'] ?? $industry['name'] ?? $titles[$page] ?? 'PakFlex Packaging';
        $descriptions = [
            'home' => 'PakFlex Packaging supplies customized polybags, PP, PEVA, EVA, flyer and non-woven bags, garment packaging, PVC packaging and PP and PL films for manufacturers and exporters in Pakistan.',
            'about' => 'Meet PakFlex Packaging, a Faisalabad-based flexible packaging supplier focused on clear specifications for manufacturers, exporters and business buyers.',
            'products' => 'Explore polybags, PP and PL bags, PEVA, EVA, flyer and non-woven bags, garment packaging, PVC packaging, PP and PL films, BOPP and custom printed packaging from PakFlex Packaging in Pakistan.',
            'industries' => 'Packaging solutions for textile, apparel, home textile, industrial, logistics and retail buyers. Discuss your industry requirements with PakFlex.',
            'custom-packaging' => 'Specify your packaging size, material, thickness, printing and closure. Start a custom packaging enquiry with PakFlex Packaging in Faisalabad.',
            'quality' => 'Discover PakFlex Packaging’s approach to agreed material, dimensions, thickness, printing, sealing and packing specifications.',
            'contact' => 'Contact Faheem Bilal at PakFlex Packaging, Faisalabad, Pakistan, to discuss your packaging requirements and delivery destination.',
            'request-a-quote' => 'Request a B2B packaging quotation. Share your product, material, dimensions, quantity, delivery location and optional artwork with PakFlex.',
            'privacy' => 'Learn how PakFlex Packaging handles contact information, packaging enquiries and uploaded artwork.',
            'image-credits' => 'Photography sources and product illustration information for the PakFlex Packaging website.',
        ];
        $description = $product['description'] ?? $industry['description'] ?? $descriptions[$page];
        return view('site', compact('page', 'slug', 'company', 'product', 'industry', 'title', 'description'));
    }

    public function quote(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120', 'company' => 'required|string|max:160',
            'email' => 'required|email|max:200', 'phone' => 'required|string|max:40',
            'country' => 'required|string|max:100',
            'product' => ['required', Rule::in(array_merge(array_keys(config('pakflex.products')), ['not-sure']))],
            'material' => 'nullable|string|max:120', 'size' => 'nullable|string|max:120',
            'thickness' => 'nullable|string|max:120', 'printing' => 'nullable|string|max:200',
            'quantity' => 'nullable|string|max:120', 'delivery' => 'nullable|string|max:200',
            'message' => 'nullable|string|max:5000', 'consent' => 'accepted',
            'artwork' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'website' => 'nullable|size:0',
        ]);
        unset($data['artwork'], $data['website']);
        $reference = 'PF-'.strtoupper(Str::random(10));
        $disk = Storage::disk('local');
        $path = null;
        try {
            if ($request->hasFile('artwork')) {
                $path = $request->file('artwork')->store('enquiries/'.$reference, 'local');
                if (!$path) throw new \RuntimeException('Upload could not be saved.');
                $data['artwork_path'] = $path;
                $data['artwork_name'] = $request->file('artwork')->getClientOriginalName();
            }
            $saved = $disk->put('enquiries/'.$reference.'/enquiry.json', json_encode(array_merge($data, ['reference' => $reference, 'received_at' => now()->toIso8601String()]), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
            if (!$saved) throw new \RuntimeException('Enquiry could not be saved.');
        } catch (\Throwable $error) {
            if ($path) $disk->delete($path);
            report($error);
            return back()->withInput()->withErrors(['submission' => 'We could not save your enquiry. Please try again.']);
        }
        $record = array_merge($data, ['reference' => $reference, 'received_at' => now()->toIso8601String()]);
        try {
            app(\App\Services\EnquiryNotification::class)->send($record);
        } catch (\Throwable $error) {
            // The enquiry is already saved; a notification failure must not lose it.
            report($error);
        }
        $summary = 'Hello PakFlex Packaging, I submitted enquiry '.$reference.'. Product: '.(config('pakflex.products.'.$data['product'].'.name') ?? 'Needs guidance').'. Please review my packaging requirement.';
        return redirect('/request-a-quote')->with('reference', $reference)->with('whatsapp_summary', $summary);
    }
}
