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
                                <h3 class="box-title">添加材质</h3>
                            </div>
                        @include("admin.layouts.error")
                        <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" action="/admin/texture/store" method="POST">
                                {{csrf_field() }}
                                <div class="box-body ">
                                    <div class="form-group ">
                                        <label for="exampleInputName">材质名称</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group ">
                                        <label for="exampleInputDescription">材质名称</label>
                                        <textarea name="description" class="form-control"></textarea>
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