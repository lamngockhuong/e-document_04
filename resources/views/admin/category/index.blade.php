@extends('admin.layouts.template')
@section('title', $title)
@section('content')

@endsection
@push('script')
    {!! Html::script('templates/admin/js/index.js') !!}
@endpush
