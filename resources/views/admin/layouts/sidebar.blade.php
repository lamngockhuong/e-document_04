<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://adminlte.io/themes/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
        </div>
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">@lang('admin.sidebar.header')</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th-list"></i> <span>@lang('admin.sidebar.category.parent')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.category.index')</a></li>
                    <li><a href="{{ route('categories.create') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.category.create')</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tag"></i> <span>@lang('admin.sidebar.tag.parent')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ route('tags.index') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.tag.index')</a></li>
                    <li><a href="{{ route('tags.create') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.tag.create')</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>@lang('admin.sidebar.user.parent')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.user.index')</a></li>
                    <li><a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i> @lang('admin.sidebar.user.create')</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
