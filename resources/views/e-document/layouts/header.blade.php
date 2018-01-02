<header id="tl24h-header">
    <div class="container">
        <div class="left-header">
            <div class="logo-header table-cell">
                <a href="http://tailieu24h.com/"><img src="http://tailieu24h.com/themes/ebook/images/logo.png"></a>
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
                <ul class="top-nav tl24h-bullet">
                    <li><a href="" rel="nofollow">@lang('e-document.header.login')</a></li>
                    <li class="login"><a href="" rel="nofollow">@lang('e-document.header.register')</a></li>
                </ul>
            </div>
        </div>
    </div>
</header><!-- #header -->
