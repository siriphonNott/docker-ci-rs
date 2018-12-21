<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Transfer</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <form role="form" id="form_lead" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo !(empty($csrf['name'])) ? $csrf['name'] : ''; ?>" value="<?php echo !(empty($csrf['hash'])) ? $csrf['hash'] : ''; ?>"
                    id="token">
                <div class="box-body">
                    <!-- Lead Detail -->
                    <div class="lead-detail padding-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label>From</label>
                                <select class="ui search fluid dropdown" multiple="" name="srcTransfer" id="srcTransfer"
                                    required="">
                                    <!-- <option value="">--- Select ---</option> -->
                                </select>
                                <div class="ui toggle checkbox" id="selectallSrc">
                                    <input type="checkbox" id="selectallSrc">
                                    <label>Select all</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>To</label>
                                <select class="ui search fluid dropdown" multiple="" name="desTransfer" id="desTransfer"
                                    required="">
                                    <!-- <option value="">--- Select ---</option> -->
                                </select>
                                <div class="ui toggle checkbox" id="selectallDes">
                                    <input type="checkbox" id="">
                                    <label>Select all</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Call Result</label>
                                    <select class="ui search fluid dropdown" multiple="" name="resultCall" id="resultCall"
                                        required="">
                                        <!-- <option value="">--- Select ---</option>                     -->
                                    </select>
                                    <div class="ui toggle checkbox" id="selectAllResultCall">
                                        <input type="checkbox" id="">
                                        <label>Select all</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--row-->
                        <div class="row text-right">
                            <div class="col-md-12">
                                <button type="submit" value="submit" id="tranfer" class="btn btn-primary">Transfer</button>
                                <button type="button" value="cancel" class="btn btn-warning" onclick="location.reload();">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="preview nobody"></div>

                </div>
            </form>
        </div>
    </div>
</div>


<!-- table -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Allocation (New Lead)</h3>
                <button class="btn btn-primary pull-right" id="allocate">Allocation</button>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="preview">
                            <table id="leadNotAllocate-table" class="table table-bordered table-striped">
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