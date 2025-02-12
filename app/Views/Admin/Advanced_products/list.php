<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bulk Edit Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Bulk Edit Product List</li>
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
                        <div class="col-md-2">
                            <h3 class="card-title">Bulk Edit Product List</h3><br>

                        </div>
                        <div class="col-md-10">
                            <?php $modules = modules_access();?>
                            <a href="<?php echo base_url('product_create') ?>" class="btn btn-primary  btn-xs float-right "><i class="fas fa-plus"></i> Add</a>
                            <a class="btn btn-xs btn-info float-right mr-2" data-toggle="collapse" href="#collapseProduct" role="button" aria-expanded="false" aria-controls="collapseProduct">Settings</a>

                            <form id="multiActionForm" action="<?= base_url('bulk_product_multi_delete')?>" method="post">
                            <button type="submit" formaction="<?= base_url('bulk_product_cpoy')?>" class="btn btn-secondary btn-xs float-right mr-2"><i class="nav-icon fas fa-copy"></i> Copy</button>
                            <?php if($modules['multi_delete'] == '1' ){ ?>
                            <button type="submit" class="btn btn-danger btn-xs float-right mr-2"><i class="fas fa-trash"></i> Multi delete</button>
                            <?php } ?>
                            <?php if($modules['multi_option'] == '1' ){ ?>
                            <button type="submit" formaction="<?php echo base_url('bulk_product_multi_option_edit'); ?>" class="btn btn-primary btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi option edit</button>
                            <?php } ?>
                            <?php if($modules['multi_attribute'] == '1' ){ ?>
                            <button type="submit" formaction="<?php echo base_url('bulk_product_multi_attribute_edit'); ?>" class="btn btn-info btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi attribute edit</button>
                            <?php } ?>
                            <?php if($modules['multi_category'] == '1' ){ ?>
                                <button type="submit" formaction="<?php echo base_url('bulk_product_multi_category_edit'); ?>" class="btn btn-success btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi category edit</button>
                            <?php } ?>
                            <?php if(modules_key_by_access('multi_price') == '1' ){ ?>
                                <button type="submit" formaction="<?php echo base_url('bulk_product_multi_price_edit'); ?>" class="btn btn-info btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi price edit</button>
                            <?php } ?>
                            </form>
                            <a href="<?php echo base_url('products') ?>" class="btn btn-danger float-right mr-2 btn-xs" >Back</a>
                        </div>
                        <div class="col-md-12" id="message" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                            endif; ?>
                            <span id="mess" style="display: none"><div class="alert alert-success alert-dismissible" role="alert">Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="collapse" id="collapseProduct">
                        <div class="card card-body d-block border">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="id" class="form-check-input" oninput="bulk_status('id')"
                                    id="check_1" checked="">
                                <label class="form-check-label" for="check_1">
                                    Id </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="image" class="form-check-input" onclick="bulk_status('image')" id="check_10" checked="">
                                <label class="form-check-label" for="check_10"> Image </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="name" class="form-check-input" onclick="bulk_status('name')"
                                    id="check_2" checked="">
                                <label class="form-check-label" for="check_2">
                                    Name </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="model" class="form-check-input" onclick="bulk_status('model')"
                                    id="check_3" checked="">
                                <label class="form-check-label" for="check_3">
                                    Model </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="quantity" class="form-check-input"
                                    onclick="bulk_status('quantity')" id="check_4" checked="">
                                <label class="form-check-label" for="check_4">
                                    Quantity </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category" class="form-check-input"
                                    onclick="bulk_status('category')" id="check_5" checked="">
                                <label class="form-check-label" for="check_5">
                                    Category </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="price" class="form-check-input" onclick="bulk_status('price')"
                                    id="check_6" checked="" >
                                <label class="form-check-label" for="check_6">
                                    Price </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="status" class="form-check-input"
                                    onclick="bulk_status('status')" id="check_7" checked="" >
                                <label class="form-check-label" for="check_7">
                                    Status </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="featured" class="form-check-input"
                                    onclick="bulk_status('featured')" id="check_8" checked="" >
                                <label class="form-check-label" for="check_8">
                                    Featured </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="optionrow" class="form-check-input"
                                       onclick="bulk_status('optionrow')" id="check_14" checked="" >
                                <label class="form-check-label" for="check_14">
                                    Option </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="meta_title" class="form-check-input"
                                       onclick="bulk_status('meta_title')" id="check_11"  >
                                <label class="form-check-label" for="check_11">
                                    Meta Title </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="meta_keyword" class="form-check-input"
                                       onclick="bulk_status('meta_keyword')" id="check_12"  >
                                <label class="form-check-label" for="check_12">
                                    Meta Keyword </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="meta_description" class="form-check-input"
                                       onclick="bulk_status('meta_description')" id="check_13"  >
                                <label class="form-check-label" for="check_13">
                                    Meta Description </label>
                            </div>


                        </div>
                    </div>
                    <div id="tablereload">
                        <form id="tableForm" action="<?php echo base_url('bulk_edit_products')?>" method="GET" >
                            <div class="row mb-3">
                                <div class="col-md-2 mx-auto">

                                    <label class="d-flex p-1 tab-lab">
                                        Show
                                        <select name="length" class="tables_length custom-select-sm mx-2" onchange="table_form_submit()" >
                                            <option value="10" <?= ($length == 10)?'selected':'';?> >10</option>
                                            <option value="25" <?= ($length == 25)?'selected':'';?>>25</option>
                                            <option value="50" <?= ($length == 50)?'selected':'';?>>50</option>
                                            <option value="100" <?= ($length == 100)?'selected':'';?>>100</option>
                                        </select>
                                        entries
                                    </label>

                                </div>
                                <div class="col-md-7 mx-auto"></div>
                                <div class="col-md-3 mx-auto">
                                    <div class="input-group ">
                                        <lable class="tab-lab">Search:</lable>
                                        <input name="keyWord" class="form-control form-control-sm border-end-0 border search-tab ml-2" oninput="table_form_submit()"  type="search" value="<?= $keyWord?>" id="example-search-input">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="bulkTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="allCheckedDemo(this)"  ></th>
                                    <th class="colum_id row_show "> Id</th>
                                    <th class="colum_image row_show "> Image</th>
                                    <th class="colum_name row_show ">
                                        Name</th>
                                    <th class="colum_model row_show ">
                                        Model</th>
                                    <th class="colum_quantity row_show ">
                                        Quantity</th>
                                    <th class="colum_category row_show ">
                                        Category</th>
                                    <th class="colum_price row_show ">
                                        Price</th>
                                    <th class="colum_status row_show ">
                                        Status</th>
                                    <th class="colum_featured row_show "> Featured</th>
                                    <th class="colum_optionrow row_show "> Option</th>
                                    <th class="colum_meta_title row_hide "> Meta Title</th>
                                    <th class="colum_meta_keyword row_hide "> Meta Keyword</th>
                                    <th class="colum_meta_description row_hide "> Meta Description</th>
                                </tr>
                            </thead>
                            <!-- row_hide -->
                            <tbody id="tbody">
                                <?php foreach ($product as $key => $val) { $img = str_replace("pro_", "", $val->image); $url = (!empty($val->image)) ? base_url('uploads/products/' . $val->product_id . '/' . $img):base_url('uploads/products/noimage.png' ); ?>
                                <tr id="update_<?php echo $val->product_id?>">
                                    <td width="10">
                                        <input type="checkbox" name="productId[]" value="<?php echo $val->product_id;?>" form="multiActionForm" >
                                    </td>
                                    <td class="colum_id row_show "> <?php echo $val->product_id; ?></td>
                                    <td class="colum_image row_show ">
                                        <a class="product-image-link" href="<?= $url;?>" data-lightbox="product-set-<?= $val->product_id;?>">
                                        <?php echo image_view('uploads/products',$val->product_id,'50_'.$val->image,'50_noimage.png','');?>
                                        </a>
                                    </td>
                                    <td class="colum_name row_show ">
                                        <p  onclick="updateFunction('<?php echo $val->product_id; ?>','name','<?php echo $val->name; ?>','view_name_<?php echo $val->product_id; ?>','bulkForm_name_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')">
                                            <?php echo !empty($val->name)?$val->name:'<i style="color: #ccc;">NULL</i>'; ?></p>
                                        <span id="view_name_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                    <td class="colum_model row_show ">
                                        <p onclick="updateFunction('<?php echo $val->product_id; ?>', 'model', '<?php echo $val->model; ?>', 'view_model_<?php echo $val->product_id; ?>','bulkForm_model_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')">
                                            <?php echo !empty($val->model)?$val->model:'<i style="color: #ccc;">NULL</i>'; ?> </p>
                                        <span id="view_model_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                    <td class="colum_quantity row_show ">
                                        <p onclick="updateFunction('<?php echo $val->product_id; ?>', 'quantity', '<?php echo $val->quantity; ?>', 'view_qty_<?php echo $val->product_id; ?>','bulkForm_qty_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')">
                                            <?php echo !empty($val->quantity)?$val->quantity:'<i style="color: #ccc;">NULL</i>'; ?> </p>
                                        <span id="view_qty_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                    <td class="colum_category row_show">
                                        <button type="button" onclick="categoryBulkUpdate('<?php echo $val->product_id; ?>')" class="btn btn-xs btn-secondary" >show</button>
                                    </td>
                                    <td class="colum_price row_show">
                                        <p  onclick="updateFunction('<?php echo $val->product_id; ?>', 'price', '<?php echo $val->price; ?>', 'view_price_<?php echo $val->product_id; ?>','bulkForm_price_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')">
                                            <?php echo !empty($val->price)?$val->price:'<i style="color: #ccc;">NULL</i>'; ?></p>
                                        <span id="view_price_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                    <td class="colum_status row_show">

                                        <?php if ($val->status == 'Active') { ?>
                                        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Inactive','status','update_<?php echo $val->product_id?>')" class="btn btn-success btn-xs"><?php echo $val->status; ?></button>
                                        <?php } else { ?>
                                        <button type="button"  onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Active','status','update_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs"><?php echo $val->status; ?></button>
                                        <?php } ?>

                                    </td>
                                    <td class="colum_featured row_show">
                                        <?php if ($val->featured == '1') { ?>
                                        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','0','featured','update_<?php echo $val->product_id?>')"  class="btn btn-success btn-xs">On</button>
                                        <?php } else { ?>
                                        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','1','featured','update_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs">Off</button>
                                        <?php } ?>
                                    </td>
                                    <td class="colum_optionrow row_show">
                                        <button type="button" onclick="optionBulkUpdate('<?php echo $val->product_id; ?>')" class="btn btn-xs btn-secondary" >Show</button>
                                    </td>

                                    <td class="colum_meta_title row_hide">
                                        <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_title', '<?php echo $val->meta_title;?>' , 'view_meta_title_<?php echo $val->product_id; ?>', 'desc_meta_title_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_title)?$val->meta_title:'<i style="color: #ccc;">NULL</i>';?></p>
                                        <span id="view_meta_title_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                    <td class="colum_meta_keyword row_hide">
                                        <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_keyword', '<?php echo $val->meta_keyword;?>' , 'view_meta_keyword_<?php echo $val->product_id; ?>', 'desc_meta_keyword_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_keyword)?$val->meta_keyword:'<i style="color: #ccc;">NULL</i>';?></p>
                                        <span id="view_meta_keyword_<?php echo $val->product_id; ?>"></span>
                                    </td>

                                    <td class="colum_meta_description row_hide">
                                        <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_description', '<?php echo $val->meta_description;?>' , 'view_meta_description_<?php echo $val->product_id; ?>', 'desc_meta_description_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_description)?$val->meta_description:'<i style="color: #ccc;">NULL</i>';?></p>
                                        <span id="view_meta_description_<?php echo $val->product_id; ?>"></span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                        </div>

                        <div class="col-md-12">
                            <?php echo $links; ?>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
    </section>
    <!-- /.content -->
    <!-- /.category modal -->
    <div class="modal fade" id="categoryModal">
        <div class="modal-dialog">
            <div class="modal-content" id="catData">
            </div>
        </div>
    </div>

    <div class="modal fade" id="optionModal">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content" id="optionData">
            </div>
        </div>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function bulk_status(label) {
        var numberOfChecked = $('input:checkbox:checked').length;
        if (numberOfChecked > 10 ) {
            $('input[name="' + label + '"]').prop("checked", false);
            $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert">Checked Box limit 10 ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }else{
            var className = 'colum_' + label;
            if ($('input[name="' + label + '"]').is(':checked')) {
                $("." + className).addClass('row_show');
                $("." + className).removeClass('row_hide');
            } else {
                $("." + className).removeClass('row_show');
                $("." + className).addClass('row_hide');
            }
            $('#message').html('');
        }
    }


    function updateFunction(proId, input, value, viewId, formName,updateRow) {
        var formID = "'" + formName + "'"
        var data = '<form id="' + formName +
            '" action="<?php echo base_url('bulk_data_update') ?>" onkeydown="if(event.keyCode === 13) {return false;}" data-row="'+updateRow+'" method="post"><input type="text" name="' +
            input +
            '" class="form-control mb-2" value="' + value +
            '" ><input type="hidden" name="product_id" class="form-control mb-2" value="' + proId +
            '" ><button type="button" onclick="submitFormBulk(' + formID +
            ')" class="btn btn-xs btn-primary mr-2">Update</button><a href="javascript:void(0)" onclick="hideInput(this)" class="btn btn-xs btn-danger">Cancel</button> </form>';

        $('#' + viewId).html(data);
    }

    function descriptionTableDataUpdateFunction(proId, input, value, viewId, formName,updateRow) {
        var formID = "'" + formName + "'"
        var data = '<form id="' + formName +
            '" action="<?php echo base_url('description_data_update') ?>" onkeydown="if(event.keyCode === 13) {return false;}" data-row="'+updateRow+'" method="post"><input type="text" name="' +
            input +
            '" class="form-control mb-2" value="' + value +
            '" ><input type="hidden" name="product_desc_id" class="form-control mb-2" value="' + proId +
            '" ><button type="button" onclick="submitFormBulk(' + formID +
            ')" class="btn btn-xs btn-primary mr-2">Update</button><a href="javascript:void(0)" onclick="hideInput(this)" class="btn btn-xs btn-danger">Cancel</button> </form>';

        $('#' + viewId).html(data);
    }

    function hideInput(data) {
        $(data).parent().remove();
    }

    function submitFormBulk(formID) {
        var form = document.getElementById(formID);
        var upRow = $(form).attr('data-row');

        var done = false;
        $.ajax({
            url: $(form).prop('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // $("#message").html(data);
                $("#mess").show();
                var div = $("#"+upRow).html(data);
                div.animate({opacity: '0.5'});
                div.animate({opacity: '1'});
                checkShowHideRow();

            }
        });

    }

    function checkShowHideRow() {

        var fields = ['id','image', 'name', 'model', 'quantity', 'category', 'price', 'status', 'featured','optionrow','meta_title','meta_keyword','meta_description', 'action'];

        for (let i = 0; i < fields.length; ++i) {
            if ($('input[name="' + fields[i] + '"]').is(':checked')) {
                $(".colum_" + fields[i]).addClass('row_show');
                $(".colum_" + fields[i]).removeClass('row_hide');
            } else {
                $(".colum_" + fields[i]).removeClass('row_show');
                $(".colum_" + fields[i]).addClass('row_hide');
            }
        }
    }


    function bulkAllStatusUpdate(proId, value, field,upRow) {

        $.ajax({
            url: '<?php echo base_url('bulk_all_status_update') ?>',
            type: "POST",
            data: {
                product_id: proId,
                value: value,
                fieldName: field
            },
            success: function(data) {
                //$("#message").html(data);
                $("#mess").show();
                var div = $("#"+upRow).html(data);
                div.animate({opacity: '0.5'});
                div.animate({opacity: '1'});
                checkShowHideRow();
            }
        });
    }

    function categoryBulkUpdate(proId) {
        $('#categoryModal').modal('show');
        $.ajax({
            url: '<?php echo base_url('bulk_category_view') ?>',
            type: "POST",
            data: {
                product_id: proId
            },
            success: function(data) {
                $("#catData").html(data);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
            }
        });
    }

    function optionBulkUpdate(proId){
        $('#optionModal').modal('show');
        $.ajax({
            url: '<?php echo base_url('bulk_option_view') ?>',
            type: "POST",
            data: {
                product_id: proId
            },
            success: function(data) {
                $("#optionData").html(data);

            }
        });
    }

    function optionBulkUpdateAction() {
        var result = true;
        var mess = '<div class="alert alert-danger alert-dismissible" role="alert">All field are required! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'

        $('[name^="qty"]').each(function() {
            qty = parseInt(this.value);
            if (isNaN(qty)){
                result = false;
            }
        });

        $('[name^="price_op"]').each(function() {
            price = parseInt(this.value);
            if (isNaN(price)){
                result = false;
            }
        });

        $('[name^="opValue"]').each(function() {
            opValue = parseInt(this.value);
            if (isNaN(opValue)){
                result = false;
            }
        });

        if (result == false) {
            $('#mesError').html(mess);
        }else {
            var form = document.getElementById('optionForm');
            var upRow = $(form).attr('data-row');
            $.ajax({
                url: $(form).prop('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#optionModal').modal('hide');
                    // $("#message").html(data);
                    $("#mess").show();
                    var div = $("#" + upRow).html(data);
                    div.animate({opacity: '0.5'});
                    div.animate({opacity: '1'});
                    checkShowHideRow();

                }
            });
        }
    }

    function categoryBulkUpdateAction() {

        var form = document.getElementById('categoryForm');
        var upRow = $(form).attr('data-row');
        $.ajax({
            url: $(form).prop('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#categoryModal').modal('hide');
                // $("#message").html(data);
                $("#mess").show();
                var div = $("#" + upRow).html(data);
                div.animate({opacity: '0.5'});
                div.animate({opacity: '1'});
                checkShowHideRow();

            }
        });
    }

    function allCheckedDemo(source) {
        var checkboxes = document.querySelectorAll('#bulkTable input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    function searchOptionUp(key) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_search') ?>",
            data: {
                key: key
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $('#dataView').html(data);
            }

        });
    }

    function optionViewPro(option_id, name,nameTitle) {
        var n = "'" + name + "_op'";
        var rl = "'" + name + "_remove'";
        var nr = "'" + name + "'";
        var link = '<a class="nav-link active text-dark" id="' + name + '_remove"  data-toggle="pill" href="#' + name +
            '" role="tab" aria-controls="vert-tabs-home" aria-selected="true">' + nameTitle +
            '<button type="button" class="btn btn-sm" onclick="remove_option_new_ajax(' + rl + ',' + nr +
            ')"><i class="fa fa-trash text-danger"></i></button></a>';
        var con = '<div class="tab-pane text-left fade  show active" id="' + name +
            '" role="tabpanel" aria-labelledby="vert-tabs-home-tab"><div class="col-md-12 mt-2"> <h5>Click on add option</h5></div><hr><div id="' +
            name +
            '_op"></div><input type="hidden" value="1" id="total_chq"><div class="col-md-12 mt-2" ><a href="javascript:void(0)" style="float: right;    margin-right: 150px;" onclick="add_option_new_ajax(' +
            n + ',' + option_id + ');"class="btn btn-sm btn-primary">Add option</a></div></div>';

        $(".tab-link-ajax a").removeClass('active');
        $(".tab-content-ajax .tab-pane").removeClass('active');
        $('.keyoption').val('');
        $('#dataView').html('');
        $('.tab-link-ajax').append(link);
        $('.tab-content-ajax').append(con);

    }

    //option
    function add_option_new_ajax(id, option_id) {
        // var data = '';
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_value_search') ?>",
            data: {
                option_id: option_id
            },
            success: function(val) {
                var data = val;

                var new_chq_no = parseInt($('#total_chq').val()) + 1;
                var new_input = "<div class='col-md-12 mt-3' id='new_" + new_chq_no +
                    "' ><input type='hidden' name='option[]' value='" + option_id +
                    "' ><select name='opValue[]' id='valId_" + new_chq_no +
                    "' style='padding: 3px;' required><option value=''>Please select</option>" + data +
                    "</select><select name='subtract[]' style='padding: 3px;'><option value='plus'>Plus</option><option value='minus'>Minus</option></select><input type='number' placeholder='Quantity' name='qty[]' required> <input type='number' placeholder='Price' name='price_op[]' required> <a href='javascript:void(0)' onclick='remove_option(this)' class='btn btn-sm btn-danger' style='margin-top: -5px;'>X</a></div>";

                $('#' + id).append(new_input);
                $('#total_chq').val(new_chq_no);
            }

        });



    }

    function remove_option_new_ajax(link, data) {
        $('#' + link).remove();
        $('#' + data).remove();
    }
    function remove_option(data) {
        $(data).parent().remove();
    }
</script>
<?= $this->endSection() ?>