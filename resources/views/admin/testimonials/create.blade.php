@extends('layout.master')
@section('title', 'Ajouter un Témoignage')
@section('css')
<!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">
    <h1>Ajouter un Témoignage</h1>
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
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
            <div class="col-md-12 mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message"></textarea>
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

@section('script')
    <script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>
    <script>
        $('#description').trumbowyg({
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