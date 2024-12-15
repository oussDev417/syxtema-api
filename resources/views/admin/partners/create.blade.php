@extends('layout.master')
@section('title', 'Ajouter un partenaire')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <h1>Ajouter un partenaire</h1>
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="url" class="form-label">Lien</label>
                    <input type="url" class="form-control" id="url" name="url" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
