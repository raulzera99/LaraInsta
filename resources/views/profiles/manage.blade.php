<x-app>
    <x-card>
        <div class="card-header">
            <h1 class="card-title text-center"><i class="fa fa-solid fa-user-plus"></i> Profiles list manager</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Profiles list manager</li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
        
                {{-- <div class="container">
                    <x-alert  type="success"/>
                </div> --}}
        
            <div class="container">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-striped table-bordered table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; text-align: center;">id</th>
                                    <th style="font-weight: bold; text-align: center;">Title</th>
                                    <th style="font-weight: bold; text-align: center;">Description</th>
                                    <th style="font-weight: bold; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profiles as $profile)
                                    <tr style="text-align: center;">
                                        
                                        <td >{{$profile->id}}</td>
                                        <td>{{$profile->title}}</td>
                                        <td>{{$profile->description}}</td>
                                        <td>
                                            <div class="btn btn-info btn-sm">
                                                <a href="{{route('users.edit', $profile->id)}}">
                                                    <i class="fa fa-pencil" style="color: white"></i>
                                                </a>
                                            </div>
                                            <div class="btn btn-danger btn-sm mx-2">
                                                <a href="{{route('users.delete', $profile->id)}}">
                                                    <i class="fa fa-trash" style="color: white"></i>
                                                </a>
                                            </div>
                                            <div class="btn btn-secondary btn-sm ">
                                                <a href="{{route('users.show', $profile->id)}}">
                                                    <i class="fa fa-eye" style="color: white"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
        
                        {{-- <a href="{{route('users.manually', $user->id)}}" class="btn btn-success btn-lg">
                            <i class="fa fa-plus-circle"></i>
                            Incluir novos usuários
                        </a>
        
                        <a href="{{route('users.exportPDF')}}" target="_blank" class="btn btn-success btn-lg">
                            <i class="fa fa-regular fa-file-pdf"></i>
                            Export PDF
                        </a>
                        <a href="{{route('users.exportExcel', ['extensao' => 'xlsx'])}}" class="btn btn-success btn-lg">
                            Export EXCEL
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </x-card>


    @section('scripts')
        <link rel="stylesheet" type="text/css" href="{{asset('lib/css/jquery.dataTables.min.css')}}">
        <script type="text/javascript" src="{{asset('lib/js/jquery.dataTables.min.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable({
                        
                    processing: true,
                    serverSide: false,
                    searching: true,
                    ordering: true,
                    paging: true,
                    pageLength: 25,
                    lengthMenu: [10, 25, 50, 75, 100],
                    // ajax: '{{ route('users.index') }}',
                    // columns: [
                    //     { data: 'name' },
                    //     { data: 'email' }
                    // ]
                });
            } );
        </script>
    @endsection
</x-app>