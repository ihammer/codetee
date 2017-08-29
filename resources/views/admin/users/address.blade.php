@extends("admin.layouts.main")
@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-xs-6">
                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">用户列表</h3>
                    </div>
                    <a type="button" class="btn " href="/admin/users/{{$userInfo->id}}/address_add" >添加地址</a>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody><tr>
                                <th style="width: 10px">#</th>
                                <th>用户名</th>
                                <th>收货人</th>
                                <th>联系方式</th>
                                <th>地址</th>
                                <th>是否默认</th>
                                <th>操作</th>
                            </tr>
                            @foreach($addresslist as $list)
                            <tr>
                                <td>{{$list->id}}</td>
                                <td>{{$userInfo->name}}</td>
                                <td>{{$list->consignee}}</td>
                                <td>{{$list->mobile}}</td>
                                <td>{{$list->province}}/{{$list->city}}/{{$list->county}}/{{$list->detaile}}</td>
                                <td>
                                    @if($list->is_default==1)
                                        默认
                                        @else
                                            普通
                                        @endif
                                </td>
                                <td>
                                    <a type="button" class="btn" href="#" >编辑</a>
                                    <a type="button" class="btn" href="#" >删除</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody></table>
                    </div>
                    {{$addresslist->links()}}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection