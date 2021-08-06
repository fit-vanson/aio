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

                            <li class="menu-title">VietMMO</li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-package"></i> <span> App And Project <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
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
                                    @can('project-index')
                                        <li><a href="{{route('project.indexBuild')}}">Tiến trình xử lý</a></li>
                                        <li><a href="{{route('project.appChplay')}}">Quản lý APP (CHPlay)</a></li>
                                        <li><a href="{{route('project.appAmazon')}}">Quản lý APP (Amazon)</a></li>
                                        <li><a href="{{route('project.appSamsung')}}">Quản lý APP (Samsung)</a></li>
                                        <li><a href="{{route('project.appXiaomi')}}">Quản lý APP (Xiaomi)</a></li>
                                        <li><a href="{{route('project.appOppo')}}">Quản lý APP (Oppo)</a></li>
                                        <li><a href="{{route('project.appVivo')}}">Quản lý APP (Vivo)</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-receipt"></i> <span> Ga & Dev & Ads <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('gadev-index')
                                        <li><a href="{{route('gadev.index')}}">Gmail Quản lý</a></li>
                                    @endcan
                                    @can('dev-index')
                                        <li><a href="{{route('dev.index')}}">Quản lý DEV (CH-Play)</a></li>
                                    @endcan

                                    @can('dev_amazon-index')
                                        <li><a href="{{route('dev_amazon.index')}}">Quản lý DEV (Amazon)</a></li>
                                    @endcan
                                    @can('dev_samsung-index')
                                        <li><a href="{{route('dev_samsung.index')}}">Quản lý DEV (Samsung)</a></li>
                                    @endcan
                                    @can('dev_xiaomi-index')
                                        <li><a href="{{route('dev_xiaomi.index')}}">Quản lý DEV (Xiaomi)</a></li>
                                    @endcan
                                    @can('dev_oppo-index')
                                        <li><a href="{{route('dev_oppo.index')}}">Quản lý DEV (Oppo)</a></li>
                                    @endcan
                                    @can('dev_vivo-index')
                                        <li><a href="{{route('dev_vivo.index')}}">Quản lý DEV (Vivo)</a></li>
                                    @endcan

                                    @can('ga-index')
                                        <li><a href="{{route('ga.index')}}">Quản lý GA</a></li>
                                    @endcan
                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-sim"></i> <span> Quản lý Sim <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('khosim-index')
                                        <li><a href="{{route('khosim.index')}}">Quản lý Kho sim</a></li>
                                    @endcan
                                    @can('cocsim-index')
                                        <li><a href="{{route('cocsim.index')}}">Quản lý Cọc Sim</a></li>
                                    @endcan
                                    @can('hub-index')
                                        <li><a href="{{route('hub.index')}}">Quản lý Hub</a></li>
                                    @endcan
                                    @can('sms-index')
                                        <li><a href="{{route('sms.index')}}">Quản lý SMS</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-email"></i> <span>Job Auto CHplay<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('mail_manage-index')
                                        <li><a href="{{route('mail_manage.index')}}">Tài nguyên Gmail</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-bookmark-alt"></i> <span> Gmail Reg Auto<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                                <ul class="submenu">
                                    @can('mail_manage-index')
                                        <li><a href="{{route('mail_parent.index')}}">Quản lý Mail Parent</a></li>
                                    @endcan
                                    @can('mail_manage-index')
                                        <li><a href="{{route('mail_parent.indexNo')}}">Mail Parent (No Phone)</a></li>
                                    @endcan
                                    @can('mail_reg-index')
                                        <li><a href="{{route('mail_reg.index')}}">Quản lý Mail Reg</a></li>
                                    @endcan
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
