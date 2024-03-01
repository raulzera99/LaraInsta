<x-app>
    <div name="content">
        <h1>Pesquisa de Usuários</h1>

        <form id="search-form" action="{{ route('profiles.search') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="search-input">Digite o nome do usuário:</label>
                <input id="search-input" type="text" name="searchTerm" class="form-control" placeholder="Digite o nome do usuário">
            </div>
            {{-- <button type="submit" class="btn btn-primary">Pesquisar</button> --}}
        </form>

        <div id="search-results" style="display: none;">
            <h2>Resultados da pesquisa:</h2>
            <ul id="user-list" class="text-decoration-none"></ul>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });

                // Atualizar a lista de usuários a cada digitação
                $("#search-input").on("input", function() {
                    var searchTerm = $(this).val();
                    searchUsers(searchTerm);
                });

                // Ao enviar o formulário, realizar a pesquisa
                $("#search-form").submit(function(event) {
                    event.preventDefault();
                    var searchTerm = $("#search-input").val();
                    searchUsers(searchTerm);
                });

                function searchUsers(searchTerm) {
                    $.ajax({
                        url: "{{ route('profiles.search') }}",
                        method: "POST",
                        data: { searchTerm: searchTerm },
                        success: function(response) {
                            displayProfiles(response.profiles);
                        },
                        error: function() {
                            alert("Ocorreu um erro ao buscar os perfis.");
                        }
                    });
                }

                function displayProfiles(profiles) {
                    var userList = $("#user-list");
                    userList.empty();

                    if (profiles.length === 0) {
                        userList.append("<li>Nenhum perfil encontrado.</li>");
                    } else {
                        profiles.forEach(function(profile) {
                        var listItem = $("<li>");

                        // var path = "{{ asset('storage/profile_images/') }}/" + profile.profileImage.path;

                        // var profileImage = $("<img>")
                        //     .attr(
                        //     "src",
                        //     profile.profileImage
                        //         ? path
                        //         : "{{ asset('storage/profile_images/no-logo.png') }}"
                        //     )
                        //     .attr("alt", "Profile Picture")
                        //     .addClass("rounded-circle me-3")
                        //     .css({ width: "40px", height: "40px" });

                        var usernameLink = $("<a>")
                        .attr("href", profile.url)
                        .addClass("text-decoration-none");

                        var username = $("<p>")
                            .addClass("mb-0 fw-bold")
                            .text(profile.title);

                        usernameLink.append(username);
                        listItem.append( usernameLink);
                        userList.append(listItem);
                        });
                    }

                    $("#search-results").show();
                }
            });
        </script>
    @endpush
</x-app>
