<header>
    <div class="box_content">
        <div class="icon icon-logo">
            <a title="@lang('e-document.index.title')" href="{{ route('public.index') }}">@lang('e-document.index.title')</a>
        </div>
        <div class="headerRight">
            <div class="mainBox">
                <a href="#" rel="nofollow" class="btn btn_yellow">@lang('e-document.header.deposit')</a>
                <a href="{{ route('document-manager.create') }}" rel="nofollow" class="btn btn_green btn_upload">@lang('e-document.header.upload')</a>
            </div>
            <a href="#" rel="nofollow" target="_blank" class="landBox"><span class="icon i_start"></span></a>
            @guest
                <div class="userBox">
                    <div>{{ link_to_route('register', trans('e-document.header.register'), [], ['ref' => 'nofollow', 'class' => 'btn btn_normal']) }}</div>
                    <div>{{ link_to_route('login', trans('e-document.header.login'), [], ['ref' => 'nofollow', 'class' => 'btn btn_normal']) }}</div>
                </div>
            @else
                <div class="userBox">
                    <div class="userLoginBox">
                        <a rel="nofollow" href="" class="use_img"><img src="{{ auth()->user()->avatar_url }}" onerror="this.src='{{ auth()->user()->default_avatar_url }}'"></a>
                        <a rel="nofollow" class="use_name" href="">{{ auth()->user()->firstname }}</a>
                        <div>
                            <i></i>
                            <ul>
                                <li><a rel="nofollow" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('e-document.header.logout')</a></li>
                            </ul>
                            {{ Form::open(['route' => 'logout', 'id' => 'logout-form', 'style' => 'display: none']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>
