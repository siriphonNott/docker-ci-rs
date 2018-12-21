<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Contact New Create</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
      <form role="form" id="form_create_contact" action="" method="POST">
      <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>" id = "token">
        <div class="box-body">

          <div class="row">
            <div class="col-md-6">
              <label>Gender</label>
              <select class="form-control" name="gender" id="gender">
                <option value="M">ชาย</option>
                <option value="F">หญิง</option>
              </select>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Title</label>
                <select class="form-control" name="title" id="title">
                  <option value="mr">นาย</option>
                  <option value="mrs">นาง</option>
                  <option value="miss">นางสาว</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="firstname" class="form-control" placeholder="Enter Firstname" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Lastname</label>
                <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Fax</label>
                <input type="number" name="fax" class="form-control" placeholder="Enter Fax">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Telephone 1</label>
                <input type="number" name="tel1" class="form-control"  value="<?php echo empty($tel_popup) ? '' : $tel_popup; ?>" placeholder="Enter Telephone1">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Telephone 2</label>
                <input type="number" name="tel2" class="form-control"   placeholder="Enter Telephone1">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" class="form-control" placeholder="Enter Company">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" placeholder="Enter Position">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Province</label>
                <input type="text" name="province" class="form-control" placeholder="Enter Province">
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
