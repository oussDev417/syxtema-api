@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Mes tentatives de quiz') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('N°') }}</th>
                                <th>{{ __('Cours') }}</th>
                                <th>{{ __('Quiz') }}</th>
                                <th>{{ __('Note du quiz') }}</th>
                                <th>{{ __('Ma note') }}</th>
                                <th>{{ __('Statut') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($quizAttempts as $index => $attempt)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $attempt->quiz->course?->title }}</td>
                                    <td>{{ $attempt->quiz->title }}</td>
                                   

                                    <td>{{ $attempt->quiz->total_mark }}</td>
                                    <td>{{ $attempt->user_grade }}</td>
                                    <td>
                                        @if($attempt->status == 'pass')
                                            <span class="badge bg-success">{{ __('Réussi') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Échoué') }}</span>
                                        @endif 
                                    </td>

                                    <td>
                                        {{ formatDate($attempt->created_at) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('student.quiz.result', ['id' => $attempt->quiz->id, 'result_id' => $attempt->id]) }}"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('Aucune donnée trouvée !') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $quizAttempts->links() }}
            </div>
        </div>
    </div>
@endsection
