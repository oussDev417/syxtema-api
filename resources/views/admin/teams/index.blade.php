@extends('layout.master')
@section('title', 'Événements')
@section('css')

<!-- filepond css -->
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">
<!-- editor css -->
<link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container">
    <h1>Equipe</h1>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-success mb-3">Ajouter un membre</a>
    <table id="teamsTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Profession</th>
                <th>Avatar</th>
                <th>Facebook</th>
                <th>Linkedin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->nom }}</td>
                <td>{{ $team->profession }}</td>
                <td>{{ $team->avatar }}</td>
                <td>{{ $team->facebook_url }}</td>
                <td>{{ $team->linkedin_url }}</td>
                <td>
                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-light-success icon-btn b-r-4">
                            <i class="ti ti-edit text-success"></i>
                        </a>
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')" class="btn btn-light-danger icon-btn b-r-4">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#teamsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection
@endsection

@section('script')
<!--customizer-->
<div id="customizer"></div>

<!-- Trumbowyg js -->
<script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>

<!-- filepond -->
<script src="{{asset('assets/vendor/filepond/file-encode.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/validate-size.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/validate-type.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/exif-orientation.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/image-preview.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/filepond.min.js')}}"></script>

<!-- add blog js  -->
<script src="{{asset('assets/js/add_blog.js')}}"></script>
@endsection