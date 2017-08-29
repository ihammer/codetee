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
                            <h3 class="box-title">二维码操作列表</h3>
                        </div>
                        {{--<a type="button" class="btn " href="/admin/color/create" >添加款式颜色</a>--}}
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>订单号</th>
                                    <th>款式名称</th>
                                    <th>下单用户</th>
                                    <th>状态</th>
                                    <th>二维码</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($alreadyList as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->order_no}}</td>
                                        <td>{{$list->good_name}}</td>
                                        <td>{{$list->user_name}}</td>
                                        <td>{{$list->status_info}}</td>
                                        <td  style="margin: 0px; padding: 0px"><a href="/admin/code/{{$list->order_no}}/see?size=300" target="_blank"><img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(82)->generate($list->qrcont)) !!}" style="margin: 0px; padding: 0px" /></a></td>
                                        <td>
                                               {{-- <a type="button" class="btn" href="/admin/code/{{$list->id}}/edit">修改内容</a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                        {{$alreadyList->links()}}
                    </div>
                </div>
            </div>
        </section>
        <div class="visible-print text-center">
   sdfdsfsdf
            <p>Scan me to return to the original page.</p>
        </div>
        <!-- /.content -->
    </div>
@endsection