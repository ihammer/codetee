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
                            <h3 class="box-title">款式颜色列表</h3>
                        </div>
                        <a type="button" class="btn " href="/admin/color/create" >添加款式颜色</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>款式名称</th>
                                    <th>标识</th>
                                    <th>展示图片</th>
                                    <th>颜色名称</th>
                                    <th>颜色值</th>
                                    <th>权重</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($colorList as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->color_title}}</td>
                                        <td><img src="{{$list->color_image}}"></td>
                                        <td>{{$list->color_name}}</td>
                                        <td style="background: {{$list->color_tone}}"></td>
                                        <td>{{$list->color_weight}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td>
                                            <a type="button" class="btn" href="/admin/color/{{$list->id}}/edit">编辑</a>
                                            <a type="button" class="btn" href="/admin/color/{{$list->id}}/delete">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                        {{$colorList->links()}}
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection