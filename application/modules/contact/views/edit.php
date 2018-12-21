<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Contact New Create</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <form role="form" id="form_edit_contact" method="POST">
          <input type="hidden" value="<?php echo !(empty($id)) ? $id : ''; ?>" name="id" />
          <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>" id = "token">
          <div class="box-body">

            <div class="row">
              <div class="col-md-6">
                <label>Gender</label>
                <?php
$options = array('M' => 'ชาย', 'F' => 'หญิง');
echo form_dropdown('gender', $options, $gender, 'class="form-control"');
?>

              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Title</label>
                  <?php
$options = array('mr' => 'นาย', 'mrs' => 'นาง', 'miss' => 'นางสาว');
echo form_dropdown('title', $options, $title, 'class="form-control"');
?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" name="firstname" class="form-control" placeholder="Enter Firstname" value="<?php echo $firstname; ?>" required>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname" value="<?php echo $lastname; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?php echo $email; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Fax</label>
                  <input type="number" name="fax" class="form-control" placeholder="Enter Fax" value="<?php echo $fax; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Telephone 1</label>
                  <input type="number" name="tel1" class="form-control" placeholder="Enter Telephone1" value="<?php echo $tel1; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Telephone 2</label>
                  <input type="number" name="tel2" class="form-control" placeholder="Enter Telephone1" value="<?php echo $tel2; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Company</label>
                  <input type="text" name="company" class="form-control" placeholder="Enter Company" value="<?php echo $company; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Position</label>
                  <input type="text" name="position" class="form-control" placeholder="Enter Position" value="<?php echo $position; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Province</label>
                  <input type="text" name="province" class="form-control" placeholder="Enter Province" value="<?php echo $province; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <!-- <div class="form-group">
                <label>Visit</label>
                <input name="visit" class="form-control" value="1" disabled>
              </div> -->
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <a href="<?php echo base_url("contact"); ?>" class="btn btn-warning">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>