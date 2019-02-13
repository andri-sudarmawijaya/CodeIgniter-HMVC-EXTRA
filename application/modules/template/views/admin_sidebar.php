<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">Welcome: <?= $logged_user->username ?></p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item <?= active_status($this->uri->segment(1), 'admin', " active ") ?>" href="<?= base_url('admin') ?>">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="<?= base_url() ?>" target="_blank">
                <i class="app-menu__icon fa fa-windows"></i>
                <span class="app-menu__label">View Public</span>
            </a>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-th-list"></i>
                <span class="app-menu__label">Modules</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu"> 
                <li><a class="treeview-item <?= active_status($this->uri->segment(1), 'user', " active ") ?>"
                       href="<?= base_url('user/manage') ?>">
                        <i class="icon fa fa-users"></i> Manage Users</a>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-th-list"></i>
                <span class="app-menu__label">Settings</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item <?= active_status($this->uri->segment(2), '#', " active ") ?>"
                       href="<?= base_url('#') ?>">
                        <i class="icon fa fa-wrench"></i> Some settings link</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
