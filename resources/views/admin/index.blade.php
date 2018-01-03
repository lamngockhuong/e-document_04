@extends('admin.layouts.template')
@section('title', $title)
@section('content')
    {{--Content--}}
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
@endpush
