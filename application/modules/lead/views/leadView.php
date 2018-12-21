<div class="row">
    <div class="col-lg-4">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-folder-open-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Lead</span>
                <span class="info-box-number" id="totalLead"></span>
                <div class="progress">
                    <div class="progress-bar" id="progress-totalLead"></div>
                </div>
                <!-- <span class="progress-description" id="increase-totalLead">

                </span> -->
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-folder-open-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Open</span>
                <span class="info-box-number" id="leadOpen"></span>

                <div class="progress">
                    <div class="progress-bar" id="progress-open"></div>
                </div>
                <span class="progress-description" id="increase-open">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-check-circle-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Success</span>
                <span class="info-box-number" id="leadSuccess"></span>

                <div class="progress">
                    <div class="progress-bar" id='progress-success'></div>
                </div>
                <span class="progress-description" id='increase-success'>

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Follow Up</span>
                <span class="info-box-number" id="leadFollow"></span>

                <div class="progress">
                    <div class="progress-bar" id='progress-follow'></div>
                </div>
                <span class="progress-description" id="increase-follow">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-close"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Drop</span>
                <span class="info-box-number" id="leadDrop"></span>

                <div class="progress">
                    <div class="progress-bar" id="progress-drop"></div>
                </div>
                <span class="progress-description" id="increase-drop">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-exclamation"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Couldn't Reach</span>
                <span class="info-box-number" id="leadCouldNotReach"></span>

                <div class="progress">
                    <div class="progress-bar" id="progress-leadCouldNotReach"></div>
                </div>
                <span class="progress-description" id="increase-leadCouldNotReach">

                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
</div>
<!-- end dashboard -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead View</h3>
            </div>
            <!-- /.box-header -->
            <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                id="token">
            <div class="box-body">
                <!-- Lead Detail -->
                <div class="row">
                    <div class="col-md-8">

                        <button class="btn btn-primary buttonSearch" onclick="searchCallResult('leadNew');"><i class="fa fa-plus"
                                aria-hidden="true"></i> Lead New</button>
                        <button class="btn btn-warning buttonSearch" onclick="searchCallResult('follow');"><i class="fa fa-phone"></i>
                            Follow</button>
                        <?php if ($this->session->role == '1' || $this->session->role == '2') { ?>
                        <button class="btn btn-success buttonSearch" onclick="searchCallResult('success');"><i class="fa fa-check "
                                aria-hidden="true"></i> SUCCESS</button>
                        <button class="btn btn-danger buttonSearch" onclick="searchCallResult('drop');"><i class="fa fa-close"></i>
                            Drop</button>
                        <button class="btn btn-danger buttonSearch" onclick="searchCallResult('couldNotReach');"><i
                                class="fa fa-exclamation"></i>
                            COULDN'T
                            REACH</button>
                        <?php 
                    } ?>
                        <button class="btn btn-info" id="clear" disabled="disabled" onclick="searchCallResult('clear')"><i
                                class="fa fa-recycle" aria-hidden="true"></i> Clear</button>
                    </div>
                    <div class="col-md-12">
                        <div class="preview">
                            <table id="view-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>callResult</center>
                                        </th>
                                        <th>
                                            <center>No</center>
                                        </th>
                                        <th>
                                            <center>Call Result</center>
                                        </th>
                                        <th>
                                            <center>Campaign</center>
                                        </th>
                                        <th>
                                            <center>Expired Date</center>
                                        </th>

                                        <th>
                                            <center>Title</center>
                                        </th>
                                        <th>
                                            <center>Firstname</center>
                                        </th>
                                        <th>
                                            <center>Lastname</center>
                                        </th>
                                        <th>
                                            <center>Email1</center>
                                        </th>
                                        <th>
                                            <center>Tel1</center>
                                        </th>
                                        <th>
                                            <center>Action</center>
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
</div>