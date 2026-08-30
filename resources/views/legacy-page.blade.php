@extends('layouts.portal')
@section('content')
<header class="header"><div class="container navbar"><a class="brand" href="{{ route('home') }}"><img class="logo" src="{{ route('legacy.image', ['path' => 'ncbii_logo_transparent.png']) }}" alt="NCBII logo"><div class="brand-text"><h2>North Coast Bohol Institute</h2><span>{{ $portal ?? 'Academic Information System' }}</span></div></a><a href="{{ route('login') }}" class="login-btn">Open Portal</a></div></header>
<main class="staff-main"><section class="staff-hero"><div class="container staff-heading"><div><span class="welcome-label">NCBII ACADEMIC INFORMATION SYSTEM</span><h1>{{ $heading ?? 'Portal page' }}</h1><p>{{ $description ?? 'This portal page is now served by Laravel.' }}</p></div></div></section><section class="container staff-content"><div class="access-note"><strong>Laravel portal migration active.</strong><span>The existing design system and page structure are preserved.</span></div></section></main>
@endsection
