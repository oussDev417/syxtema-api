@extends('layout.master')
@section('title', 'Liste des Startups')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des Startups</h1>
        {{-- <div>{{ $startups }}</div> --}}
        <a href="{{ route('admin.startups.create') }}" class="btn btn-success mb-3">Ajouter une Startup</a>
        <table id="startupsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($startups as $startup)
                    <tr>
                        <td>{{ $startup->id }}</td>
                        <td>{{ $startup->name }}</td>
                        <td>{{ $startup->slug }}</td>
                        <td>{{ $startup->description }}</td>
                        <td>
                            @if ($startup->image)
                                <img src="{{ asset('storage/' . $startup->image->path) }}" alt="{{ $startup->name }}"
                                    width="40" />
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.startups.edit', $startup->id) }}" class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.startups.destroy', $startup->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette Startup ?');">
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
            $('#startupsTable').DataTable();
        });
    </script>
@endsection
