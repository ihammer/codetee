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
                        <a type="button" class="btn " href="/admin/users/create" >增加用户</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>头像</th>
                                    <th>用户名</th>
                                    <th>手机号</th>
                                    <th>性别</th>
                                    <th>地址</th>
                                    <th>订单数量</th>
                                    <th>注册时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($userlist as $list)
                                <tr>
                                    <td>{{$list->id}}</td>
                                    <td><img src="{{$list->avatar}}" style="margin:0; padding:0;width: 25px;height: 25px"/></td>
                                    <td>{{$list->name}}</td>
                                    <td>{{$list->mobile}}</td>
                                    <td>
                                        @if($list->sex==1)
                                            男
                                            @else
                                            女
                                            @endif
                                    </td>
                                    <td>{{$list->address}}</td>
                                    <td>0</td>
                                    <td>{{$list->created_at}}</td>
                                    <td>
                                        <a type="button" class="btn" href="/admin/users/{{$list->id}}/address" >收货地址</a>
                                        <a type="button" class="btn" href="/admin/users/{{$list->id}}/edit" >编辑</a>
                                        <a type="button" class="btn" href="/admin/users/{{$list->id}}/order" >订单管理</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                        {{$userlist->links()}}
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection