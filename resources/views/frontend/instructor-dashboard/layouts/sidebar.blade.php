<div class="dashboard__sidebar-wrap">
    <div class="dashboard__sidebar-title mb-20">
        <h6 class="title">{{ __('Bienvenue') }}, {{ userAuth()->first_name }} {{ userAuth()->last_name }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            <li class="{{ Route::is('instructor.dashboard') ? 'active' : '' }}">
                <a href="{{ route('instructor.dashboard') }}">
                    <i class="flaticon-mortarboard"></i>{{ __('Tableau de bord') }}</a>
            </li>
            <li class="{{ Route::is('instructor.courses.*') ? 'active' : '' }}">
                <a href="{{ route('instructor.courses.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Cours') }}
                </a>
            </li>
            <li class="{{ Route::is('instructor.lesson-questions.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.lesson-questions.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Questions des leçons') }}
                </a>
            </li>

            <li class="{{ Route::is('instructor.payout.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.payout.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Demande de paiement') }}
                </a>
            </li>
            <li class="{{ Route::is('instructor.announcements.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.announcements.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Annonce') }}
                </a>
            </li>
            <li class="{{ Route::is('instructor.my-sells.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.my-sells.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Mes ventes') }}
                </a>
            </li>
        </ul>
    </nav>
    <div class="dashboard__sidebar-title mt-30 mb-20">
        <h6 class="title">{{ __('Utilisateur') }}</h6>
    </div>
    <nav class="dashboard__sidebar-menu">
        <ul class="list-wrap">
            <li class="{{ Route::is('instructor.zoom-setting.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.zoom-setting.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Paramètres Zoom live') }}
                </a>
            </li>
            <li class="{{ Route::is('instructor.jitsi-setting.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.jitsi-setting.index') }}">
                    <i class="flaticon-mortarboard"></i>
                    {{ __('Paramètres Jitsi live') }}
                </a>
            </li>
            <li class="{{ Route::is('instructor.setting.index') ? 'active' : '' }}">
                <a href="{{ route('instructor.setting.index') }}">
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
