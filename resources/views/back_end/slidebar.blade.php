  <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.html" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>

                          
                        </li>

                  
                 
                
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-outline"></i><span class="hide-menu">Members </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{ url('admin/show-members') }}" class="sidebar-link"><i class="mdi mdi-account-outline"></i><span class="hide-menu"> Show Members</span></a></li>
                                <li class="sidebar-item"><a href="{{ url('admin/add-member') }}" class="sidebar-link"><i class="mdi mdi-account-plus"></i><span class="hide-menu"> Add Member</span></a></li>
                             
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>