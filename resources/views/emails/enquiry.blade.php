<h1>New packaging enquiry</h1>
<p>Reference: <strong>{{ $enquiry['reference'] }}</strong></p>
<p>Reply to this email to contact the buyer.</p>
<table cellpadding="8" cellspacing="0" border="1">
@foreach(['received_at'=>'Received','name'=>'Name','company'=>'Company','email'=>'Email','phone'=>'Phone / WhatsApp','country'=>'Country','product'=>'Product','material'=>'Material','size'=>'Size','thickness'=>'Thickness','printing'=>'Printing','quantity'=>'Quantity','delivery'=>'Delivery location','message'=>'Additional requirements'] as $key=>$label)
<tr><th align="left">{{ $label }}</th><td style="white-space:pre-wrap">{{ $key === 'product' ? (config('pakflex.products.'.$enquiry[$key].'.name') ?? 'Needs guidance') : ($enquiry[$key] ?? 'Not specified') }}</td></tr>
@endforeach
</table>
@if(!empty($enquiry['artwork_path']))<p>The buyer’s artwork/specification is attached.</p>@endif
