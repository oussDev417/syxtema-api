@extends('layout.master')
@section('title', 'Modifier un partenaire')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection
@section('main-content')
    <div class="container">
        <h1>Modifier un Partenaire</h1>
        <!-- <div>{{ $errors }}</div> -->
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="url" class="form-label">Lien</label>
                    <input type="url" class="form-control" id="url" name="url" value="{{ $partner->url }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à Jour le Partenaire</button>
        </form>
    </div>
@endsection
