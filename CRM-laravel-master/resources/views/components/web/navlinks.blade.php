@php
    use App\Enums\UserRolesEnum;
    $userRole = Auth::User()?->role()->first()->name;
@endphp

{{-- Nav Links for the customer facing web --}}
@if(!Auth::check() || (Auth::check() && Auth::user()->role_id == UserRolesEnum::Customer->value))
    <x-nav-link href="{{ route('services') }}" :active="request()->routeIs('services')">
        {{ __('Hair Services') }}
    </x-nav-link>

    <x-nav-link href="{{ route('hairstyles') }}" :active="request()->routeIs('hairstyles')">
        {{ __('Hairstyles') }}
    </x-nav-link>

    <x-nav-link href="{{ route('deals') }}" :active="request()->routeIs('deals')">
        {{ __('Deals') }}
    </x-nav-link>
@endif
{{-- 
<x-nav-link href="{{ route('manageusers') }}" :active="request()->routeIs('manageusers')">
    {{ __('Manage Users') }}
</x-nav-link> --}}