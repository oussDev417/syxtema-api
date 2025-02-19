<!-- Menu Navigation starts -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('index') }}">
            <img src="{{ asset('../assets/images/logo/1.png') }}" alt="#">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
            <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <li class="menu-title">
                <span>Dashboard</span>
            </li>

            <!-- Menu Coworking -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#coworkings" aria-expanded="false">
                    <i class="ph-duotone ph-buildings"></i>
                    Coworking
                </a>
                <ul class="collapse" id="coworkings">
                    <li><a href="{{ route('admin.coworkings.index') }}">Liste des espaces</a></li>
                    <li><a href="{{ route('admin.coworkings.create') }}">Ajouter un espace</a></li>
                </ul>
            </li>

            <!-- Menu Réservations -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#reservations" aria-expanded="false">
                    <i class="ph-duotone ph-calendar-check"></i>
                    Réservations
                </a>
                <ul class="collapse" id="reservations">
                    <li><a href="{{ route('admin.reservations.index') }}">Toutes les réservations</a></li>
                    <li><a href="{{ route('admin.reservations.pending') }}">Réservations en attente</a></li>
                    <li><a href="{{ route('admin.reservations.statistics') }}">Statistiques</a></li>
                </ul>
            </li>

            <!-- Menu Réalisations -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#portfolios" aria-expanded="false">
                    <i class="ph-duotone ph-image"></i>
                    Réalisations
                </a>
                <ul class="collapse" id="portfolios">
                    <li><a href="{{ route('admin.portfolios.index') }}">Liste des Réalisations</a></li>
                    <li><a href="{{ route('admin.portfolios.create') }}">Ajouter une Réalisation</a></li>
                </ul>
            </li>

            <!-- Menu Histoires de Succès -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#successStories" aria-expanded="false">
                    <i class="ph-duotone ph-trophy"></i>
                    Histoires de Succès
                </a>
                <ul class="collapse" id="successStories">
                    <li><a href="{{ route('admin.success_stories.index') }}">Liste des Histoires</a></li>
                    <li><a href="{{ route('admin.success_stories.create') }}">Ajouter une Histoire</a></li>
                </ul>
            </li>

            <!-- Menu Startups -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#startups" aria-expanded="false">
                    <i class="ph-duotone ph-building"></i>
                    Startups
                </a>
                <ul class="collapse" id="startups">
                    <li><a href="{{ route('admin.startups.index') }}">Liste des Startups</a></li>
                    <li><a href="{{ route('admin.startups.create') }}">Ajouter une Startup</a></li>
                </ul>
            </li>

            <!-- Menu Partenaires -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#partners" aria-expanded="false">
                    <i class="ph-duotone ph-handshake"></i>
                    Partenaires
                </a>
                <ul class="collapse" id="partners">
                    <li><a href="{{ route('admin.partners.index') }}">Liste des Partenaires</a></li>
                    <li><a href="{{ route('admin.partners.create') }}">Ajouter un Partenaire</a></li>
                </ul>
            </li>

            <!-- Menu Événements -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#events" aria-expanded="false">
                    <i class="ph-duotone ph-calendar"></i>
                    Événements
                </a>
                <ul class="collapse" id="events">
                    <li><a href="{{ route('admin.events.index') }}">Liste des Événements</a></li>
                    <li><a href="{{ route('admin.events.create') }}">Ajouter un Événement</a></li>
                    <li><a href="{{ route('admin.event_categories.index') }}">Catégories d'événements</a></li>
                </ul>
            </li>

            <!-- Menu Actualités -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#news" aria-expanded="false">
                    <i class="ph-duotone ph-newspaper"></i>
                    Actualités
                </a>
                <ul class="collapse" id="news">
                    <li><a href="{{ route('admin.news.index') }}">Liste des Actualités</a></li>
                    <li><a href="{{ route('admin.news.create') }}">Ajouter une Actualité</a></li>
                </ul>
            </li>

            <!-- Menu Services -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#services" aria-expanded="false">
                    <i class="ph-duotone ph-briefcase"></i>
                    Services
                </a>
                <ul class="collapse" id="services">
                    <li><a href="{{ route('admin.services.index') }}">Liste des Services</a></li>
                    <li><a href="{{ route('admin.services.create') }}">Ajouter un Service</a></li>
                    <li><a href="{{ route('admin.service_categories.index') }}">Catégories de services</a></li>
                </ul>
            </li>

            <!-- Menu Localisation -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#location" aria-expanded="false">
                    <i class="ph-duotone ph-map-pin"></i>
                    Localisation
                </a>
                <ul class="collapse" id="location">
                    <li><a href="{{ route('admin.countries.index') }}">Pays</a></li>
                    <li><a href="{{ route('admin.departements.index') }}">Départements</a></li>
                </ul>
            </li>

            <!-- Menu Équipe -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#teams" aria-expanded="false">
                    <i class="ph-duotone ph-users-three"></i>
                    Équipe
                </a>
                <ul class="collapse" id="teams">
                    <li><a href="{{ route('admin.teams.index') }}">Liste des membres</a></li>
                    <li><a href="{{ route('admin.teams.create') }}">Ajouter un membre</a></li>
                </ul>
            </li>

            <!-- Menu Témoignages -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#testimonials" aria-expanded="false">
                    <i class="ph-duotone ph-quotes"></i>
                    Témoignages
                </a>
                <ul class="collapse" id="testimonials">
                    <li><a href="{{ route('admin.testimonials.index') }}">Liste des Témoignages</a></li>
                    <li><a href="{{ route('admin.testimonials.create') }}">Ajouter un Témoignage</a></li>
                </ul>
            </li>

            <!-- Menu Messages -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#contacts" aria-expanded="false">
                    <i class="ph-duotone ph-envelope"></i>
                    Messages
                </a>
                <ul class="collapse" id="contacts">
                    <li><a href="{{ route('admin.contacts.index') }}">Liste des messages</a></li>
                </ul>
            </li>

            <!-- Menu Icons -->
            <li>
                <a class="" data-bs-toggle="collapse" href="#icons" aria-expanded="false">
                    <i class="ph-duotone ph-shapes"></i>
                    Icons
                </a>
                <ul class="collapse" id="icons">
                    <li><a href="{{ route('fontawesome') }}">Fontawesome</a></li>
                    <li><a href="{{ route('flag_icons') }}">Flag</a></li>
                    <li><a href="{{ route('tabler_icons') }}">Tabler</a></li>
                    <li><a href="{{ route('weather_icon') }}">Weather</a></li>
                    <li><a href="{{ route('animated_icon') }}">Animated</a></li>
                    <li><a href="{{ route('iconoir_icon') }}">Iconoir</a></li>
                    <li><a href="{{ route('phosphor') }}">Phosphor</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>
</nav>
<!-- Menu Navigation ends -->
