<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ $page_title }}
        <small>{{ $page_description }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
        {{ $breadcrumb }}
    </ol>
</section>
