@extends('layout.master')
@section('title', 'Liste des Départements')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
<div class="container">
    <h1>Liste des Départements</h1>
    <a href="{{ route('admin.departements.create') }}" class="btn btn-success mb-3">Ajouter un Département</a>
    <table id="departementsTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departements as $departement)
                <tr>
                    <td>{{ $departement->id }}</td>
                    <td>{{ $departement->name }}</td>
                    <td>{{ $departement->description }}</td>
                    <td>
                        <a href="{{ route('admin.departements.edit', $departement->id) }}" class="btn btn-light-success">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.departements.destroy', $departement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">
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
        $('#departementsTable').DataTable();
    });
</script>
@endsection 