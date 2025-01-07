@extends('layout.master')
@section('title', 'Liste des membres')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Equipe</h1>
        {{-- <div>{{ $teams }}</div> --}}
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
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        <td>{{ $team->nom }}</td>
                        <td>{{ $team->profession }}</td>
                        <td>
                            @if ($team->avatar)
                                <img src="{{ asset('storage/' . $team->avatar->path) }}" alt="" width="35">
                            @endif
                        </td>
                        <td>{{ $team->facebook_url }}</td>
                        <td>{{ $team->linkedin_url }}</td>
                        <td>
                            <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre de l\'équipe ?')"
                                    class="btn btn-light-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#teamsTable').DataTable();
        });
    </script>
@endsection
