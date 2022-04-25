@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row col-sm">
                <h5><i class="fa fa-plus-square"></i> Add Product</h5>
            </div>
        </div>
        {!! Form::open(['route'=>'admin.products.store', 'method'=>'post','enctype'=>'multipart/form-data','id'=>'dataForm']) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    {!! Form::label('title','Title',['class'=>'required-star']) !!}
                    {!! Form::text('title','',['class'=>'required form-control '.($errors->has('title')?'is-invalid':''),'placeholder'=>'Title']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('category_id','Category',['class'=>'required-star']) !!}
                    {!! Form::select('category_id',$categories,'',['class'=>'categoryId required form-control '.($errors->has('category_id')?'is-invalid':''),'placeholder'=>'Select category']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('subcategory_id','Subcategory',['class'=>'required-star']) !!}
                    {!! Form::select('subcategory_id',[],'',['class'=>'subcategoryId required form-control '.($errors->has('subcategory_id')?'is-invalid':''),'placeholder'=>'Select subcategory']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('price','Price',['class'=>'required-star']) !!}
                    {!! Form::number('price','',['class'=>$errors->has('price')?'form-control is-invalid':'form-control required','placeholder'=>'Price']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('status','Status',['class'=>'font-weight-bold required-star']) !!}
                    {!! Form::select('status',["Active" =>'Active',"Inactive" => 'Inactive'],'',['class'=>$errors->has('status')?'form-control is-invalid':'form-control required']) !!}
                </div>
                <div class="col-md-4 form-group">
                    {!! Form::label('thumbnail', 'Thumbnail Image :',['class'=>'required-star'])  !!}
                    <br/>
                    <img class="img img-responsive img-thumbnail viewImage" src="{{ url('assets/img/photo.png') }}" id="thumbnailViewer" height="150" width="130">
                    <label class="btn btn-block btn-secondary btn-sm bordered-0" style="width: 130px;">
                        <input class="imageChange" type="file" name="thumbnail" style="display: none" accept="image/jpeg,image/jpg,image/png">
                        <i class="fa fa-image"></i> Browse
                    </label>
                    <span id="photo_err" class="text-danger mt-3 imgErr" style="font-size: 15px;"></span>
                </div>
                <div class="col-md-12 form-group">
                    {!! Form::label('description','Description',['class'=>'required-star']) !!}
                    {!! Form::textarea('description','',['class'=>$errors->has('description')?'form-control is-invalid':'form-control required','id'=>'description']) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.products.index') }}" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a>
            <button type="submit" class="btn float-right btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
        {!! Form::close() !!}
    </div><!--card-->
@endsection
@section('footer-script')
    {!! Html::script('assets/dist/js/tinymce/tinymce.min.js') !!}
    <script type="text/javascript">
        /*********************
         RICH TEXT HERE
         *********************/
        tinymce.init({
            selector: '#description',
            height: 250,
            content_style: 'img {max-width: 100%;}',
            max_chars: 1000, // max. allowed chars
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
            },
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste imagetools"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ],
            image_title: true,
            automatic_uploads: true,
            // images_upload_url: '/upload',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    if(Math.round((this.files[0].size/1024)*100/100) > 200){
                        alert('Image size maximum 200KB');
                        return false
                    }else {
                        var reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                    }
                };
                input.click();
            }
        });
    </script>
@endsection
