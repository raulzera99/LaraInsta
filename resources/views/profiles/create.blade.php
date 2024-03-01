<x-app>

    <div>
        <h1>Novo Perfil</h1>

        <form action="{{ route('profiles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name-input">Nome:</label>
                <input id="name-input" type="text" name="name" class="form-control" placeholder="Digite o nome do perfil">
            </div>
            <div class="form-group">
                <label for="description-input">Descrição:</label>
                <textarea id="description-input" name="description" class="form-control" placeholder="Digite a descrição do perfil"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

    </div>
</x-app>