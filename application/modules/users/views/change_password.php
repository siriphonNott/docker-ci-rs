<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border text-center">
        <h3 class="box-title ">Change Password</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
		<form role="form" id="change_password" method="POST">
					<input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>" id="token">
        	<div class="box-body">

					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="form-group">
							<label>New Password</label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="form-group">
								<label>Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control" disabled placeholder="Enter Confirm Password" autocomplete="off">
							</div>
						</div>
        			</div>	
					<div class="box-footer text-center">
						<a href="<?php echo base_url("contact "); ?>" class="btn btn-warning">Back</a>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
			</div>
 		</form>
 	</div>
 </div>
</div>
