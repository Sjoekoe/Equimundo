<div class="ibox float-e-margins">
    <div class="ibox-content no-padding">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item {{ Active::route('settings.index') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    Account
                </h5>
            </a>
            <a href="{{ route('users.profiles.edit') }}" class="list-group-item {{ Active::route('users.profiles.edit') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    {{ trans('copy.titles.profile') }}
                </h5>
            </a>
            <a href="{{ route('horses.settings.index') }}" class="list-group-item {{ Active::route('horses.settings.index') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    {{ trans('copy.titles.horses') }}
                </h5>
            </a>
            <a href="{{ route('invite_friends') }}" class="list-group-item {{ Active::route('invite_friends') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    {{ trans('copy.a.invite_friends') }}
                </h5>
            </a>
            <a href="{{ route('password.edit') }}" class="list-group-item {{ Active::route('password.edit') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    {{ trans('copy.a.change_password') }}
                </h5>
            </a>
        </div>
    </div>
</div>

