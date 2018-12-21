<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#list" data-toggle="tab">Master Data List</a></li>
                        <li><a href="#manage" data-toggle="tab">Master Data Manage</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="list">
                            <div class="lead-detail padding-10">
                                <button type="button" class="btn btn-block btn-success" style="width: 100px;"
                                    data-toggle="modal" data-target="#modalList"><i class="fa fa-plus"></i> &nbsp;Add</button>
                            </div>
                            <div class="lead-detail padding-10">
                                <table id="masterdataList-table" name="masterdataList-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="manage">
                            <div class="lead-detail padding-10">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="sort" class="col-sm-2 control-label"> Title :</label>
                                        <div class="col-sm-3">
                                            <select class="form-control ui dropdown" name="masterdataList" id="masterdataList">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-detail padding-10">
                                <button type="button" class="btn btn-block btn-success" style="width: 100px;"
                                    data-toggle="modal" data-target="#modalManage" disabled><i class="fa fa-plus"></i>
                                    &nbsp;Add</button>
                            </div>

                            <div class="lead-detail padding-10">
                                <table id="masterdataManage-table" name="masterdataManage-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- Modal Create Master Data List-->
<div class="modal fade" id="modalList" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Master Data List</h4>
            </div>
            <div class="modal-body">

                <form id="masterdataListForm" method="post" class="form-horizontal" data-bv-message="This value is not valid"
                    data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <!-- <input type="hidden" name="action" value=""> -->
                    <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                        id="token">
                    <input type="hidden" name="action" id="action" value="">
                    <input type="hidden" name="id" value="">

                    <div class="form-group">
                        <label for="label" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="label" name="label">
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger closeModal" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-body -->
        </div>
    </div>
</div>

<!-- Modal Create Master Data Manage-->
<div class="modal fade" id="modalManage" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Master Data Manage</h4>
            </div>
            <div class="modal-body">

                <form id="masterdataManageForm" method="post" class="form-horizontal" data-bv-message="This value is not valid"
                    data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                        id="token">
                    <input type="hidden" name="action" value="">
                    <input type="hidden" name="id" value="">

                    <div class="form-group">
                        <label for="labelManage" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="labelManage" name="labelManage">
                        </div>
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