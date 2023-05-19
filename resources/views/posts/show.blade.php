<x-app>
    <div class="offset-2">

        <div class="container mt-5">
            {{-- @foreach ($post->medias as $media)
                <img src="{{ asset('storage/posts/' . $media->path) }}" alt="Imagem">
            @endforeach
            <p class="">
                {{ $post->caption }}
            </p> --}}
            <h2>{{ $post->title }}</h2>
            <div id="carouselExample" class="carousel">
                <div class="carousel-indicators">
                    @foreach ($post->medias as $index => $media)
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                
                <div class="carousel-inner">
                    @foreach ($post->medias as $index => $media)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/posts/' . $media->path) }}" 
                            class="d-block w-100 rounded img-thumbnail mx-auto avatar" 
                            style="max-height: 500px; object-fit: cover;"
                            alt="Imagem">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
            <p class="mt-1">{{ $post->caption }}</p>
        </div>

    </div>
</x-app>
