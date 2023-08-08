@extends('layouts.landing')
@section('content')
<section id="gallery">
    <div class="text-center text-uppercase h3 bg-light mb-5" style="padding: 70px 0">
        Galeri Posyandu
    </div>
    <div class="container mb-5">
        <div class="row g-2">
            @foreach($galleries as $item)
            <div class="col-12 col-md-4">
                <div class="w-100 overflow-hidden">
                    <img class="fluidbox-item" src="{{ asset('storage/gallery/' . $item->image) }}" alt="{{ $item->image }}" style="width: 100%; height: 270px; object-fit: cover; object-position: center; cursor: pointer;">
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    </div>
</section>
@endsection
