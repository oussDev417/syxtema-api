<div class="dashboard__sidebar-wrap">
    <div class="dashboard__sidebar-title mb-20">
        <h6 class="title">{{ __('Bienvenue') }}, {{ userAuth()->name }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            
            <li class="{{ Route::is('student.dashboard') ? 'active' : '' }}">
                <a href="{{ route('student.dashboard') }}">
                    <i class="flaticon-mortarboard"></i>{{ __('Tableau de bord') }}</a>
            </li>

            <li class="{{ Route::is('student.orders.index') ? 'active' : '' }}">
                <a href="{{ route('student.orders.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Historique des commandes') }}
                </a>
            </li>

            <li class="{{ Route::is('student.enrolled-courses') ? 'active' : '' }}">
                <a href="{{ route('student.enrolled-courses') }}">
                    <i class="flaticon-mortarboard"></i>{{ __('Cours inscrits') }}</a>
            </li>
            <li class="{{ Route::is('student.reviews.index') ? 'active' : '' }}">
                <a href="{{ route('student.reviews.index') }}">
                    <i class="flaticon-mortarboard"></i>{{ __('Avis') }}</a>
            </li>
            <li class="{{ Route::is('student.quiz-attempts') ? 'active' : '' }}">
                <a href="{{ route('student.quiz-attempts') }}">
                    <i class="flaticon-mortarboard"></i>{{ __('Mes tentatives de quiz') }}</a>
            </li>
        </ul>
    </nav>
    <div class="dashboard__sidebar-title mt-30 mb-20">
        <h6 class="title">{{ __('Utilisateur') }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            <li>
                <a href="{{ route('student.setting.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Paramètres du profil') }}
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); $('#logout-form').trigger('submit');">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Déconnexion') }}
                </a>
            </li>
        </ul>
    </nav>
</div>

{{-- start admin logout form --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
{{-- end admin logout form --}}
