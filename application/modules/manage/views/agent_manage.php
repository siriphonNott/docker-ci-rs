<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="lead-detail padding-10">
                    <button type="button" class="btn btn-block btn-success" style="width: 100px;" data-toggle="modal"
                        data-target="#myModal"><i class="fa fa-plus"></i> &nbsp;Add</button>
                </div>
                <div class="preview" style="overflow:auto;">
                    <table id="agent-table" name="agent-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">UserID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Survey</th>
                                <th class="text-center">Section</th>
                                <th class="text-center">Team</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Detail1</th>
                                <th class="text-center">Detail2</th>
                                <th class="text-center">Detail3</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Agent Data</h3>
                </div>
            </div>

            <div class="modal-body">
                <form id="agentdataForm" method="post" class="form-horizontal" data-bv-message="This value is not valid"
                    data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                        id="token">
                    <input type="hidden" name="action" id="action" value="">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>User ID*</label>
                                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter User ID"
                                        autocomplete="off">
                                    <input type="hidden" name="idBeforeEdit" value="">
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px">
                                <div class="col-xs-6">
                                    <label>Username*</label>
                                    <input type="text" id="userUsername" name="userUsername" class="form-control"
                                        placeholder="Enter Username" autocomplete="off">
                                </div>
                                <div class="col-xs-6">
                                    <label>New Password*</label>
                                    <input type="password" name="userPassword" id="userPassword" class="form-control"
                                        placeholder="Enter Password" autocomplete="off">
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px">
                                <div class="col-xs-6">

                                    <label>Firstname*</label>
                                    <input type="text" name="userName" id="userName" class="form-control" placeholder="Enter Firstname"
                                        autocomplete="off">
                                </div>
                                <div class="col-xs-6">

                                    <label>Lastname</label>
                                    <input type="text" name="userSurname" id="userSurname" class="form-control"
                                        placeholder="Enter Lastname" autocomplete="off">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-lg-12">
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control input-sm" name="userRole" id="userRole">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2" style="margin-left: 106px">
                                <div class="form-group">
                                    <label>Survey</label>
                                    <select class="form-control input-sm" name="userSurvey" id="userSurvey">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2" style="margin-left: 106px">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select class="form-control input-sm" name="userSection" id="userSection">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-2" style="margin-right: 90px">
                                <div class="form-group">
                                    <label>Team</label>
                                    <select class="form-control input-sm" name="userTeam" id="userTeam">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <label>Position*</label>
                                <input type="text" name="userPosition" id="userPosition" class="form-control"
                                    placeholder="Enter Position" autocomplete="off">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <label>Detail1*</label>
                            <input type="text" id="userDetail1" name="userDetail1" class="form-control" placeholder="Enter Detail"
                                autocomplete="off">
                        </div>
                        <div class="col-xs-4">
                            <label>Detail2*</label>
                            <input type="text" name="userDetail2" id="userDetail2" class="form-control" placeholder="Enter Detail"
                                autocomplete="off">
                        </div>
                        <div class="col-xs-4">
                            <label>Detail3*</label>
                            <input type="text" name="userDetail3" id="userDetail3" class="form-control" placeholder="Enter Detail"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="row text-center" style="margin-top: 35px">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger closeModal" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-body-->
        </div>
        <!-- /.Modal content-->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
</div>