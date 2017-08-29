@extends("admin.layouts.main")

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-xs-6">
                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">材质列表 <small>&nbsp;&nbsp;此操作请转交给技术在数据库执行</small></h3>
                        </div>
                        <a type="button" class="btn " href="/admin/texture/create" >添加材质</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>材质名称（单位g）</th>
                                    <th>权重</th>
                                    <th>描述</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($txturelist as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->weight}}</td>
                                        <td>{{$list->description}}</td>
                                        <td>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection