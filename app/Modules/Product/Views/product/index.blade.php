@extends('layouts.app')
@section('header-css')
    {!! Html::style('assets/dist/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/dist/css/buttons.dataTables.min.css') !!}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5><i class="fa fa-list-alt"></i> Products</h5>
                </div><!--col-->

                <div class="col-sm-7 pull-right">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success" title="Create new" data-original-title="Create New">
                            <i class="fa fa-plus-circle"></i> Create
                        </a>
                    </div>
                </div><!--col-->
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['url'=>'admin/products/show', 'method'=>'get']) !!}
            <div class="row jumbotron p-1">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('title','Title : ',['class'=>'font-weight-bold']) !!}
                        {!! Form::text('title',isset($params['title']) ? $params['title'] : '',['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('category_id','Category : ',['class'=>'font-weight-bold']) !!}
                        {!! Form::select('category_id',$categories,isset($params['category_id']) ? $params['category_id'] : '',['class'=>'form-control categoryId','placeholder'=>'Select Category']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('subcategory_id','Subcategory : ',['class'=>'font-weight-bold']) !!}
                        {!! Form::select('subcategory_id',[],isset($params['subcategory_id']) ? $params['subcategory_id'] : '',['class'=>'subcategoryId form-control','placeholder'=>'Select Subcategory']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('price','Price : ',['class'=>'font-weight-bold']) !!}
                        {!! Form::number('price',isset($params['price']) ? $params['price'] : '',['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group pt-4">
                        <button type="submit" class="btn btn-primary mt-2"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        {!! $dataTable->table() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
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
