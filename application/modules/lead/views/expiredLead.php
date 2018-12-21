<!-- table -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Allocation (Lead Expire)</h3>
                <button class="btn btn-primary pull-right" id="reallocate">Reallocation</button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                            id="token">
                        <div class="preview">
                            <table id="leadExpire-table" class="table table-bordered table-striped">
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
                                            <center>Call Result</center>
                                        </th>
                                        <th>
                                            <center>Expired Date</center>
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