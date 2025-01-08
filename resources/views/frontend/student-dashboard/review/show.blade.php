@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
<a href="{{ route('student.reviews.index') }}" class="btn mb-3">{{ __('Mes avis') }}</a>
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Détails de l\'avis') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ __('Cours') }}</td>
                                <td>{{ $review->course->title }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Note') }}</td>
                                <td>
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Avis') }}</td>
                                <td>{{ $review->review }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Date') }}</td>
                                <td>{{ formatDate($review->created_at) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Statut') }}</td>
                                <td>
                                    @if ($review->status == 1)
                                        <div class="badge bg-success">{{ __('Approuvé') }}</div>
                                    @else
                                        <div class="badge bg-warning">{{ __('En attente') }}</div>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
