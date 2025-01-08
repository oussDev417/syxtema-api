@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Historique des commandes') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>{{ __('N°') }}</th>
                                <th>{{ __('Facture') }}</th>
                                <th>{{ __('Payé') }}</th>
                                <th>{{ __('Moyen de paiement') }}</th>
                                <th>{{ __('Statut') }}</th>
                                <th>{{ __('Paiement') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($orders as $index => $order)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>#{{ $order->invoice_id }}</td>
                                    <td>{{ $order->paid_amount }} {{ $order->payable_currency }}</td>
                                    <td>
                                        {{ $order->payment_method }}
                                    </td>
                                    <td>
                                        @if ($order->status == 'completed')
                                            <div class="badge bg-success">{{ __('Terminé') }}</div>
                                        @elseif($order->status == 'processing')
                                            <div class="badge bg-warning">{{ __('En cours') }}</div>
                                        @elseif($order->status == 'declined')
                                            <div class="badge bg-danger">{{ __('Refusé') }}</div>
                                        @else
                                            <div class="badge bg-warning">{{ __('En attente') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <div class="badge bg-success">{{ __('Payé') }}</div>
                                        @elseif ($order->payment_status == 'cancelled')
                                            <div class="badge bg-danger">{{ __('Annulé') }}</div>
                                        @else
                                            <div class="badge bg-danger">{{ __('En attente') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('student.order.show', $order->id) }}" class=""><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('Aucune commande trouvée !') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
