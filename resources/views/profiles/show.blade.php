<x-app>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ 
                $user->profile->profileImage ?
                asset('storage/profile_images/' . $user->profile->profileImage->path) :
                asset('storage/profile_images/no-logo.png') }}" 
                class="rounded-circle w-50" style="border: 1px solid #e4e3e1">
            </div>
            {{-- </div>{{ asset('storage/posts/' . $media->path) }} --}}
            <div class="col-md-8">
                <div class="justify-content-between align-items-baseline">
                    <div class="d-flex align-items-start pb-2 ">
                        <h3 class="font-weight-light me-3">{{ $user->username }}</h3>
                        {{-- <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button> --}}
                        @auth
                            <a href="{{ route('profiles.edit', $user->profile->id) }}" class="btn btn-outline-secondary">Edit Profile</a>
                        @endauth
                    </div>
                    
                </div>

                <div class="d-flex pt-4">
                    <div class="pe-5"><strong>{{ $user->profile->posts->count() }}</strong> posts</div>
                    {{-- <div class="pe-5"><strong>{{$user->profile->followers->count()}}</strong> followers</div>
                    <div class="pe-5"><strong>176</strong>{{$user->profile->following->count()}}</div> --}}
                </div>
                <div class="pt-3"><strong>{{ $user->profile->title }}</strong></div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>
        <div class="row pt-5">
            @foreach($user->profile->posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div id="carouselExample-{{$post->id}}" class="carousel carousel-fade">
                            <div class="carousel-indicators">
                                @foreach ($post->medias as $index => $media)
                                    <button type="button" data-bs-target="#carouselExample-{{$post->id}}" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach ($post->medias as $index => $media)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="mx-auto" style="max-width: 250px; object-fit: cover;">
                                            <img src="{{ asset('storage/posts/' . $media->path) }}" class="d-block w-100 rounded img-thumbnail" alt="Imagem">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $post->caption }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
