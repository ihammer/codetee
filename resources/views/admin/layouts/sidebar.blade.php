<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li   class=" @if($action=="UsersController") active @endif "><a href="/admin/users"><i class="fa fa-user"></i> <span>用户管理</span></a></li>
            <li class="treeview @if($action=="GoodsController") active @endif">
                <a href="#"><i class="fa fa-send"></i> <span>产品管理</span>
                    <span class="pull-right-container">
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/goods"><i class="fa fa-circle-o"></i>款式管理</a></li>
                    <li><a href="/admin/color"><i class="fa fa-circle-o"></i> 颜色管理</a></li>
                    <li><a href="/admin/pattern"><i class="fa fa-circle-o"></i>图案管理</a></li>
                    <li><a href="/admin/size"><i class="fa fa-circle-o"></i>尺码管理</a></li>
                    <li><a href="/admin/texture"><i class="fa fa-circle-o"></i>材质管理</a></li>
                    <li><a href="/admin/express"><i class="fa fa-circle-o"></i>快递管理</a></li>
                </ul>
            </li>
            {{--<li><a href="#"><i class="fa fa-link"></i> <span>合作款管理</span></a></li>--}}
            <li class="treeview @if($action=="OrderController") active @endif ">
                <a href="#"><i class="fa fa-link"></i> <span>订单管理</span>
                    <span class="pull-right-container">
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/order"><i class="fa fa-circle-o"></i>订单列表</a></li>
                    <li><a href="/admin/code"><i class="fa fa-circle-o"></i>二维码管理</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>系统管理</span>
                    <span class="pull-right-container">
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/permissions"><i class="fa fa-circle-o"></i> 权限管理</a></li>
                    <li><a href="/admin/admin_users"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    <li><a href="/admin/roles"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>