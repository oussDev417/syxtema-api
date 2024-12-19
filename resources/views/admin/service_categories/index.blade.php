@extends('layout.master')
@section('title', 'Liste des Catégories de Services')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
<div class="container">
    <h1>Liste des Catégories de Services</h1>
    <a href="{{ route('admin.service_categories.create') }}" class="btn btn-success mb-3">Ajouter une Catégorie de Service</a>
    <table id="serviceCategoriesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceCategories as $serviceCategory)
                <tr>
                    <td>{{ $serviceCategory->id }}</td>
                    <td>{{ $serviceCategory->name }}</td>
                    <td>
                        <a href="{{ route('admin.service_categories.edit', $serviceCategory->id) }}" class="btn btn-light-success">
                            <i class="ti ti-edit"></i>
                        </a>
                        <form action="{{ route('admin.service_categories.destroy', $serviceCategory->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
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
        $('#serviceCategoriesTable').DataTable();
    });
</script>
@endsection 