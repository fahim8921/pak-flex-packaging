@if(session('reference'))<div class="notice success" role="status"><h3>Thank you. Your enquiry has been received.</h3><p>Your reference is <strong>{{ session('reference') }}</strong>. Keep this number for your records.</p></div>@endif
@if($errors->any())<div class="notice error" role="alert"><h3>Please check your enquiry</h3><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form action="{{ route('quote.submit') }}" method="post" enctype="multipart/form-data" class="quote-form">
@csrf
<div class="form-grid">
@foreach(['name' => ['Full name', 'text', 'name'], 'company' => ['Company name', 'text', 'organization'], 'email' => ['Business email', 'email', 'email'], 'phone' => ['WhatsApp / phone', 'tel', 'tel'], 'country' => ['Country', 'text', 'country-name']] as $field => $details)
<label>{{ $details[0] }} <span>*</span><input name="{{ $field }}" type="{{ $details[1] }}" autocomplete="{{ $details[2] }}" value="{{ old($field) }}" required maxlength="{{ $field === 'phone' ? 40 : ($field === 'country' ? 100 : 120) }}" @if($field === 'phone') placeholder="Include country code" @endif></label>
@endforeach
<label>Product <span>*</span><select name="product" required><option value="">Select a packaging product</option>@foreach($company['products'] as $key => $entry)<option value="{{ $key }}" @selected(old('product', request('product', $slug ?? '')) === $key)>{{ $entry['name'] }}</option>@endforeach<option value="not-sure" @selected(old('product') === 'not-sure')>Not sure — I need guidance</option></select></label>
@foreach(['material' => 'Material', 'size' => 'Size (include units)', 'thickness' => 'Thickness (include units)', 'printing' => 'Printing requirement', 'quantity' => 'Quantity (pieces / kg / rolls)', 'delivery' => 'Delivery location'] as $field => $label)<label>{{ $label }}<input name="{{ $field }}" value="{{ old($field) }}" maxlength="120"></label>@endforeach
<label class="full">Additional requirements<textarea name="message" rows="4" maxlength="5000" placeholder="Tell us about your product, closure, packing or delivery requirements.">{{ old('message') }}</textarea></label>
<label class="full upload">Artwork or specification<input type="file" name="artwork" accept=".pdf,.jpg,.jpeg,.png,.webp"><small>PDF, JPG, PNG or WebP · Up to 10 MB</small></label>
<label class="honeypot" aria-hidden="true">Website<input name="website" tabindex="-1" autocomplete="off"></label>
<label class="full consent"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>I agree that PakFlex may use these details to respond to my enquiry. <a href="/privacy">Privacy notice</a>.</span></label>
</div><button class="button green" type="submit">Send your requirement <span>↗</span></button><p class="form-note">Fields marked * are required. Specifications and availability are confirmed with your quotation.</p>
</form>
