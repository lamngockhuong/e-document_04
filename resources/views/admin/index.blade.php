@extends('admin.layouts.template')
@section('title', 'Admin Control Panel')
@section('content')
    <!--------------------------
      | Your Page Content Here |
      -------------------------->
@endsection
@push('script')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
 Both of these plugins are recommended to enhance the
 user experience. -->
{!! Html::script('templates/admin/js/index.js') !!}
@endpush
