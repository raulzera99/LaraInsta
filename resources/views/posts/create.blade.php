<x-app>
    <div class="offset-2">

        <x-card>
            <div class="card-header">
                <h1 class="card-title text-center"><i class="fa fa-solid fa-user-plus"></i>Create a Post</h1>
    
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
    
            <div class="card-body">
                <div class="container m-4">
    
                    <form 
                    action="{{route('posts.store')}}" 
                    enctype="multipart/form-data" 
                    method="post"
                    id="file-upload">
                    @csrf
                
                        <!-- Image Preview -->
                        <div id="image-preview">
    
                        </div>
                        
                        <div class="align-itens-center text-center mb-3">
                                        
                            <label for="images"   
                            class="btn btn-outline-success btn-lg upload-btn">
        
                                <i class="fa fa-upload fa-5x"
                                style="font-size: 30px">
                                
                                </i>
        
                            </label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="images" 
                                name="images[]" 
                                multiple 
                                style="display: none"
                            >
                            @error('images')
                            <p class="invalid-feedback text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        
                        <!-- Post Caption -->
                        <div class="form-group ">
                            <label for="caption" class="col-md-4 col-form-label">Caption</label>
        
                            <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" autocomplete="caption" autofocus>
        
                            @error('caption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
        
        
                        <!-- Add Button -->
                        <div class="row pt-4">
                            <button type="submit" class="btn btn-primary">Add New Post</button>
                        </div>
        
                    </form>
                </div>
            </div>
        </x-card>
    </div>

    @push('scripts')
        
        <script>
            function readURL(input) {
                if (input.files && input.files.length > 0) {
                    var previewContainer = document.getElementById('image-preview');
                    previewContainer.innerHTML = '';
    
                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
    
                        reader.onload = function(e) {
                            var image = document.createElement('img');
                            image.src = e.target.result;
                            image.classList.add('img-thumbnail', 'mr-2', 'mb-2');
                            image.style.width = '200px';
                            image.style.height = '200px';
                            previewContainer.appendChild(image);
                        }
    
                        reader.readAsDataURL(input.files[i]);
                    }
                    // Tornar as pré-visualizações arrastáveis e reordenáveis
                    var sortable = Sortable.create(previewContainer, {
                        animation: 150,
                        draggable: 'img'
                    });
                }
            }
    
            var imagesInput = document.getElementById('images');
            imagesInput.addEventListener('change', function() {
                readURL(this);
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    @endpush
</x-app>
