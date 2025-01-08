@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">

        <div class="dashboard__content-title d-flex justify-content-between">
            <h4 class="title">{{ __('Créer un cours') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
              @include('frontend.instructor-dashboard.course.navigation')
                <div class="instructor__profile-form-wrap">
                    <form action="{{ route('instructor.courses.store', ['id' => @$course?->id]) }}"
                        class="instructor__profile-form course-form">
                        @csrf
                        <input type="hidden" name="step" value="1">
                        <input type="hidden" name="next_step" value="2">
                        <input type="hidden" name="edit_mode" value="{{ isset($editMode) && $editMode == true ? true : false }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="title">{{ __('Titre') }} <code>*</code></label>
                                    <input id="title" name="title" type="text" value="{{ @$course?->title }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="slug">{{ __('Slug') }} <code>*</code></label>
                                    <input id="slug" name="slug" type="text" value="{{ @$course?->slug }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="seo_description">{{ __('Description SEO') }} <code></code></label>
                                    <input id="seo_description" name="seo_description" type="text" value="{{ @$course?->seo_description }}"
                                        placeholder="{{ __('150 - 160 caractères recommandés') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="from-group mb-3">
                                    <label class="form-file-manager-label" for="">{{ __('Miniature') }}
                                        <code>*</code></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <a data-input="thumbnail" data-preview="holder" class="file-manager-image">
                                                <i class="fa fa-picture-o"></i> {{ __('Choisir') }}
                                            </a>
                                        </span>
                                        <input id="thumbnail" readonly class="form-control file-manager-input"
                                            type="text" name="thumbnail" value="{{ @$course?->thumbnail }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label for="demo_video_storage">{{ __('Stockage vidéo de démonstration') }}
                                        <code>({{ __('optionnel') }})</code></label>
                                    <select name="demo_video_storage" id="demo_video_storage" class="form-select">
                                        <option @selected(@$course?->demo_video_storage == 'upload') value="upload">{{ __('Télécharger') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'youtube') value="youtube">{{ __('Youtube') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'vimeo') value="vimeo">{{ __('Vimeo') }}</option>
                                        <option @selected(@$course?->demo_video_storage == 'external_link') value="external_link">{{ __('Lien externe') }}</option>
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
                                <div class="form-grp">
                                    <label for="price">{{ __('Prix') }} <code>*</code></label>
                                    <input id="price" name="price" type="text" value="{{ @$course?->price }}">
                                    <code>{{ __('Mettre 0 pour gratuit') }}</code>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label for="discount_price">{{ __('Prix réduit') }} <code></code></label>
                                    <input id="discount_price" name="discount_price" type="text" value="{{ @$course?->discount_price }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <label for="description">{{ __('Description') }} <code></code></label>
                                    <textarea name="description" class="text-editor">{!! clean(@$course?->description) !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{ __('Enregistrer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/default/courses.js') }}"></script>

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
