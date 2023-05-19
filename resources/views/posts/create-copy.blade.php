<x-app>
    <div class="container-fluid d-flex justify-content-center " 
    >
        <form 
        action="{{route('posts.store')}}" 
        enctype="multipart/form-data" 
        method="post"
        id="file-upload">
        @csrf
    
            <div class="row">
                <div class="container offset-3">
                    <!-- Title -->
                    <div class="row text-center mt-5">
                        <h1>Add New Post</h1>
                    </div>
                    <!-- Image Preview -->
                    <div class="card my-4">
                        <div class="card-body">
                            <div class="mt-3">
                                {{-- <ul id="image-carousel" class="carousel">
                                     {{-- Carousel items go here
                                </ul> --}}
        
                                <div id="image-preview-carousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <!-- Aqui serão exibidas as imagens selecionadas -->
                                    </div>

                                    <div class="my-4">

                                        <button class="carousel-control-prev" type="button" data-bs-target="#image-preview-carousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#image-preview-carousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
        
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="align-itens-center text-center">
                                    
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
                    <div class="form-group row">
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
                </div>
            </div>
    
        </form>
    </div>

    
    @push('scripts')
    <!-- Adicione o seguinte código JS personalizado -->
    <script>
        // $(function() {
            // // Quando uma imagem é selecionada, mostre a visualização da imagem e um botão para excluir
            // $('#images').on("change", function() {
            //     // Limpa o carrossel
            //     $(".carousel-inner").empty();
            //     $(".carousel-indicators").empty();

            //     var input = $(this);
            //     var files = input.get(0).files;

            //     if (files.length > 0) {
            //         // Limpe a lista de imagens selecionadas
            //         $('#selected-images').empty();

            //         // Adicione cada imagem selecionada à lista
            //         $.each(files, function(index, file) {
            //             var reader = new FileReader();

            //             reader.onload = function() {
            //                 var img = $('<img>').addClass('rounded img-thumbnail mx-auto avatar d-block w-100').attr('src', reader.result);
            //                 var btn = $('<button>').addClass('btn btn-danger btn-sm').attr('type', 'button').html('Excluir').click(function() {
            //                     img.remove();
            //                     btn.remove();
            //                     input.val('');
            //                 });
            //                 $('<div>').addClass('d-inline-block').append(img).append(btn).appendTo('#selected-images');
            //             };

            //             reader.readAsDataURL(file);
            //         });
            //     }
            // });
    //         $('#images').change(function() {
    //             var images = $('#images')[0].files;
    //             for (var i = 0; i < images.length; i++) {
    //                 var reader = new FileReader();
    //                 reader.onload = function(e) {
                        
    //                 }
    //                 reader.readAsDataURL(images[i]);
    //             }
    // });
        $(document).ready(function() {

            $("#images").on("change", function() {
                // Limpa o carrossel
                var carouselInner = $('#image-preview-carousel .carousel-inner');
                carouselInner.empty();
                $(".carousel-indicators").empty();
                
                // Para cada imagem selecionada, adiciona um item ao carrossel
                for (var i = 0; i < this.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var itemClass = (i === 0) ? 'carousel-item active' : 'carousel-item';
                        // var image = $('<img>').addClass('rounded img-thumbnail mx-auto avatar d-block w-100').attr('src', e.target.result);
                        // $('#image-carousel').append($('<li class="carousel-item"><img src="' + e.target.result + '"></li>'));
                        // $('#image-carousel').append($('<li class="carousel-item"><img src="' + e.target.result + '"></li>'));

                        var image = '<img src="' + e.target.result + '" class="d-block w-100 rounded img-thumbnail mx-auto avatar" alt="Image Preview">';
                        

                        // var btn = $('<button>').addClass('btn btn-danger btn-sm').attr('type', 'button').html('Excluir').click(function() {
                        //     image.remove();
                        //     btn.remove();
                        // });

                        var item = '<div class="' + itemClass + '">' + image + '</div>'  ;
                        carouselInner.append(item);

                        var indicator = $("<li>").attr("data-bs-target", "#image-preview-carousel").attr("data-bs-slide-to", i).addClass(i === 0 ? "active" : "");
                        $(".carousel-indicators").append(indicator);
                    };
                    reader.readAsDataURL(this.files[i]);
                }
            });
        });
    </script>
</x-app>