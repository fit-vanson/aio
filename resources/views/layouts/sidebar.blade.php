      <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="slimscroll-menu" id="remove-scroll">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu" id="side-menu">
                            <li class="menu-title">Main</li>
                            <li>
                                <a href="{{route('index')}}" class="waves-effect">
                                    <i class="ti-home"></i><span> Trang chủ </span>
                                </a>
                            </li>

                            <li class="menu-title">Quản trị</li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span> Quản trị backend <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('du_an-index')
                                    <li><a href="{{route('da.index')}}">Quản lý Dự án</a></li>
                                    @endcan
                                    @can('project-index')
                                    <li><a href="{{route('project.index')}}">Quản lý Project</a></li>
                                    @endcan
                                    @can('template-index')
                                    <li><a href="{{route('template.index')}}">Quản lý Template</a></li>
                                    @endcan
                                    @can('gadev-index')
                                    <li><a href="{{route('gadev.index')}}">Quản lý Tài khoản</a></li>
                                    @endcan
                                    @can('dev-index')
                                    <li><a href="{{route('dev.index')}}">Quản lý DEV</a></li>
                                    @endcan
                                    @can('ga-index')
                                    <li><a href="{{route('ga.index')}}">Quản lý Ga</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-archive"></i> <span> Quản lý Sim <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
{{--                                    @can('user-index')--}}
                                        <li><a href="{{route('khosim.index')}}">Quản lý Kho sim</a></li>
{{--                                    @endcan--}}
{{--                                    @can('vai_tro-index')--}}
                                        <li><a href="{{route('cocsim.index')}}">Quản lý Cọc Sim</a></li>
{{--                                    @endcan--}}
{{--                                    @can('phan_quyen-index')--}}
                                        <li><a href="{{route('sms.index')}}">Quản lý SMS</a></li>
{{--                                    @endcan--}}
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-archive"></i> <span> Quản trị phân quyền <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('user-index')
                                    <li><a href="{{route('user.index')}}">User</a></li>
                                    @endcan
                                    @can('vai_tro-index')
                                    <li><a href="{{route('role.index')}}">Vai trò</a></li>
                                    @endcan
                                    @can('phan_quyen-index')
                                    <li><a href="{{route('permission.index')}}">Phân quyền</a></li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->
