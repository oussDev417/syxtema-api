@extends('admin.master_layout')
@section('title')
    <title>{{ __('Créer un cours') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">{{ __('Cours') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Tableau de bord') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Cours') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="dashboard__content-wrap">
                    <div class="row">
                        <div class="col-12">
                            @include('course::course.navigation')

                            <div class="card">
                                <div class="card-body">
                                    <div class="instructor__profile-form-wrap mt-4">
                                        <form action="{{ route('admin.courses.store', ['id' => @$course?->id]) }}"
                                            class="instructor__profile-form course-form">
                                            @csrf
                                            <input type="hidden" name="step" value="1">
                                            <input type="hidden" name="next_step" value="2">
                                            <input type="hidden" name="edit_mode"
                                                value="{{ isset($editMode) && $editMode == true ? true : false }}">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="instructor">{{ __('Formateur') }} <code>*</code></label>
                                                        <select name="instructor" id="" class="form-control select2">
                                                            <option value="">{{ __('Sélectionner') }}</option>
                                                            @foreach ($instructors as $instructor)
                                                                <option value="{{ $instructor->id }}" @selected($instructor->id == @$course?->instructor_id)>{{ $instructor->name }} ({{ $instructor->email }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="title">{{ __('Titre') }} <code>*</code></label>
                                                        <input id="title" name="title" type="text" class="form-control"
                                                            value="{{ @$course?->title }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="slug">{{ __('Slug') }} <code>*</code></label>
                                                        <input id="slug" name="slug" type="text" class="form-control"
                                                            value="{{ @$course?->slug }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="seo_description">{{ __('Description SEO') }}
                                                            <code></code></label>
                                                        <input id="seo_description" name="seo_description" type="text"
                                                            value="{{ @$course?->seo_description }}" class="form-control"
                                                            placeholder="{{ __('150 - 160 caractères recommandés') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="from-group mb-3">
                                                        <label class="form-file-manager-label" for="">{{ __('Miniature') }}
                                                            <code>*</code></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon1">
                                                                <a data-input="thumbnail" data-preview="holder"
                                                                    class="file-manager-image">
                                                                    <i class="fa fa-picture-o"></i> {{ __('Choisir') }}
                                                                </a>
                                                            </span>
                                                            <input id="thumbnail" readonly class="form-control file-manager-input"
                                                                type="text" name="thumbnail" value="{{ @$course?->thumbnail }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="demo_video_storage">{{ __('Stockage vidéo démo') }}
                                                            <code>({{ __('optionnel') }})</code></label>
                                                        <select name="demo_video_storage" id="demo_video_storage" class="form-control">
                                                            <option @selected(@$course?->demo_video_storage == 'upload') value="upload">{{ __('Télécharger') }}
                                                            </option>
                                                            <option @selected(@$course?->demo_video_storage == 'youtube') value="youtube">
                                                                {{ __('YouTube') }}</option>
                                                            <option @selected(@$course?->demo_video_storage == 'vimeo') value="vimeo">{{ __('Vimeo') }}
                                                            </option>
                                                            <option @selected(@$course?->demo_video_storage == 'external_link') value="external_link">
                                                                {{ __('Lien externe') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 upload {{ @$course?->demo_video_storage == 'upload' ? '' : 'd-none' }}">
                                                    <div class="from-group mb-3">
                                                        <label class="form-file-manager-label" for="">{{ __('Chemin') }}
                                                            <code></code></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon1">
                                                                <a data-input="path" data-preview="holder" class="file-manager">
                                                                    <i class="fa fa-picture-o"></i> {{ __('Choisir') }}
                                                                </a>
                                                            </span>
                                                            <input id="path" readonly class="form-control file-manager-input"
                                                                type="text" name="upload_path" value="{{ @$course?->demo_video_source }}">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 external_link {{ @$course?->demo_video_storage != 'upload' ? '' : 'd-none' }}">
                                                    <div class="form-grp">
                                                        <label for="meta_description">{{ __('Chemin') }} <code></code></label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i
                                                                    class="fas fa-link"></i></span>
                                                            <input type="text" class="form-control" name="external_path"
                                                                placeholder="{{ __('Collez votre lien externe') }}" value="{{ @$course?->demo_video_source }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">{{ __('Prix') }} <code>*</code></label>
                                                        <input id="price" name="price" type="text" class="form-control"
                                                            value="{{ @$course?->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="discount_price">{{ __('Prix réduit') }}
                                                            <code></code></label>
                                                        <input id="discount_price" name="discount_price" type="text" class="form-control"
                                                            value="{{ @$course?->discount}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">{{ __('Description') }} <code></code></label>
                                                        <textarea name="description" class="text-editor form-control summernote">{!! clean(@$course?->description) !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">{{ __('Enregistrer') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/default/courses.js') }}"></script>

    <script>
        $(document).ready(function() {
            const $name = $("#title"),
                $slug = $("#slug");

            $name.on("keyup", function(e) {
                $slug.val(convertToSlug($name.val()));
            });

            function convertToSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^a-z\s-]/g, "") // Supprime tous les caractères non-mot (sauf -)
                    .replace(/\s+/g, "-") // Remplace les espaces par -
                    .replace(/-+/g, "-"); // Remplace plusieurs - par un seul -
            }
        })
    </script>

@endpush

@push('css')
    <style>
        .dd-custom-css {
            position: absolute;
            will-change: transform;
            top: 0px;
            left: 0px;
            transform: translate3d(0px, -131px, 0px);
        }

        .max-h-400 {
            min-height: 400px;
        }
    </style>
@endpush
