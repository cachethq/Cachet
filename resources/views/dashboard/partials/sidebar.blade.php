<div class="sidebar">
    <div class="sidebar-inner">
        <div class="profile">
            <a href="{{ cachet_route('dashboard.user') }}">
                <h4 class="username"><i class='ion ion-person'></i> {{ $currentUser->username }}</h4>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="quick-add-incident">
            <a class="btn btn-block btn-success" href="{{ cachet_route('dashboard.incidents.create') }}">
                <i class="ion ion-android-checkmark-circle visible-sm"></i>
                <span class="hidden-sm">{{ trans('dashboard.incidents.add.title') }}</span>
            </a>
        </div>
        <ul>
            <li {!! set_active('dashboard') !!}>
                <a href="{{ cachet_route('dashboard') }}">
                    <i class="ion ion-speedometer"></i>
                    <span>{{ trans('dashboard.dashboard') }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/incidents*') !!}>
                <a href="{{ cachet_route('dashboard.incidents') }}">
                    <i class="ion ion-ios-information-outline"></i>
                    <span>{{ trans('dashboard.incidents.incidents') }}</span>
                    <span class="label label-info">{{ $incidentCount }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/templates*') !!}>
                <a href="{{ cachet_route('dashboard.templates') }}">
                    <i class="ion ion-ios-paper-outline"></i>
                    <span>{{ trans('dashboard.incidents.incident-templates') }}</span>
                    <span class="label label-info">{{ $incidentTemplateCount }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/schedule*') !!}>
                <a href="{{ cachet_route('dashboard.schedule') }}">
                    <i class="ion ion-android-calendar"></i>
                    <span>{{ trans('dashboard.schedule.schedule') }}</span>
                    <span class="label label-info">{{ $scheduleCount }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/components*') !!}>
                <a href="{{ cachet_route('dashboard.components') }}">
                    <i class="ion ion-ios-browsers-outline"></i>
                    <span>{{ trans('dashboard.components.components') }}</span>
                    <span class="label label-info">{{ $componentCount }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/metrics*') !!}>
                <a href="{{ cachet_route('dashboard.metrics') }}">
                    <i class="ion ion-ios-pie-outline"></i>
                    <span>{{ trans('dashboard.metrics.metrics') }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/subscribers*') !!}>
                <a href="{{ cachet_route('dashboard.subscribers') }}">
                    <i class="ion ion-ios-email-outline"></i>
                    <span>{{ trans('dashboard.subscribers.subscribers') }}</span>
                    <span class="label label-info">{{ $subscriberCount }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/team*') !!}>
                <a href="{{ cachet_route('dashboard.team') }}">
                    <i class="ion ion-ios-people-outline"></i>
                    <span>{{ trans('dashboard.team.team') }}</span>
                </a>
            </li>
            <li {!! set_active('dashboard/settings*') !!}>
                <a href="{{ cachet_route('dashboard.settings.setup') }}">
                    <i class="ion ion-ios-gear-outline"></i>
                    <span>
                        {{ trans('dashboard.settings.settings') }}
                    </span>
                </a>
            </li>
            <li class="hidden-lg hidden-md">
                <a href="{{ cachet_route('auth.logout') }}">
                    <i class="ion ion-log-out"></i>
                </a>
            </li>
        </ul>
        <div class="bottom-menu-sidebar">
            <ul>
                <li data-toggle="tooltip" data-placement="top" title="{{ trans('dashboard.help') }}">
                    <a href="https://docs.cachethq.io" target="_blank"><i class="ion ion-help"></i></a>
                </li>
                <li data-toggle="tooltip" data-placement="top" title="{{ trans('dashboard.status_page') }}">
                    <a href="{{ cachet_route('status-page') }}"><i class="ion ion-monitor"></i></a>
                </li>
                <li data-toggle="tooltip" data-placement="top" title="{{ trans('dashboard.logout') }}">
                    <a href="{{ cachet_route('auth.logout') }}"><i class="ion ion-log-out"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
