@extends('layouts.app')
@section('header-css')
    {!! Html::style('assets/backend/dist/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/backend/dist/css/buttons.dataTables.min.css') !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 breadcrumb">
           <p>Welcome <strong class="text-success">{{ auth()->user()->name }}</strong> to dashboard!</p>
        </div>
    </div>

@endsection
@section('footer-script')
    {!! Html::script('assets/dist/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/dist/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('assets/dist/js/dataTables.buttons.min.js') !!}
    {!! Html::script('assets/dist/js/buttons.server-side.js') !!}
    @if(isset($dataTable))
        {!! $dataTable->scripts() !!}
    @endif
@endsection
