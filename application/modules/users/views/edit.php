<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
      <form role="form" id="form-user-edit" method="POST">
        <input type="hidden" value="<?php echo !(empty($id)) ? $id : ''; ?>" name="id" />
        <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
          id="token">
        <div class="box-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Enter Username" value="<?php echo $username; ?>" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" disabled placeholder="Enter Confirm Password" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="firstname" class="form-control" placeholder="Enter Firstname" value="<?php echo $firstname; ?>"
                  autocomplete="off">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Lastname</label>
                <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname" value="<?php echo $lastname; ?>" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Role</label>
                <?php
echo form_dropdown('role', $options, $role, 'class="form-control"'); ?>
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label>Created By</label>
                <input type="text" class="form-control" disabled value="<?php echo $created_by_name; ?>" >
              </div>
            </div>

          </div>

          <!-- /.box-body -->

          <div class="box-footer">
            <a href="<?php echo base_url("manage/users "); ?>" class="btn btn-warning">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
      </div>
    </div>
  </div>