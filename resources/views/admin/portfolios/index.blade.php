@extends('layout.master')
@section('title', 'Liste des Réalisations')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des Réalisations</h1>
        {{-- <div>{{ $portfolios }}</div> --}}
        <a href="{{ route('admin.portfolios.create') }}" class="btn btn-success mb-3">Ajouter une Réalisation</a>
        <table id="portfoliosTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Département</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($portfolios as $portfolio)
                    <tr>
                        <td>{{ $portfolio->id }}</td>
                        <td>{{ $portfolio->name }}</td>
                        <td>{{ $portfolio->slug }}</td>
                        <td>{{ $portfolio->departement->name }}</td>
                        <td>{{ $portfolio->description }}</td>
                        <td>
                            @if ($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image->path) }}" alt="{{ $portfolio->name }}"
                                    width="40" />
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}" class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réalisation ?');">
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
            $('#portfoliosTable').DataTable();
        });
    </script>
@endsection
