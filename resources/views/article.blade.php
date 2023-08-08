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

<section id="article">
    <div class="text-center text-uppercase h3 bg-light" style="padding: 70px 0">
        Artikel Posyandu
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-md-8">
                @foreach($data as $item)
                <a href="/artikel/{{ $item->slug }}" class="row article w-100 mb-4" style="max-height: 150px; overflow: hidden">
                    <div class="col-12 col-md-5 p-0">
                        <div class="w-100 overflow-hidden bg-light">
                            <img src="{{ asset('storage/article/'.$item->image) }}" alt="{{ $item->image }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="w-100 overflow-hidden">
                            <h2 class="h6 text-uppercase">{{ $item->title }}</h2>
                            <p>{{ $item->content }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
                <div class="mt-5">
                    {{ $data->links() }}
                </div>
            </div>
            <div class="col-12 col-md-4">
                <form action="/artikel?search=" method="get">
                    <input class="form-control" id="search" name="search" type="text">
                    <button class="btn btn-primary mt-2">
                        <i class="fas fa-solid fa-magnifying-glass"></i>
                        <span>Cari Artikel</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
