<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <searchbar></searchbar>

            <template id="searchbar">
                <form action="{{ route('search') }}" role="search" class="navbar-form-custom">
                    <div class="form-group">
                        <input id="typeahead" type="text" class="form-control" placeholder="{{ trans('forms.placeholders.search') }}"
                               v-model="query" v-on:keyup="search" v-on:keyup.enter="submit" debounce="1000">
                    </div>
                </form>
            </template>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            @if (auth()->check())
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle count-info">
                        <i class="fa fa-envelope"></i>
                        @if (auth()->user()->countUnreadMessages())
                            <span class="label label-warning">{{ auth()->user()->countUnreadMessages() }}</span>
                        @endif
                    </a>

                    <!--Message dropdown menu-->
                    <ul class="dropdown-menu dropdown-messages">
                        @foreach(auth()->user()->conversations() as $conversation)
                            <li>
                                <a href="{{ route('conversation.show', $conversation->id()) }}">
                                    <div class="dropdown-messages-box">
                                        <div class="media-body">
                                            <small class="pull-right">{{ eqm_translated_date($conversation->updated_at)->diffForHumans() }}</small>
                                            {{ $conversation->subject() }} <br>
                                            <small class="text-muted"></small>
                                            {{ $conversation->contactPerson(auth()->user())->fullName() }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                        @endforeach

                        <li>
                            <div class="text-center link-block">
                                <a href="{{ route('conversation.index') }}">
                                    <i class="fa fa-envelope"></i> <strong>{{ trans('copy.titles.go_to_inbox') }}</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <notedrop></notedrop>

                @include('layout.partials._notifications_dropdown')

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-user"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @if (auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="fa fa-shield fa-fw fa-lg"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('users.profiles.show', auth()->user()->slug()) }}">
                                <i class="fa fa-user fa-fw fa-lg"></i> {{ trans('copy.titles.profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('conversation.index') }}">
                                @if (Auth::user()->countUnreadNotifications())
                                    <span class="badge badge-mint pull-right">{{ Auth::user()->countUnreadMessages() }}</span>
                                @endif
                                <i class="fa fa-envelope fa-fw fa-lg"></i> {{ trans('copy.titles.messages') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.index') }}">
                                <i class="fa fa-gear fa-fw fa-lg"></i> {{ trans('copy.a.settings') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out fa-fw fa-lg"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</div>
