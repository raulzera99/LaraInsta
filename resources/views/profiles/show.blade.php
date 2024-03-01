<x-app>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ 
                    $user->profile->profileImage ?
                    asset('storage/profile_images/' . $user->profile->profileImage->path) :
                    asset('storage/profile_images/no-logo.png') }}" 
                    class="rounded-circle" style="width: 150px; height: 150px;">
            </div>
            {{-- </div>{{ asset('storage/posts/' . $media->path) }} --}}
            <div class="col-md-8">
                <div class="justify-content-between align-items-baseline">
                    <div class="d-flex align-items-start pb-2 ">
                        <h3 class="font-weight-light me-3">{{ $user->username }}</h3>
                        {{-- <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button> --}}
                        @auth
                            @if(auth()->user()->id !== $user->id)
                                {{-- <button class="btn btn-primary ms-5 follow-button" data-profile-id="{{$user->profile->id}}">Follow</button> --}}
                                <button class="btn btn-primary ms-5 follow-button" 
                                data-profile-id="{{ $user->profile->id }}" 
                                data-is-following="{{ auth()->user()->profile->following->contains($user->id) ? 'true' : 'false' }}"
                                data-follow-url="{{ route('profiles.follow', [$user->id , $user->profile->id] ) }}">
                                    {{ auth()->user()->profile->following->contains($user->profile->id) ? 'Following' : 'Follow' }}
                                </button>
                            @else 
                                <a href="{{ route('profiles.edit', $user->profile->id) }}" class="btn btn-outline-secondary">Edit Profile</a>
                            @endif
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
            {{-- @foreach($user->profile->posts as $post)
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
            @endforeach --}}
            @foreach($user->profile->posts as $post)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="card-link  text-decoration-none">
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
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Capture o evento de clique no botão de seguir
                $('.follow-button').click(function() {
                    var profileId = $(this).data('profile-id');
                    var isFollowing = $(this).data('is-following');

                    if (isFollowing) {
                        // Se o usuário estiver seguindo, envie uma solicitação para deixar de seguir
                        unfollowProfile(profileId);
                    } else {
                        // Se o usuário não estiver seguindo, envie uma solicitação para seguir
                        followProfile(profileId);
                    }
                });

                function followProfile(profileId) {
                    // Envie uma solicitação AJAX para a rota de seguir
                    $.ajax({
                        url: "{{ route('profiles.follow', ['user' => $user->id, 'profile' => "+profileId+" ]) }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Atualize o estado do botão e exiba uma mensagem de sucesso (opcional)
                            $('.follow-button').text('Following').data('is-following', true);
                            alert('You are now following this profile.');
                        },
                        error: function() {
                            alert('An error occurred while trying to follow the profile.');
                        }
                    });
                }

                function unfollowProfile(profileId) {
                    // Envie uma solicitação AJAX para a rota de deixar de seguir
                    $.ajax({
                        url: "route('profiles.unfollow',{{$user->id}} ,profileId)",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Atualize o estado do botão e exiba uma mensagem de sucesso (opcional)
                            $('.follow-button').text('Follow').data('is-following', false);
                            alert('You have unfollowed this profile.');
                        },
                        error: function() {
                            alert('An error occurred while trying to unfollow the profile.');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app>
