<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Phone Block List</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
                <input type="hidden" name="tel_popup" value="<?php echo (!empty($tel_popup)) ? $tel_popup : ''; ?>">
                <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                    id="token">

                <div class="lead-detail padding-10">
                    <button type="button" class="btn btn-block btn-success" style="width: 100px;" data-toggle="modal"
                        data-target="#myModal"><i class="fa fa-plus"></i> &nbsp;Add</button>
                </div>

                <div class="lead-detail padding-10">

                    <table id="phoneList-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Phone Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.box-box-primary -->
    </div>
</div>

<!-- Modal Create-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Phone Block List</h4>
            </div>
            <div class="modal-body">

                <form id="phoneListForm" method="post" class="form-horizontal" data-bv-message="This value is not valid"
                    data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" name="action" value="">
                    <input type="hidden" name="id" value="">

                    <!-- phone mask -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Telephone</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input id="phoneNumber" name="phoneNumber" type="text" class="form-control"
                                    data-inputmask='"mask": "(999)999-9999"' data-mask>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>

                    <div class="row text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn  btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-body -->
        </div>
    </div>
</div>