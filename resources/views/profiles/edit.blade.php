<x-app>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <x-card>
                    <div class="card-header">
                        <h1 class="card-title text-center">
                            <i class="fa fa-solid fa-user-plus"></i>
                            Edit Profile
                        </h1>
    
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
    
                    <div class="card-body">
                        <form method="POST" 
                        action="{{route('profiles.update', $user->id)}}" enctype="multipart/form-data" id="file-update">
                            @csrf
                            @method('POST')
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card my-4">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img 
                                                    id="image"
                                                    src="{{
                                                        $user->profile->profileImage
                                                        ? asset('storage/profile_images/'. $user->profile->profileImage->path)
                                                        : asset('storage/profile_images/no-logo.png')
                                                    }}" 
                                                    class="rounded img-thumbnail mx-auto avatar"
                                                    style="max-height: 200px; width: 200px"
                                                />
                                                <div class="mt-3">
                                                    <button
                                                        type="button"
                                                        title="Upload Image" 
                                                        class="btn btn-success btn-lg upload" 
                                                        id="upload"
                                                    >
                                                        <i class="fa fa-upload fa-5x" style="font-size: 30px"></i>
                                                    </button>
                                                    <input 
                                                        type="file" 
                                                        class="form-control" 
                                                        id="input_image" 
                                                        name="profile_image" 
                                                        style="display: none"
                                                    >
                                                    @error('profileImage')
                                                        <p class="invalid-feedback text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                                <div class="mt-4">
                                                    <button 
                                                        type="button" 
                                                        id="deleteLogoBtn" 
                                                        data-profileImage-id="{{ optional($user->profile->profileImage)->id }}}"
                                                        class="btn btn-danger"
                                                    >
                                                        <i class="fa fa-trash justify-content-center" style="color: white"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-left pt-4">
                                            <div class="form-group">
                                                <label for="title" class="control-label">Title</label>
                                                <input 
                                                    id="title" 
                                                    name="title" 
                                                    type="text" 
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    value="{{isset($user->profile->title) ? $user->profile->title:''}}"
                                                >
                                                @error('title')
                                                    <p class="invalid-feedback text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-left py-2">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <input 
                                                    id="description" 
                                                    name="description" 
                                                    type="text" 
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    value="{{isset($user->profile->description) ? $user->profile->description:''}}"
                                                >
                                                @error('description')
                                                    <p class="invalid-feedback text-danger">{{$error}}</p>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-left py-2">
                                            <div class="form-group">
                                                <label for="url">URL</label>
                                                <input 
                                                    id="url" 
                                                    name="url" 
                                                    type="text" 
                                                    class="form-control @error('url') is-invalid @enderror"
                                                    value="{{isset($user->profile->url) ? $user->profile->url:''}}"
                                                >
                                                @error('url')
                                                    <p class="invalid-feedback text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5 justify-content-center">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary btn-lg rounded py-2 px-4 m-3">
                                        <i class="fa fa-plus-circle"></i>   
                                        Editar
                                    </button>

                                    <a href="{{route('profiles.show', auth()->user())}}" class="btn btn-secondary btn-lg">
                                        <i class="fa fa-times-circle"></i>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </x-card>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(e) {
                
                
                
                var inputImage = document.getElementById('input_image');

                $('#upload').click(function(e){
                    $('#input_image').click();
                });

                $('#input_image').change(function(e){
                    let reader = new FileReader();
                    
                    reader.onload = (e) => { 
                        var image = document.getElementById('image');
                        image.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]); 
                });


                $('#file-update').submit( function(event) {
                    event.preventDefault();
                    let formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('profiles.update', $user->id) }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            if (response) {
                                this.reset();
                                console.log('Logotipo atualizado com sucesso.');
                                // atualiza a imagem do logotipo na página
                                $('#image').attr('src', response.profile_image);
                                window.location.href = "{{route('profiles.show', $user->id)}}";
                            } 
                        },
                        error: (response) => {
                            console.log('Erro ao atualizar logotipo.');
                        }
                    });
                });

                // deleta a imagem do perfil
                $('#deleteLogoBtn').click(function(e) {
                    e.preventDefault();
                    var id = $(this).data('profileImage-id');
                    $.ajax({
                        url: "{{ route('profiles.deleteProfileImage', ['user' => $user->id]) }}",
                        type: 'POST',
                        data: {
                            profileImage_id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response.success);
                                // atualiza a imagem do logotipo na página
                                $('#image').attr('src', '{{ asset('storage/profile_images/no-logo.png') }}');
                            } else if(response.error) {
                                console.log(response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    })
                });
            });
        </script>
    @endpush
</x-app>
