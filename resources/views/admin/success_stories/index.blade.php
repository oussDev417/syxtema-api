@extends('layout.master')
@section('title', 'Liste des Histoires de Succès')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des Histoires de Succès</h1>
        {{-- <div>{{ $success_stories }}</div> --}}
        <a href="{{ route('admin.success_stories.create') }}" class="btn btn-success mb-3">Ajouter une Histoire de Succès</a>
        <table id="successStoriesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($success_stories as $success_story)
                    <tr>
                        <td>{{ $success_story->id }}</td>
                        <td>{{ $success_story->title }}</td>
                        <td>{{ $success_story->slug }}</td>
                        <td>{{ $success_story->description }}</td>
                        <td>
                            @if ($success_story->image)
                                <img src="{{ asset('storage/' . $success_story->image->path) }}"
                                    alt="{{ $success_story->name }}" width="40" />
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.success_stories.edit', $success_story->id) }}"
                                class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.success_stories.destroy', $success_story->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette histoire de succès ?');">
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
            $('#successStoriesTable').DataTable();
        });
    </script>
@endsection
