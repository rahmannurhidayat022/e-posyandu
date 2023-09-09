@extends('layouts.landing')
@section('content')
<style>
    a {
        text-decoration: none;
        color: inherit;
    }

    .article:hover {
        opacity: .7;
    }
</style>
<section id="article-detail" class="min-vh-100">
    <nav class="pt-3 pb-2 bg-light" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('artikel') }}">Kembali</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->slug }}</li>
            </ol>
        </div>
    </nav>
    <div class="container py-4">
        <div class="row mb-5">
            <div class="col-12 col-md-8">
                <h2 class="h1 mb-2">{{ $data->title }}</h2>
                <span class="text-muted">Diperbaharui pada {{ $data->updated_at }}</span>
                <div class="w-100 overflow-hidden bg-light my-4">
                    <img src="{{ asset('storage/article/'.$data->image) }}" alt="{{ $data->image }}" style="width: 100%; object-position: center; object-fit: cover; max-height: 400px">
                </div>
                <p class="text-left lh-lg" style="font-size: 16px">
                    {!! $data->content !!}
                </p>
            </div>
            <div class="col-12 col-md-4">
                <div class="w-100 mt-5">
                    <h4 class="h6">Artikel Lainnya</h4>
                    <hr>
                    @foreach($articles as $item)
                    <a href="/artikel/{{ $item->slug }}" class="row article mb-3 overflow-hidden" style="max-height: 100px">
                        <div class="col-5">
                            <img src="{{ asset('storage/article/'.$item->image) }}" alt="{{ $item->image}}" style="width: 100%; height: 100%; object-fit: cover; object-position: center">
                        </div>
                        <div class="col-7">
                            <h5 class="h6">{{ $item->title }}</h5>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
