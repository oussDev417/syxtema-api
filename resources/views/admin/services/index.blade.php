@extends('layout.master')
@section('title', 'Liste des Services')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des Services</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-success mb-3">Ajouter un Service</a>
        <table id="servicesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Département</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->category->name }}</td>
                        <td>{{ $service->departement->name }}</td>
                        <td>
                            @if ($service->image)
                                <img src="{{ asset('storage/' . $service->image->path) }}" alt="{{ $service->name }}"
                                    width="50">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
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
            $('#servicesTable').DataTable();
        });
    </script>
@endsection
