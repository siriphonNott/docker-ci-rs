<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Load Lead</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <form role="form" id="form_lead" enctype="multipart/form-data">

                <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                    id="token">
                <input type="hidden" name="fileName" value="">

                <div class="box-body">
                    <!-- Lead Detail -->
                    <div class="lead-detail padding-10">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Campaign</label>
                                <select class="form-control ui dropdown" name="campaign" id="campaign">
                                    <option value="">-- Select Campaign --</option>
                                    <?php foreach ($campaigns as $key => $item) {
                                        echo '<option value="' . $item['id'] . '">' . $item['label'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Lead Type</label>
                                    <select class="form-control ui dropdown" name="leadType" id="leadType">
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
                                    <select class="form-control ui dropdown" name="channel" id="channel">
                                        <option value="">-- Select Channel --</option>
                                        <?php foreach ($channels as $key => $item) {
                                            echo '<option value="' . $item['id'] . '">' . $item['label'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="fileUpload">Import CSV</label>
                                <div class="input-group" name="followUp" id="followUp">
                                    <span class="file-input btn btn-success btn-file">Browse
                                        <i class="fa fa-download"></i>
                                        <input type="file" multiple="" accept=".csv" id="fileUpload" name="fileUpload"
                                            required>
                                    </span>
                                </div>
                            </div>
                            <!-- <div class="col-md-3"> 
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="asAgent" name="asAgent">
                                            <span class="text"></span> Assign to Agent 
                                        </label>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-3">
                                <div class="progress progress-sm active">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" id="progressbar"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-right">
                            <div class="col-md-12">
                                <button type="submit" value="submit" class="btn btn-primary" disabled>Submit</button>
                                <button type="button" value="cancel" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="preview">
                        <h3>Lead Preview</h3><br>
                        <table id="preview-table" class="table table-bordered table-striped">
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

                </div>
            </form>
        </div>
    </div>
</div>