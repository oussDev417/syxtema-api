@extends('layout.master')
@section('title', 'Actualités')
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">
    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Actualités</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-success mb-3">Ajouter une actualité</a>
        <table id="newsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Slug</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $new)
                    <tr>
                        <td>{{ $new->id }}</td>
                        <td>{{ $new->title }}</td>
                        <td>{{ $new->slug }}</td>
                        <td>{{ $new->status == 1 ? 'Actif' : 'Inactif' }}</td>
                        <td>
                            <button type="button" class="btn btn-light-success icon-btn b-r-4"
                                onclick="window.location.href='{{ route('admin.news.edit', $new->id) }}'">
                                <i class="ti ti-edit text-success"></i>
                            </button>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                onclick="new.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) { document.getElementById('delete-form-{{ $new->id }}').submit(); }">
                                <i class="ti ti-trash"></i>
                            </button>
                            <form id="delete-form-{{ $new->id }}"
                                action="{{ route('admin.news.destroy', $new->id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
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
            $('#newsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
@endsection

@section('script')
<!--customizer-->
<div id="customizer"></div>

<!-- Trumbowyg js -->
<script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

<!-- filepond -->
<script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

<!-- add blog js  -->
<script src="{{ asset('assets/js/add_blog.js') }}"></script>
@endsection
