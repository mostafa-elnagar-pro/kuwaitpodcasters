@php
    $lang = app()->currentLocale();
@endphp

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header mt-1">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="width:100px">
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="mt-1 main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <!-- home -->
            @permission('home-read')
                <li class="nav-item {{ activePath(["$lang/dashboard"]) ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('admin.home') }}">
                        <i class="bi bi-house"></i>
                        <span class="menu-title" data-i18n="Home">
                            {{ __('label.home') }}
                        </span>
                    </a>
                </li>
            @endpermission
            <!--/ home -->


            <!-- roles & permissions -->
            <li class="nav-item hide-by-default">
                <a class="d-flex align-items-center">
                    <i class="bi-shield-check"></i>
                    <span class="menu-title" data-i18n="Roles&Permissions">
                        {{ __('label.roles&permissions') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <x-dashboard.sidebar-item resource='roles' icon='bi-tag' />
                    {{-- <x-dashboard.sidebar-item resource='permissions' icon='bi-lock' /> --}}
                </ul>
            </li>
            <!--/ roles & permissions -->


            <!-- user management -->
            <li class="nav-item hide-by-default">
                <a class="d-flex align-items-center">
                    <i class="bi-person-gear"></i>
                    <span class="menu-title" data-i18n="UserManagement">
                        {{ __('label.user_management') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <x-dashboard.sidebar-item resource='admins' icon='bi-person-lock' />
                    <x-dashboard.sidebar-item resource='users' icon='bi-people' />
                    <x-dashboard.sidebar-item resource='podcasters' icon='bi-person' />
                </ul>
            </li>
            <!--/ user management -->

            <!-- content management -->
            <li class="nav-item hide-by-default">
                <a class="d-flex align-items-center">
                    <i class="bi bi-card-checklist"></i>
                    <span class="menu-title" data-i18n="UserManagement">
                        {{ __('label.content_management') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <x-dashboard.sidebar-item resource='channels' icon='bi-broadcast' />
                    <x-dashboard.sidebar-item resource='seasons' icon='bi-calendar-range' />
                    <x-dashboard.sidebar-item resource='podcasts' icon='bi-mic' :showCreate="false" />
                    <x-dashboard.sidebar-item resource='articles' icon='bi-journal-text' />
                </ul>
            </li>
            <!--/ content management -->

            <!-- dynamic lists -->
            <li class="nav-item hide-by-default">
                <a class="d-flex align-items-center">
                    <i class="bi-list"></i>
                    <span class="menu-title" data-i18n="UserManagement">
                        {{ __('label.dynamic_lists') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <x-dashboard.sidebar-item resource='countries' icon='bi-globe' />
                    <x-dashboard.sidebar-item resource='categories' icon='bi-grid' />
                    {{-- <x-dashboard.sidebar-item resource='languages' icon='bi-translate' /> --}}
                    <x-dashboard.sidebar-item resource='sliders' icon='bi-sliders' />
                    <x-dashboard.sidebar-item resource='keywords' icon='bi-hash' />
                    <x-dashboard.sidebar-item resource='settings' icon='bi-gear' :show-create="false" :sub-list="['text', 'trans_text', 'image', 'audio', 'video']" />
                </ul>
            </li>
            <!--/ dynamic lists -->

            <!-- support -->
            <li class="nav-item hide-by-default">
                <a class="d-flex align-items-center">
                    <i class="bi-headset"></i>
                    <span class="menu-title" data-i18n="UserManagement">
                        {{ __('label.support') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <x-dashboard.sidebar-item resource='feedbacks' icon='bi-chat' :show-create="false" :has-sub="false" />
                    <x-dashboard.sidebar-item resource='app_rates' icon='bi-star' :show-create="false" :has-sub="false" />
                </ul>
            </li>
            <!--/ support -->

        </ul>
    </div>
</div>





@push('js')
    <script>
        $(document).ready(function() {
            $('.hide-by-default').each(function() {
                var $ul = $(this).find('ul.menu-content');
                if ($ul.children().length > 0) {
                    $(this).removeClass('hide-by-default');
                }
            });
        });
    </script>
@endpush
