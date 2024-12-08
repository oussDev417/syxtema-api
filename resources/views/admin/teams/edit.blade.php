@extends('layout.master')
@section('title', 'Modifier un membre')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection
@section('main-content')
<div class="container">
    <h1>Modifier un Membre</h1>
    <!-- <div>{{ $errors }}</div> -->
    <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ $team->nom }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control" id="profession" name="profession" value="{{ $team->profession }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="facebook_url" class="form-label">Facebook</label>
                <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{ $team->facebook_url }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="linkedin_url" class="form-label">Linkedin</label>
                <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ $team->linkedin_url }}" required>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à Jour le Membre</button>
    </form>
</div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>
    <script>
        $('#message').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
        });
    </script>
@endsection 