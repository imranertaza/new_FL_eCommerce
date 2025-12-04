<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Geo Zone Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Geo Zone Update</li>
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
                        <h3 class="card-title">Geo Zone Update</h3>
                    </div>
                    <div class="col-md-4"> </div>
                    <div class="col-md-12" style="margin-top: 10px" id="mess">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('geo_zone_update_action')?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="geo_zone_name" class="form-control" placeholder="Zone name" value="<?php echo $geo_zone->geo_zone_name;?>" required>
                                <input type="hidden" name="geo_zone_id" value="<?php echo $geo_zone->geo_zone_id;?>" required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="geo_zone_description" class="form-control" ><?php echo $geo_zone->geo_zone_description;?></textarea>
                            </div>
                        </div>

                        <div class="col-md-8 " style="border-left: 1px solid #e1e1e1;">
                            <div class="col-md-12" >
                                <a href="javascript:void(0)" onclick="add_zone_detail();" class="btn btn-sm btn-primary">+ Add Zone</a>
                            </div>
                            <div class="col-md-12" >
                                <div id="new_zone" class="row">
                                    <?php
                                    $i = 1;
                                    $j = 1;
                                    $k = 1;
                                        foreach ($geo_zone_detail as $val){
                                    ?>
                                    <div class="col-md-12 mt-3" id="new_<?php echo $i++;?>" >
                                        <select class="form-input" name="country_id[]" onchange="zoneVal(this.value,'<?php echo $j++;?>' )" style="padding: 3px; width: 40%;" required>
                                            <option value=''>Please select</option>
                                            <?php echo getListInOption($val->country_id, 'country_id', 'name', 'cc_country'); ?>
                                        </select>
                                        <select class="form-input" name="zone_id[]" id="valId_<?php echo $k++;?>" style="padding: 3px; width: 40%;" required>
                                            <option value="">Please select</option>
                                            <option value="0" <?php echo ($val->zone_id == 0)?'selected':'';?> >All Zone</option>
                                            <?php echo getIdByListInOption($val->zone_id, 'zone_id', 'name', 'cc_zone', 'country_id', $val->country_id);?>
                                        </select>
                                        <input type="hidden" value="<?php echo $val->geo_zone_details_id;?>" name="geo_zone_details_id[]">
                                        <a href="javascript:void(0)" onclick="remove_option(this),deleteZone(<?php echo $val->geo_zone_details_id;?>)" class="btn  btn-danger" style="margin-top: -5px; width: 5%;">X</a>
                                    </div>
                                    <?php } ?>

                                </div>
                                <input type="hidden" value="<?php echo count($geo_zone_detail)?>" id="total_zone">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary" >Update</button>
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
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function add_zone_detail() {
        <?php $dat = getListInOption('', 'country_id', 'name', 'cc_country'); ?>
        var data = `'<?php echo $dat; ?>'`;
        var new_chq_no = parseInt($('#total_zone').val()) + 1;
        var new_input = "<div class='col-md-12 mt-3' id='new_" + new_chq_no +
            "' ><select class='form-input' name='country_id[]' onchange='zoneVal(this.value," + new_chq_no +
            " )'  style='padding: 3px;width: 40%;' required><option value=''>Please select</option>" + data +
            "</select> <select class='form-input' name='zone_id[]' id='valId_" + new_chq_no +
            "' style='padding: 3px;width: 40%;' required><option value=''>Please select</option></select><input type='hidden' value='' name='geo_zone_details_id[]'> <a href='javascript:void(0)' onclick='remove_option(this)' class='btn btn-danger' style='margin-top: -5px;width: 5%;'>X</a></div>";

        $('#new_zone').append(new_input);
        $('#total_zone').val(new_chq_no);
    }

    function remove_option(data) {
        $(data).parent().remove();
    }
    function zoneVal(val,idview){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('get_zone_value') ?>",
            data: {
                [csrfName]: csrfHash,
                country_id: val
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#valId_" + idview).html(data);
                // alert(data);
            }

        });
    }

    function deleteZone(details_id){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('geo_zone_detail_delete') ?>",
            data: {
                [csrfName]: csrfHash,
                geo_zone_details_id: details_id
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#mess").html(data);
            }

        });
    }

</script>
<?= $this->endSection() ?>