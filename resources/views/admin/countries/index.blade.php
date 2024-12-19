@extends('layout.master')
@section('title', 'Liste des Pays')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
<div class="container">
    <h1>Liste des Pays</h1>
    <a href="{{ route('admin.countries.create') }}" class="btn btn-success mb-3">Ajouter un Pays</a>
    <table id="countriesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Court</th>
                <th>Nom du Pays</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->short_name }}</td>
                    <td>{{ $country->country_name }}</td>
                    <td>{{ $country->status }}</td>
                    <td>
                        <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-light-success">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce pays ?');">
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
        $('#countriesTable').DataTable();
    });
</script>
@endsection 