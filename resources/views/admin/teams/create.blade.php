@extends('layout.master')
@section('title', 'Ajouter un membre')
@section('css')
<!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">
    <h1>Ajouter un membre</h1>
    <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control" id="profession" name="profession" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="facebook_url" class="form-label">Facebook</label>
                <input type="text" class="form-control" id="facebook_url" name="facebook_url" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="linkedin_url" class="form-label">Linkedin</label>
                <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                <div id="avatarPreview" class="mt-2"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection