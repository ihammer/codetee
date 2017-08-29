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
                                <h3 class="box-title">添加快递公司信息</h3>
                            </div>
                        @include("admin.layouts.error")
                        <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" action="/admin/express/store" method="POST">
                                {{csrf_field() }}
                                <div class="box-body ">
                                    <div class="form-group ">
                                        <label for="exampleInputName">快递公司名称</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">单项运费</label>
                                        <input type="text" class="form-control" name="price">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">权重</label>
                                        <input type="text" class="form-control" name="weight">
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