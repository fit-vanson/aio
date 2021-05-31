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
                                    <li><a href="{{route('da.index')}}">Quản lý Dự án</a></li>
                                    <li><a href="{{route('project.index')}}">Quản lý Project</a></li>
                                    <li><a href="{{route('template.index')}}">Quản lý Template</a></li>
                                    <li><a href="{{route('gadev.index')}}">Quản lý Tài khoản</a></li>
                                    <li><a href="{{route('dev.index')}}">Quản lý DEV</a></li>
                                    <li><a href="{{route('ga.index')}}">Quản lý Ga</a></li>
                                    <li><a href="{{route('user.index')}}">Quản lý User</a></li>

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
