<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Report</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <div class="box-body">
                <form role="form" id="form_report" enctype="multipart/form-data">

                    <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                        id="token">

                    <div class="lead-detail padding-10">
                        <!-- row input search -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date From:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datefrom" name="datefrom">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date To:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="dateto" name="dateto">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Agent</label>
                                    <select class="form-control ui dropdown" name="assignedTo" id="assignedTo">
                                        <option value="">-- Select Agent --</option>
                                        <?php foreach ($agent as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['firstname'] . ' ' . $item['lastname'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Call Result</label>
                                    <select class="form-control ui dropdown" name="callResult" id="callResult">
                                        <option value="">-- Select CallResult --</option>
                                        <?php foreach ($callResult as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- row input search -->

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Campaign</label>
                                    <select class="form-control ui dropdown" name="campaignId" id="campaignId">
                                        <option value="">-- Select Campaign --</option>
                                        <?php foreach ($campaigns as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['label'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Lead Type</label>
                                    <select class="form-control ui dropdown" name="leadTypeId" id="leadTypeId">
                                        <option value="">-- Select Lead Type --</option>
                                        <?php foreach ($leadTypes as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['label'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Channel</label>
                                    <select class="form-control ui dropdown" name="channelId" id="channelId">
                                        <option value="">-- Select Channel --</option>
                                        <?php foreach ($channels as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['label'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row text-right">
                            <div class="col-md-12">
                                <button type="submit" value="submit" class="btn btn-primary"><i class="fa fa-search"
                                        aria-hidden="true"></i> Search</button>
                                <button type="clear" value="clear" class="btn btn-warning"><i class="fa fa-filter"
                                        aria-hidden="true"></i> Clear Filter</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="buttons"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row lead-detail -->
                </form>

                <div class="preview" style="overflow:auto;">
                    <table id="report-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <center>No</center>
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
                                    <center>Birthday</center>
                                </th>
                                <th>
                                    <center>Email1</center>
                                </th>
                                <th>
                                    <center>Email2</center>
                                </th>
                                <th>
                                    <center>Tel1</center>
                                </th>
                                <th>
                                    <center>Tel2</center>
                                </th>
                                <th>
                                    <center>Tel3</center>
                                </th>
                                <th>
                                    <center>Address</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
                <!-- /.preview -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>