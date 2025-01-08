@extends('frontend.student-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Historique des commandes') }}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard__review-table">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12 info-wrapper">
                                    <div class="row w-100">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="invoice-title">
                                                <h2>{{ __('Facture') }}</h2>
                                                <div class="invoice-number">{{ __('Commande ') }} #{{ $order->invoice_id }}
                                                </div>
                                                <address>
                                                    <strong>{{ __('Date de commande') }}:</strong><br>
                                                    {{ formatDate($order->created_at) }}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Facturé à') }}:</strong><br>
                                                {{ $order->user->first_name }} {{ $order->user->last_name }}<br>
                                                {{ __('Téléphone:') }} {{ $order->user->phone }}<br>
                                                {{ __('Email') }} {{ $order->user->email }}<br>
                                                {{ __('Adresse') }} {{ $order->user->address }}<br>
                                            </address>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <address>
                                                <strong>{{ __('Moyen de paiement') }}:</strong><br>
                                                {{ $order->payment_method }}<br>
                                            </address>
                                            <address>
                                                <strong>{{ __('Statut du paiement') }}:</strong><br>
                                                {{ $order->payment_status }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">{{ __('Résumé de la commande') }}</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th data-width="40">#</th>
                                                <th>{{ __('Article') }}</th>
                                                <th>{{ __('par') }}</th>
                                                <th class="text-center">{{ __('Prix') }}</th>
                                            </tr>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->course->title }}</td>
                                                    <td>
                                                        {{ $item->course->instructor->name }}
                                                        <br>
                                                        {{ $item->course->instructor->email }}
                                                    </td>
                                                    <td class="text-center">{{ $item->price * $order->conversion_rate }} {{ $order->payable_currency }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4">
                                        </div>

                                        @php
                                            $subTotal = 0;
                                            $discount = 0;
                                            $gatewayCharge = 0;
                                            foreach ($order->orderItems as $item) {
                                                $subTotal += $item->price;
                                            }
                                            if ($order->coupon_discount_amount > 0) {
                                                $discount = $order->coupon_discount_amount;
                                            }
                                            if ($order->gateway_charge > 0) {
                                                $gatewayCharge = ($order->gateway_charge / ($subTotal - $discount)) * 100;
                                            }
                                            
                                            $total = ($subTotal - $discount + $order->gateway_charge) * $order->conversion_rate;
                                        @endphp

                                        <div class="col-lg-8 text-end">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Sous-total') }}</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($subTotal * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>

                                            </div>

                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Remise') }}</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($discount * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Frais de transaction') }}
                                                    ({{ number_format($gatewayCharge) }}%)</div>
                                                <div class="invoice-detail-value">
                                                    {{ number_format($order->gateway_charge * $order->conversion_rate, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('Total') }}</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ number_format($total, 2) }} {{ $order->payable_currency }}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-md-right">

                            <a target="_blank" href="{{ route('student.order.print-invoice', $order->id) }}" class="btn btn-warning btn-icon icon-left print-btn"><i class="fas fa-print"></i>
                                {{ __('Imprimer') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
