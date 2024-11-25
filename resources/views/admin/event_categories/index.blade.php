@extends('layout.master')
@section('title', 'Catégories d\'Événements')
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container">
    <h1>Catégories d'Événements</h1>
    <a href="{{ route('admin.event_categories.create') }}" class="btn btn-success mb-3">Ajouter une Catégorie</a>
    <table id="eventCategoriesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->status }}</td>
                    <td>
                        <form action="{{ route('admin.event_categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.event_categories.edit', $category->id) }}" class="btn btn-light-success icon-btn b-r-4">
                                <i class="ti ti-edit text-success"></i>
                            </a>
                            <button type="submit" class="btn btn-light-danger icon-btn b-r-4">
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
        $('#eventCategoriesTable').DataTable();
    });
</script>
@endsection
@endsection 