<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Detail</h3>
            </div>
            <div class="box-body">
                <form role="form" id="form_lead_update" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                        id="token">
                    <div class="form-title title-mid">Job Detail</div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <input type="hidden" class="form-control" id="cus_id" name="id" disabled="" value="<?php echo !(empty($cusId)) ? $cusId : ''; ?>">
                                <input type="hidden" class="form-control" id="ext" name="id" disabled="" value="<?php echo !(empty($ext)) ? $ext : ''; ?>">
                                <div class="col-md-4">
                                    <label>Campaign</label>
                                    <select class="form-control ui dropdown" id="campaign" name='campaignId'>
                                        <!-- <option value="">-- Select campaign --</option> -->

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Lead Type</label>
                                    <select class="form-control ui dropdown" id="leadType" name="leadTypeId">

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Channel</label>
                                    <select class="form-control ui dropdown" id="channel" name="channelId">

                                    </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Call Result</label>
                                    <select class="form-control ui dropdown" id="callResult" name="callResult">
                                        <option value="">-- Select Call Result --</option>
                                    </select>
                                </div>
                                <?php if ($this->session->role == '1' || $this->session->role == '2') { ?>
                                <div class="col-md-3">
                                    <label>Assign To</label>
                                    <select class="form-control ui dropdown" id="assignTo" name="assignedTo">
                                    </select>
                                </div>
                                <?php 
                            } ?>
                                <div class='col-md-3'>
                                    <input type="checkbox" id="checkFollow" value=''>&nbsp;&nbsp;
                                    <label> Follow Up</label>
                                    <div class="input-group dateFollow">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="follow_date" name="followDate"
                                            value="<?php echo !(empty($followDate)) ? $followDate : ''; ?>">
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="row text-right">
                                <div class="col-md-12">
                                    <button type="button" value="Submit" id="updateLeadDetail" class="btn btn-primary">Update</button>
                                    <button type="button" value="Back" class="btn btn-warning" onclick="window.location.href='<?php echo base_url('lead/leadView'); ?>'">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-title title-mid">Customer Information</div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="cusFirstName" name="firstname" value="<?php echo !(empty($firstname)) ? $firstname : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="cusLastName" name="lastname" value="<?php echo !(empty($lastname)) ? $lastname : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>วันเดือนปี</label>
                                    <input type="text" class="form-control" id="birthDay" name="birthday" value="<?php echo !(empty($birthday)) || ($birthday != '0000-00-00 00:00:00') ? $birthday : ''; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tel.1</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control clsNumber" id="cusTel1" name="tel1"
                                                value="<?php echo !(empty($tel1)) ? $tel1 : ''; ?>">
                                            <div class="input-group-addon btn-avail-call flag_call" onclick="call('#cusTel1');">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Tel.2</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control clsNumber" id="cusTel2" name="tel2"
                                            value="<?php echo !(empty($tel2)) ? $tel2 : ''; ?>">
                                        <div class="input-group-addon btn-avail-call flag_call" onclick="call('#cusTel2');">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Tel.3</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control clsNumber" id="cusTel3" name="tel3"
                                            value="<?php echo !(empty($tel3)) ? $tel3 : ''; ?>">
                                        <div class="input-group-addon btn-avail-call flag_call" onclick="call('#cusTel3');">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Email 1</label>
                                    <input type="text" class="form-control clsEmail" id="cusEmail1" name="email1" value="<?php echo !(empty($email1)) ? $email1 : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Email 2</label>
                                    <input type="text" class="form-control clsEmail" id="cusEmail2" name="email2" value="<?php echo !(empty($email2)) ? $email2 : ''; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-8">
                                    <label>Detail</label>
                                    <textarea rows="8" class="form-control" placeholder="" name="comment" id="comment"><?php echo !(empty($comment)) ? $comment : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                    <div class="form-title title-mid">Historical Call</div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <table id="histocal-call-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No</center>
                                        </th>
                                        <th>
                                            <center>Call Date</center>
                                        </th>
                                        <th>
                                            <center>Extension</center>
                                        </th>
                                        <th>
                                            <center>Customer Phone Number</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
            </div>
        </div>
    </div>
</div>