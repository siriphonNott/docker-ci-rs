<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
          id="token">
        <div class="preview" style="overflow:auto;">
          <table id="agentTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" rowspan="2" style="vertical-align: middle;">Role</th>
                <?php foreach ($headerList as $key => $value) {
                    $name = $key;
                    if(array_key_exists($key, $permissionList)) {
                        $name = $permissionList[$key]['label'];
                    } 
                    $count = count($value);?>
                    <th colspan="<?php echo $count ?>" class="text-center">
                    <?php echo $name ?>
                </th>
                <?php }?>
              </tr>
              <tr>
                <?php foreach ($headerList as $key => $value) {
                        foreach ($value as $key => $value) {?>
                <th class="text-center">
                  <?php echo $value ?>
                </th>
                <?php }}?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($roleList as $role_id => $role_name) {
                $permissionData = isset($rolePermissionList[$role_id])?$rolePermissionList[$role_id]:array();
                $permissions_code_list =  isset($permissionData['permissions_code'])?$permissionData['permissions_code']:array();
                ?>
              <tr>
                <td class="text-center"><b>
                    <?php echo $role_name;?></b></td>
                <?php foreach ($headerList as $headerKey => $headerValue) {
                    foreach ($headerValue as $key => $value) {
                        $classfa = "fa fa-circle-o";
                        $isPermission = 0;
                        $permission_code = ($headerKey == $value)?$headerKey:$headerKey.'_'.$value;
                        
                        $permission_id =  $permissionList[$permission_code]['id'];
                        $name = "role-".$role_id."-permission-".$permission_id."-".$permission_code;
                        $param = "$role_id,$permission_id,'$name'";

                        if(in_array($permission_code , $permissions_code_list)) {
                            $classfa = "fa fa-check-circle";
                            $isPermission = 1;
                        }
                        ?>
                <td name="<?php echo $name;?>" class="text-center pointer" isPermission="<?php echo $isPermission;?>"
                  onclick="setPermission(<?php echo $param;?>)"><i class="<?php echo $classfa; ?>" aria-hidden="true"></i></td>
                <?php }}?>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->