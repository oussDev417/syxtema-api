@extends('admin.master_layout')
@section('title')
    <title>{{ __('Cours') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="">{{ __('Cours') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Tableau de bord') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Liste des cours') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    {{-- Filtre de recherche --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course.index') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Rechercher') }}">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="text" autocomplete="off" name="date" value="{{ request()->get('date') }}"
                                                class="form-control datepicker" placeholder="{{ __('Date') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="from-group">
                                                <select class="select2 form-group category" name="category">
                                                    <option value="">{{ __('Catégorie') }}</option>
                                                    @foreach ($categories as $category)
                                                        <optgroup label="{{ $category->translation?->name }}">
                                                            @foreach ($category->subCategories as $subCategory)
                                                                <option value="{{ $subCategory->id }}"
                                                                    {{ request()->get('category') == $subCategory->id ? 'selected' : '' }}>
                                                                    {{ $subCategory->translation?->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <select name="instructor" id="instructor" class="form-control select2">
                                                <option value="">{{ __('Formateur') }}</option>
                                                @foreach ($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}" {{ request()->get('instructor') == $instructor->id ? 'selected' : '' }}>
                                                        {{ $instructor->name }} ({{ $instructor->email }})</option>
                                                @endforeach                                                
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <select name="approve_status" id="" class="form-control">
                                                <option value="">{{ __('Statut d\'approbation') }}</option>
                                                <option
                                                    {{ request()->get('approve_status') == 'pending' ? 'selected' : '' }}
                                                    value="pending">{{ __('En attente') }}</option>
                                                <option
                                                    {{ request()->get('approve_status') == 'approved' ? 'selected' : '' }}
                                                    value="approved">{{ __('Approuvé') }}</option>
                                                <option
                                                    {{ request()->get('approve_status') == 'rejected' ? 'selected' : '' }}
                                                    value="rejected">{{ __('Rejeté') }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('Statut') }}</option>
                                                <option {{ request()->get('status') == 'active' ? 'selected' : '' }}
                                                    value="active">{{ __('Publié') }}</option>
                                                <option {{ request()->get('status') == 'inactive' ? 'selected' : '' }}
                                                    value="inactive">{{ __('Non publié') }}</option>
                                                <option {{ request()->get('status') == 'draft' ? 'selected' : '' }}
                                                    value="draft">{{ __('Brouillon') }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <select name="order_by" id="order_by" class="form-control">
                                                <option value="">{{ __('Trier par') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('Croissant') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('Décroissant') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="par_page" id="par-page" class="form-control">
                                                <option value="">{{ __('Par page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Liste des cours') }}</h4>
                                <div>
                                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary"> <i
                                            class="fa fa-plus"></i>{{ __('Ajouter nouveau') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive max-h-400">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('N°') }}</th>
                                                <th class="course-table-title">{{ __('Titre') }}</th>
                                                <th>{{ __('Formateur') }}</th>
                                                <th>{{ __('Prix') }}</th>
                                                <th>{{ __('Étudiants') }}</th>
                                                <th>{{ __('Date de création') }}</th>
                                                <th>{{ __('Date de mise à jour') }}</th>
                                                <th>{{ __('Statut') }}</th>
                                                <th class="course-table-approve">{{ __('Approuver') }}</th>
                                                <th class="text-center">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($courses as $course)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td class="course-table-title">
                                                        <span>{{ truncate($course->title) }}</span>
                                                        <br>
                                                        <small>{{ $course->category->translation->name ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $course->instructor->name ?? '' }}</td>
                                                    <td>
                                                        @if ($course->price == 0)
                                                            <span>{{ __('Gratuit') }}</span>
                                                        @elseif($course->discount > 0)
                                                            {{ currency($course->discount) }}
                                                        @else
                                                            {{ currency($course->price) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $course->enrollments_count }}</td>
                                                    <td><small>{{ formatDate($course->created_at) }}</small>
                                                        <br>
                                                        <small>{{ formatDate($course->created_at, 'H:i') }}</small>
                                                    </td>
                                                    <td><small>{{ formatDate($course->updated_at) }}</small>
                                                        <br>
                                                        <small>{{ formatDate($course->updated_at, 'H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        @if ($course->status == 'active')
                                                            <span class="badge badge-success">{{ __('Publié') }}</span>
                                                        @elseif ($course->status == 'inactive')
                                                            <span class="badge badge-danger">{{ __('Non publié') }}</span>
                                                        @else
                                                            <span class="badge badge-warning">{{ __('Brouillon') }}</span>
                                                        @endif
                                                    </td>

                                                    <td class="course-table-approve">
                                                        <select name="" class="form-control course-change-status"
                                                            data-id="{{ $course->id }}">
                                                            <option @selected($course->is_approved == 'pending') value="pending">
                                                                {{ __('En attente') }}</option>
                                                            <option @selected($course->is_approved == 'approved') value="approved">
                                                                {{ __('Approuvé') }}</option>
                                                            <option @selected($course->is_approved == 'rejected') value="rejected">
                                                                {{ __('Rejeté') }}</option>
                                                        </select>
                                                    </td>

                                                    <td class="text-center">
                                                        <div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle"
                                                                    type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                    <a href="{{ route('admin.courses.edit-view', $course->id) }}"
                                                                        class="dropdown-item"
                                                                        target="_blank">{{ __('Modifier') }}</a>

                                                                    <a href="{{ route('admin.courses.destroy', $course->id) }}"
                                                                        class="dropdown-item text-danger delete-item">{{ __('Supprimer') }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Filtre de cours')" route="admin.course-filter.create"
                                                    create="no" :message="__('Aucune donnée trouvée!')" colspan="11"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $courses->links() }}
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
    <script src="{{ asset('global/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/js/default/courses.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert.js') }}"></script>
@endpush
