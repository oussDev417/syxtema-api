@extends('admin.master_layout')
@section('title')
    <title>{{ __('Liste des catégories') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-primary">{{ __('Cours') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Tableau de bord') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Liste des sous-catégories') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            @include('course::course.navigation')
                            <div class="instructor__profile-form-wrap mt-4">
                                <form action="{{ route('admin.courses.update') }}" class="instructor__profile-form course-form">
                                    @csrf
                                    <input type="hidden" name="course_id" id="" value="{{ $course->id }}">
                                    <input type="hidden" name="step" id="" value="4">
                                    <input type="hidden" name="next_step" value="4">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Message pour le réviseur') }} <code></code></label>
                                                <textarea name="message_for_reviewer" class="form-control">{{ $course->message_for_reviewer }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="">{{ __('Statut') }} <code>*</code></label>
                                              <select name="status" id="" class="form-control">
                                                <option value="">{{ __('Sélectionner') }}</option>
                                                <option @selected($course->status == 'active') value="active">{{ __('Publier') }}</option>
                                                <option @selected($course->status == 'inactive') value="inactive">{{ __('En attente') }}</option>
                                                <option @selected($course->status == 'is_draft') value="is_draft">{{ __('Brouillon') }}</option>
                                              </select>
                                          </div>
                                      </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">{{ __('Enregistrer') }}</button>
                                        </div>
                                    </div>
                                </form>
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
@endpush
