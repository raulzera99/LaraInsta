<x-app>
    <div class="offset-2">
        <div class="container mt-5">
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
            </div>

            <div class="row">

                <div class="mt-3 col-11">
                    <a class="text-decoration-none" href="{{route('profiles.show',$post->profile->user->id )}}">
                        <span class="fw-bold">{{ $post->profile->user->username}}</span>
                    </a>
                    {{ $post->caption }}
                </div>
                
                <div class="mt-3 col-1">
                    <button class="btn btn-danger rounded-5" id="likeButton" data-post-id="{{ $post->id }}">
                        <i class="fa fa-heart " aria-hidden="true"></i>
                    </button>
                    <span id="likeCount">{{ $post->likes->count() }}</span> Likes
                </div>
            </div>

            <div class="input-group mt-3">
                <input type="text" class="form-control rounded-pill comment-input" placeholder="Add comment's">
                <button class="btn btn-primary rounded-pill ms-3 post-comment">Send</button>
            </div>

            <div class="mt-5">
                <h4 class="text-center">Comments</h4>
                <div class="comments-list">
                    @foreach ($post->comments as $comment)
                        <div class="comment d-flex align-items-center mb-3">
                            <img 
                            src="{{ $comment->profile->profileImage ? 
                            asset('storage/profile_images/' . $comment->profile->profileImage->path) 
                            : 
                            asset('storage/profile_images/no-logo.png') }}" 

                            alt="Profile Picture" 
                            class="rounded-circle me-3" 
                            style="width: 40px; height: 40px;"
                            >
                            <div>
                                <a class="text-decoration-none" href="{{route('profiles.show', $comment->profile->user->id)}}">
                                    <p class="mb-0 fw-bold">{{ $comment->profile->user->username }}</p>
                                </a>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
                
        </div>
    </div>
    @push('scripts')
        <script>
            const likeButton = document.getElementById('likeButton');
            const likeCount = document.getElementById('likeCount');
            const postId = likeButton.dataset.postId;

            likeButton.addEventListener('click', () => {
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        likeCount.textContent = data.likesCount;
                    }
                })
                .catch(error => console.log(error));
            });

            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.post-comment').click(function() {
                    var commentInput = $(this).prev('.comment-input');
                    var comment = commentInput.val().trim();
                    if (comment !== '') {
                        var postId = {{ $post->id }};
                        $.ajax({
                            url: "{{ route('comments.store') }}",
                            method: 'POST',
                            data: {
                                post_id: postId,
                                content: comment
                            },
                            success: function(response) {
                                // Lógica para manipular a resposta do servidor após adicionar o comentário
                                // Por exemplo, atualizar a lista de comentários na página
                                console.log('Comentário adicionado com sucesso!');
                            },
                            error: function(xhr, status, error) {
                                // Lógica para lidar com erros de requisição
                                console.error('Erro ao adicionar comentário:', error);
                            }
                        });
                    }
                    commentInput.val(''); // Limpa o campo de entrada do comentário
                });
            });
        </script>
    @endpush
</x-app>
