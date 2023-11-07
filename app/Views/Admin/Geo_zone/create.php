<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Geo Zone create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Geo Zone create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Geo Zone create</h3>
                    </div>
                    <div class="col-md-4"> </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('geo_zone_create_action')?>" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="geo_zone_name" class="form-control" placeholder="Zone name" required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="geo_zone_description" class="form-control" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-8 " style="border-left: 1px solid #e1e1e1;">
                            <div class="col-md-12" >
                                <a href="javascript:void(0)" onclick="add_zone_detail();" class="btn btn-sm btn-primary">+ Add Zone</a>
                            </div>
                            <div class="col-md-12" >
                                <div id="new_zone" class="row">
                                    <div class="col-md-12 mt-3" id="new_1" >
                                        <select class="form-input" name="country_id[]" onchange="zoneVal(this.value,'1' )" style="padding: 3px; width: 40%;" required>
                                            <option value=''>Please select</option>
                                            <?php echo getListInOption('', 'country_id', 'name', 'cc_country'); ?>
                                        </select>
                                        <select class="form-input" name="zone_id[]" id="valId_1" style="padding: 3px; width: 40%;" required>
                                            <option value="">Please select</option>
                                        </select>
                                        <a href="javascript:void(0)" onclick="remove_option(this)" class="btn  btn-danger" style="margin-top: -5px; width: 5%;">X</a>
                                    </div>
                                </div>
                                <input type="hidden" value="1" id="total_zone">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary" >Create</button>
                            <a href="<?php echo base_url('geo_zone')?>" class="btn btn-danger" >Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>