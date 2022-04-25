@extends('layouts.modal')
@section('title') <h5><i class="fa fa-edit"></i> Edit Category</h5> @endsection
@section('content')
    {!! Form::open(['route'=>['admin.product.categories.update',$category->id], 'method'=>'patch','id'=>'dataForm']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('name','Name : ',['class'=>'required-star']) !!}
                    {!! Form::text('name',$category->name,['class'=>$errors->has('name')?'form-control is-invalid':'form-control required']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('status','Status : ',['class'=>'required-star']) !!}
                    {!! Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],$category->status,['class'=>$errors->has('status')?'form-control is-invalid':'form-control required']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
        <button name="actionBtn" id="actionButton" type="submit" value="submit" class="actionButton btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Update </button>
    </div>
    {!! Form::close() !!}
@endsection
