<x-dashboard.layout :title="__('label.home')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.home') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            {{ __('label.home') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <!-- Widgets -->
    <div class="row">
        <x-dashboard.widget label="admins" :value="$widgets->admins_count" icon="person-check" />
        <x-dashboard.widget label="podcasters" :value="$widgets->podcasters_count" icon="mic" />
        <x-dashboard.widget label="users" :value="$widgets->users_count" icon="person" />
        <x-dashboard.widget label="channels" :value="$widgets->channels_count" icon="broadcast" />
        <x-dashboard.widget label="seasons" :value="$widgets->seasons_count" icon="calendar" />
        <x-dashboard.widget label="podcasts" :value="$widgets->podcasts_count" icon="headphones" />
        <x-dashboard.widget label="videos" :value="$widgets->videos_count" icon="film" />
        <x-dashboard.widget label="audios" :value="$widgets->audios_count" icon="music-note" />
    </div>
    <!--/ widgets -->


    <!-- Charts -->
    <div class="row">
        <div class="col-12">
            <x-dashboard.charts.active-podcasters-chart :list="$activePodcasters" />
        </div>
        <div class="col-md-6">
            <x-dashboard.charts.content-type-chart :videos="$widgets->videos_count" :audios="$widgets->audios_count" />
        </div>
        <div class="col-md-6">
            <x-dashboard.charts.user-type-chart :users="$widgets->users_count" :podcasters="$widgets->podcasters_count" />
        </div>
    </div>
    <!--/ Charts  -->


    <!-- Datatables -->
    @permission('feedbacks-read')
        <x-dashboard.home-datatable />
    @endpermission
    <!--/ Datatables  -->


    </x-dashboard.layout.master>
