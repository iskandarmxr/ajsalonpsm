@php
    $logoSetting = App\Models\SiteSetting::where('key', 'company_logo')->first();
    $logoData = $logoSetting ? json_decode($logoSetting->value, true) : null;
@endphp

<div class="inline-flex items-center">
    @if($logoData)
        <img src="data:{{ $logoData['type'] }};base64,{{ $logoData['data'] }}" 
             alt="Salon Bliss" 
             class="h-16 w-16">
    @endif
    <h1 class="text-3xl font-bold text-pink-500">AJ Hair Salon</h1>
</div>
