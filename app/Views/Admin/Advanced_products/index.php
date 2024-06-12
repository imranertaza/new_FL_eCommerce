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
                        <div class="col-md-4">
                            <h3 class="card-title">Bulk Edit Product List</h3><br>

                        </div>
                        <div class="col-md-8">

                            <a href="<?php echo base_url('product_create') ?>" class="btn btn-primary  btn-xs float-right "><i class="fas fa-plus"></i> Add</a>
                            <a class="btn btn-xs btn-info float-right mr-2" data-toggle="collapse" href="#collapseProduct" role="button" aria-expanded="false" aria-controls="collapseProduct">Settings</a>
                            <a type="button" onclick="bulk_product_copy()" class="btn btn-secondary btn-xs float-right mr-2"><i class="nav-icon fas fa-copy"></i> Copy</a>
                            <form id="multiActionForm" action="<?= base_url('bulk_product_multi_delete')?>" method="post">
                            <?php if(modules_key_by_access('multi_delete') == '1' ){ ?>
                            <button type="submit" class="btn btn-danger btn-xs float-right mr-2"><i class="fas fa-trash"></i> Multi delete</button>
                            <?php } ?>
                            <?php if(modules_key_by_access('multi_option') == '1' ){ ?>
                            <button type="submit" formaction="<?php echo base_url('bulk_product_multi_option_edit'); ?>" class="btn btn-primary btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi option edit</button>
                            <?php } ?>
                            <?php if(modules_key_by_access('multi_attribute') == '1' ){ ?>
                            <button type="submit" formaction="<?php echo base_url('bulk_product_multi_attribute_edit'); ?>" class="btn btn-info btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi attribute edit</button>
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
                                <input type="checkbox" name="id" class="form-check-input" onclick="bulk_status('id')"
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
                        <table id="productBulkEdit" class="table table-bordered table-striped">
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
                                <?php foreach ($product as $key => $val) { ?>
                                <tr id="update_<?php echo $val->product_id?>">
                                    <td width="10">
                                        <input type="checkbox" name="productId[]" value="<?php echo $val->product_id;?>" form="multiActionForm" >
                                    </td>
                                    <td class="colum_id row_show "> <?php echo $val->product_id; ?></td>
                                    <td class="colum_image row_show ">
                                        <p id="img_v_<?php echo $val->product_id; ?>"></p>
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