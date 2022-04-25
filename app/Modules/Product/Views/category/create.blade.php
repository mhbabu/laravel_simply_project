@extends('layouts.modal')
@section('title') <h5><i class="fa fa-plus-square"></i> Create Category</h5> @endsection
@section('content')
    {!! Form::open(['route'=>'admin.product.categories.store', 'method'=>'post','id'=>'dataForm']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('name','Name : ',['class'=>'required-star']) !!}
                    {!! Form::text('name','',['class'=>$errors->has('name')?'form-control is-invalid':'form-control required']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('status','Status : ',['class'=>'required-star']) !!}
                    {!! Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],'',['class'=>$errors->has('status')?'form-control is-invalid':'form-control required']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
        <button name="actionBtn" id="actionButton" type="submit" value="submit" class="actionButton btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Save </button>
    </div>
    {!! Form::close() !!}
@endsection
