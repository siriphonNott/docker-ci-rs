<?php
$origins['class'] = strtolower($this->router->fetch_class());
$origins['method'] = strtolower($this->router->fetch_method());

//Define menu
$active_menu['lead'] = '';
$active_menu['loadlead'] = '';
$active_menu['leadview'] = '';
$active_menu['leadreport'] = '';

$active_menu['role_manage'] = '';
$active_menu['user_manage'] = '';
$active_menu['agent_manage'] = '';
$active_menu['masterdata_manage'] = '';

//Menu List
$leadMenuList = array(
    'loadlead',
    'leadview',
    'leadmanage',
    'leadreport',
);

$manageMenuList = array(
    'users',
    'qa',
    'agent_manage',
    'role_manage',
    'masterdata_manage'
);

//Check Menu BY Class
$active_menu[$origins['class']] = 'active';

//Sub Menu
$active_menu['manage_index'] = checkMenu('leadmanage', array('index'), $origins, true);
$active_menu['manage_phoneBlockList'] = checkMenu('leadmanage', array('phoneblocklist'), $origins, true);
$active_menu['manage_expiredlead'] = checkMenu('leadmanage', array('expiredlead'), $origins, true);

//Set Menu Open
function menu_open($menu, $origins)
{
    if(in_array($origins['class'],$menu)) {
        return 'active';
    }
    return '';
}

function checkMenu($class = null, $method = null, $origins = array(), $active_submenu = false)
{
    $active = '';
    if ($active_submenu) {
        $active = ($origins['class'] == $class && in_array($origins['method'], $method)) ? 'active' : '';
    } else {
        $active = ($origins['class'] == $class) ? 'active' : '';
    }
    return $active;
}

$active_contact  = '';
?>

<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->config->item('assets'); ?>dist/img/avatar.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    <?php echo $this->session->name; ?>
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <!-- Lead Module -->
            <?php if ($this->users_library->check_permission($this->session->role, 'LM')) {?>
            <li class="treeview <?php echo menu_open($leadMenuList, $origins); ?>">
                <a href="#">
                    <i class="fa fa-file-text-o"></i>
                    <span>Lead</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ($this->users_library->check_permission($this->session->role, 'LM_LOAD')) {?>
                    <li><a class="treeview-item <?php echo $active_menu['loadlead'];?>" href="<?php echo base_url('lead/loadLead'); ?>"><i class="fa fa-upload"></i> Load Lead</a></li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'LM_VIEW')) {?>
                    <li><a class="treeview-item <?php echo $active_menu['leadview'];?>" href="<?php echo base_url('lead/leadView'); ?>"><i class="fa fa-desktop"></i> Lead View</a></li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'LM_MANAGE')) {?>
                    <li><a class="treeview-item <?php echo $active_menu['manage_index'];?>" href="<?php echo base_url('lead/leadManage'); ?>"><i class="fa fa-cog"></i> Lead Manage</a></li>
                    <li><a class="treeview-item <?php echo $active_menu['manage_expiredlead'];?>" href="<?php echo base_url('lead/expiredLead'); ?>"><i class="fa fa-clock-o"></i> Expired Lead</a></li>
                    <li><a class="treeview-item <?php echo $active_menu['manage_phoneBlockList'];?>" href="<?php echo base_url('lead/phoneBlockList'); ?>"><i class="fa fa-phone-square"></i> Phone Block List</a></li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'LM_REPORT')) {?>
                    <li><a class="treeview-item <?php echo $active_menu['leadreport'];?>" href="<?php echo base_url('lead/leadReport'); ?>"><i class="fa fa-bar-chart"></i> Lead Report</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if ($this->users_library->check_permission($this->session->role, 'MM')) {?>
            <li class="treeview <?php echo menu_open($manageMenuList ,$origins); ?> ">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ($this->users_library->check_permission($this->session->role, 'MM_USER')) {?>
                    <li>
                        <a class="treeview-item <?php echo $active_menu['user_manage']; ?>" href="<?php echo base_url('manage/users'); ?>">
                            Users
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'MM_ROLE')) {?>
                    <li>
                        <a class="treeview-item <?php echo $active_menu['role_manage']; ?>" href="<?php echo base_url('manage/roles'); ?>">
                            Roles
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'MM_MASTER')) {?>
                    <li>
                        <a class="treeview-item <?php echo $active_menu['masterdata_manage']; ?>" href="<?php echo base_url('manage/masterdata'); ?>">
                        Master Data
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($this->users_library->check_permission($this->session->role, 'MM_AGENT')) {?>
                    <li>
                        <a class="treeview-item <?php echo $active_menu['agent_manage']; ?>" href="<?php echo base_url('manage/agentmanage'); ?>">
                            Agent Management
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php }?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->