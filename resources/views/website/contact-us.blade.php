@php
    $general = app('settings')['general'] ?? [];
@endphp

<x-website.layout :is-header-white="true">
    <div class="main">
        <div class="row py-5">
            <x-website.contact-us-card :$general />
        </div>
    </div>
</x-website.layout>
