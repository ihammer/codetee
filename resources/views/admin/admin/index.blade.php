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
                        <a type="button" class="btn " href="/admin/admin_users/create" >增加用户</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>用户名称</th>
                                    <th>邮箱</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($userlist as $list)
                                <tr>
                                    <td>{{$list->id}}</td>
                                    <td>{{$list->name}}</td>
                                    <td>{{$list->email}}</td>
                                    <td>
                                        <a type="button" class="btn" href="/admin/users/{{$list->id}}/role" >角色管理</a>
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