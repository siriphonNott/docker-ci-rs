<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <button type="button" onclick="javascript:window.open('<?php echo base_url("manage/users/create "); ?>','_self')" class="btn btn-block btn-success"
          style="width: 100px;">
          <i class="fa fa-plus"></i> &nbsp;Add</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <input type="hidden" name="tel_popup" value="<?php echo (!empty($tel_popup)) ? $tel_popup : ''; ?>">
        <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>" id = "token">
        <table id="users-table" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Password</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Created At</th>
              <th>Created By</th>
              <th>Role</th>
              <th>Option</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->