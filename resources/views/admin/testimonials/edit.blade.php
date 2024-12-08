@extends('layout.master')
@section('title', 'Modifier un Témoignage')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection
@section('main-content')
<div class="container">
    <h1>Modifier un Témoignage</h1>
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $testimonial->nom }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="profession" class="form-label">Profession</label>
            <input type="text" class="form-control" id="profession" name="profession" value="{{ $testimonial->profession }}" required>
        </div>
        <div class="col-md-12 mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message">{{ $testimonial->message }}</textarea>
        </div>
        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à Jour le Témoignage</button>
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