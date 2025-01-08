@extends('frontend.instructor-dashboard.layouts.master')

@section('dashboard-contents')
    <div class="dashboard__content-wrap dashboard__content-wrap-two mb-60">
        <div class="dashboard__content-title">
            <h4 class="title">{{ __('Tableau de bord') }}</h4>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalCourses }}"></span>
                        <p>{{ __('TOTAL DES COURS') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalPendingCourses }}"></span>
                        <p>{{ __('COURS EN ATTENTE') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalOrders }}"></span>
                        <p>{{ __('TOTAL DES COMMANDES') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count odometer" data-count="{{ $totalPendingOrders }}"></span>
                        <p>{{ __('COMMANDES EN ATTENTE') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count" data-count="">{{ currency(userAuth()->wallet_balance) }}</span>
                        <p class="mt-3">{{ __('Solde actuel') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="dashboard__counter-item">
                    <div class="icon">
                        <i class="flaticon-mortarboard"></i>
                    </div>
                    <div class="content">
                        <span class="count">{{ currency($totalWithdraw) }}</span>
                        <p class="mt-3">{{ __('Total des paiements') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
