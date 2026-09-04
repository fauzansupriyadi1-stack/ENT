@extends('layouts.app')

@section('content')
    {{-- Breaking News Ticker Partial --}}
    @include('partials.breaking-news')

    {{-- Hero Grid Section Partial --}}
    @include('partials.hero-grid')

    {{-- More News Section Partial --}}
    @include('partials.more-news')
@endsection
