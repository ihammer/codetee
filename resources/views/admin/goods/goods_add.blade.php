@extends("admin.layouts.main")
@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">添加款式</h3>
                            </div>
                        @include("admin.layouts.error")
                        <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" action="/admin/goods/store" method="POST" enctype="multipart/form-data">
                                {{csrf_field() }}
                                <div class="box-body ">
                                    <div class="form-group">
                                        <label for="exampleInputName">款式名称</label><small> (Ps：  男士...) </small>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputTitle">标识</label><small> (Ps：  man/woman/...) </small>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">市场价格</label>
                                        <input type="text" class="form-control"  name="market_price">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">出售价格</label>
                                        <input type="text" class="form-control" name="price" />
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputFile">展示图片</label>
                                        <input type="file" id="exampleInputFile" name="images"  />
                                        <p class="help-block">请上传一张多少X多少的图片</p>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputFile">背景图片</label>
                                        <input type="file" id="exampleInputFile" name="bg_image"/>
                                        <p class="help-block">请上传一张多少X多少的图片</p>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">材质(克数)</label>
                                        <div class="checkbox" >
                                            @foreach($texturelist as $texture)
                                                <label><input type="checkbox" value="{{$texture->id}}"  name="texture[]" /> {{$texture->name}}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">尺码</label>
                                        <div class="checkbox">
                                            @foreach($sizelist as $size)
                                                <label><input type="checkbox" value="{{$size->id}}"  name="size[]" /> {{$size->name}}</label>
                                             @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">权重</label>
                                        <input type="text" class="form-control"  name="weight">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputText">描述</label>
                                        <textarea class="form-control " rows="4" name="description" ></textarea>
                                    </div>
                                </div>
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