@extends("admin.layouts.main")
@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-xs-6">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">修改二维码内容</h3>
                            </div>
                        @include("admin.layouts.error")
                        <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" action="/admin/order/{{$already->id}}/storeEdit" method="POST" enctype="multipart/form-data">
                                {{csrf_field() }}
                                <div class="box-body ">
                                    <div class="form-group ">
                                        <label for="exampleInputName">内容类型</label>
                                        <select class="form-control" name="good_id">
                                            <option value="">----请选择类型----</option>
                                            <option value="1"   @if($already->model==1) selected @endif >---文字---</option>
                                            <option value="1"   @if($already->model==2) selected @endif >---图文---</option>
                                            <option value="1"   @if($already->model==3) selected @endif >---视文---</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1"></label>
                                        <input type="text" class="form-control" name="color_name"  value="" />
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputFile">展示图片</label>
                                        <img src="" style="display: block" /><br/>
                                        <input type="file" id="exampleInputFile" name="color_image"  />
                                        <p class="help-block">请上传一张多少X多少的图片</p>
                                    </div>
                                </div>
                            @include("admin.layouts.error")
                            <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection