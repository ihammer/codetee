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
                                <h3 class="box-title">添加款式颜色</h3>
                            </div>
                        @include("admin.layouts.error")
                        <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" action="/admin/color/store" method="POST" enctype="multipart/form-data">
                                {{csrf_field() }}
                                <div class="box-body ">
                                    <div class="form-group ">
                                        <label for="exampleInputName">选择款式</label>
                                        <select class="form-control" name="good_id">
                                            @foreach($goodsList as $list)
                                                <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">颜色名称</label>
                                        <input type="text" class="form-control" name="color_name">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">标识 <small> (Ps：  white/black/...) </small></label>
                                        <input type="text" class="form-control" name="color_title">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">颜色值</label>
                                        <input type="text" class="form-control" name="color_tone" id="color_tone">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputFile">展示图片</label>
                                        <input type="file" id="exampleInputFile" name="color_image"  />
                                        <p class="help-block">请上传一张多少X多少的图片</p>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputFile">背景图片</label>
                                        <input type="file" id="exampleInputFile" name="color_bg_image"/>
                                        <p class="help-block">请上传一张多少X多少的图片</p>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">权重</label>
                                        <input type="text" class="form-control" name="color_weight">
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