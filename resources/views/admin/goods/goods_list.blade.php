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
                            <h3 class="box-title">款式列表</h3>
                        </div>
                        <a type="button" class="btn " href="/admin/goods/create" >添加款式</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>款式名称</th>
                                    <th>标识</th>
                                    <th>展示图片</th>
                                    <th>价格</th>
                                    <th>材质</th>
                                    <th>尺码</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($goodsList as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->title}}</td>
                                        <td><img src="{{$list->images}}"></td>
                                        <td>{{$list->price}}</td>
                                        <td>{{$list->texture}}</td>
                                        <td>{{$list->size}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td>
                                            <a type="button" class="btn" href="/admin/goods/{{$list->id}}/edit">编辑</a>
                                            @if($list->status==1)
                                            <a type="button" class="btn" href="/admin/goods/{{$list->id}}/down/goodsStatus">下架</a>
                                            @else
                                                <a type="button" class="btn" href="/admin/goods/{{$list->id}}/up/goodsStatus">上架</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                        {{$goodsList->links()}}
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection