@extends('layout.master')
@section('title', 'Liste des partenaires')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des partenaires</h1>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-success mb-3">Ajouter un partenaire</a>
        <table id="partnersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lien</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td>{{ $partner->id }}</td>
                        <td>{{ $partner->url }}</td>
                        <td><img src="{{ asset('storage/' . $partner->image) }}" alt="" style="height:3em;"></td>
                        <td>
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')"
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
            $('#partnersTable').DataTable();
        });
    </script>
@endsection
