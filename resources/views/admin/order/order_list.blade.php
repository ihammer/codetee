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
                            <h3 class="box-title">已经完成订单</h3>
                        </div>
                        {{--<a type="button" class="btn " href="/admin/color/create" >添加款式颜色</a>--}}
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>订单号</th>
                                    <th>款式名称</th>
                                    <th>款式信息</th>
                                    <th>下单用户</th>
                                    <th>订单数量</th>
                                    <th>成交价格</th>
                                    <th>状态</th>
                                    <th>支付方式</th>
                                    <th>下单时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($alreadyList as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->order_no}}</td>
                                        <td>{{$list->good_name}}</td>
                                        <td width="15%">
                                            <b>颜色：</b>{{$list->order_info->color->color_name}}（{{$list->order_info->color->color_tone}}）
                                            <b>图案：</b>{{$list->order_info->pattern->pattern_name}}
                                             <b>尺码：</b>{{$list->order_info->size}}
                                            <b>克数：</b>{{$list->order_info->texture}}
                                        </td>
                                        <td>{{$list->user_name}}</td>
                                        <td>{{$list->amount}}</td>
                                        <td>{{$list->total}}</td>
                                        <td>{{$list->status_info}}</td>
                                        <td>{{$list->order_func}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td width="20%">
                                           {{-- $data=[100=>'未支付',101=>'已取消',200=>'已支付',201=>'已退款',202=>'已收货',203=>'已发货'];--}}
                                            @if($list->status==100)
                                                <a type="button" class="btn" href="###">编辑订单</a>
                                                <a type="button" class="btn" href="###">取消订单</a>
                                            @endif
                                            @if($list->status==101||$list->status==201)
                                            ---
                                            @endif
                                            @if($list->status==200)
                                            <a type="button" class="btn" href="###">编辑订单</a>
                                            <a type="button" class="btn" href="###">发货</a>
                                            <a type="button" class="btn" href="###">退款</a>
                                            @endif
                                            @if($list->status==202)
                                            <a type="button" class="btn" href="###">交易成功</a>
                                            @endif
                                            @if($list->status==203)
                                            <a type="button" class="btn" href="###">确认收获</a>
                                            @endif



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