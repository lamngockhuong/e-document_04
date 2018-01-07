<header id="tl24h-header">
    <div class="container">
        <div class="left-header">
            <div class="logo-header table-cell">
                <a href=""><img src="http://tailieu24h.com/themes/ebook/images/logo.png"></a>
            </div>
        </div>
        <div class="header-search-zone">
            <div class="header-search table-cell">
                {!! Form::open(['class' => 'frm-search', 'method' => 'GET']) !!}
                    {!! Form::text('q', '', ['class' => 'prompt', 'placeholder' => trans('e-document.header.search_placeholder')]) !!}
                    <i class="fa fa-search" onclick="this.parentNode.submit();"></i>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="right-header">
            <div class="top-nav-right">
                @guest
                    <ul class="top-nav tl24h-bullet">
                        <li>{{ link_to_route('login', trans('e-document.header.login'), [], ['ref' => 'nofollow']) }}</li>
                        <li class="login">{{ link_to_route('register', trans('e-document.header.register'), [], ['ref' => 'nofollow']) }}</li>
                    </ul>
                @else
                    <div class="userBox">
                        <div class="userLoginBox">
                            <a rel="nofollow" href="#" class="use_img"><img src="http://tailieu24h.com/themes/ebook/images/user_small.png"></a>
                            <a rel="nofollow" class="use_name" href="#">{{ auth()->user()->firstname }}</a>
                            <div>
                                <ul>
                                    <li><a rel="nofollow" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                </ul>
                                {{ Form::open(['route' => 'logout', 'id' => 'logout-form', 'style' => 'display: none']) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header><!-- #header -->
