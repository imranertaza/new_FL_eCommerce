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
                    <div class="col-md-8">
                        <h3 class="card-title">Bulk Edit Product List</h3><br>

                    </div>
                    <div class="col-md-4">

                        <a href="<?php echo base_url('product_create') ?>"
                            class="btn btn-primary  btn-xs float-right "><i class="fas fa-plus"></i> Add</a>
                        <a class="btn btn-xs btn-info float-right mr-2" data-toggle="collapse" href="#collapseProduct"
                            role="button" aria-expanded="false" aria-controls="collapseProduct">Settings</a>
                        <button type="button" onclick="bulk_product_copy()" class="btn btn-secondary btn-xs float-right mr-2"><i class="nav-icon fas fa-copy"></i> Copy</button>
                        <a href="<?php echo base_url('products') ?>" class="btn btn-danger float-right mr-2 btn-xs" >Back</a>
                    </div>
                    <div class="col-md-12" id="message" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                        endif; ?>
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

                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="action" class="form-check-input"
                                onclick="bulk_status('action')" id="check_9" checked="">
                            <label class="form-check-label" for="check_9">
                                Action </label>
                        </div>
                    </div>
                </div>
                <div id="tablereload">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="allCheckedDemo(this)" ></th>
                                <th class="colum_id row_show ">
                                    Id</th>
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
                                <th class="colum_meta_title row_hide "> Meta Title</th>
                                <th class="colum_meta_keyword row_hide "> Meta Keyword</th>
                                <th class="colum_meta_description row_hide "> Meta Description</th>
                                <th class="colum_action row_show "> Action</th>
                            </tr>
                        </thead>
                        <!-- row_hide -->
                        <tbody id="tbody">
                            <?php $i = 1;
                        $j = 1;
                        $m = 1;
                        $ml = 1;
                        $q = 1;
                        $ql = 1;
                        $p = 1;
                        $pl = 1;
                        $mt =1;
                        $mt1 =1;
                        $mk1 =1;
                        $mk =1;
                        $md =1;
                        $md1 =1;
                        foreach ($product as $key => $val) {
                        ?>
                            <tr>
                                <td width="10">
                                    <input type="checkbox" name="productId[]" value="<?php echo $val->product_id;?>" >
                                </td>
                                <td class="colum_id row_show "> <?php echo $val->product_id; ?></td>
                                <td class="colum_image row_show "> <?php echo image_view('uploads/products',$val->product_id,'100_'.$val->image,'noimage.png',$class='img-100-100');?></td>
                                <td class="colum_name row_show ">
                                    <p
                                        onclick="updateFunction('<?php echo $val->product_id; ?>','name','<?php echo $val->name; ?>','view_name_<?php echo $j++; ?>','bulkForm_name_<?php echo $val->product_id; ?>')">
                                        <?php echo !empty($val->name)?$val->name:'<i style="color: #ccc;">NULL</i>'; ?></p>
                                    <span id="view_name_<?php echo $i++; ?>"></span>
                                </td>
                                <td class="colum_model row_show ">
                                    <p
                                        onclick="updateFunction('<?php echo $val->product_id; ?>', 'model', '<?php echo $val->model; ?>', 'view_model_<?php echo $ml++; ?>','bulkForm_model_<?php echo $val->product_id; ?>')">
                                        <?php echo !empty($val->model)?$val->model:'<i style="color: #ccc;">NULL</i>'; ?> </p>
                                    <span id="view_model_<?php echo $m++; ?>"></span>
                                </td>
                                <td class="colum_quantity row_show ">
                                    <p
                                        onclick="updateFunction('<?php echo $val->product_id; ?>', 'quantity', '<?php echo $val->quantity; ?>', 'view_qty_<?php echo $ql++; ?>','bulkForm_qty_<?php echo $val->product_id; ?>')">
                                        <?php echo !empty($val->quantity)?$val->quantity:'<i style="color: #ccc;">NULL</i>'; ?> </p>
                                    <span id="view_qty_<?php echo $q++; ?>"></span>
                                </td>
                                <td class="colum_category row_show">
                                    <ul class="list-unstyled"
                                        onclick="categoryBulkUpdate('<?php echo $val->product_id; ?>')">
                                        <?php foreach (get_array_data_by_id('cc_product_to_category', 'product_id', $val->product_id) as $cat) { ?>
                                        <li><?php echo display_category_with_parent($cat->category_id); ?></li>
                                        <?php } ?>
                                    </ul>

                                </td>
                                <td class="colum_price row_show">
                                    <p
                                        onclick="updateFunction('<?php echo $val->product_id; ?>', 'price', '<?php echo $val->price; ?>', 'view_price_<?php echo $pl++; ?>','bulkForm_price_<?php echo $val->product_id; ?>')">
                                        <?php echo !empty($val->price)?$val->price:'<i style="color: #ccc;">NULL</i>'; ?></p>
                                    <span id="view_price_<?php echo $p++; ?>"></span>
                                </td>
                                <td class="colum_status row_show">

                                    <?php if ($val->status == 'Active') { ?>
                                    <button type="button"
                                        onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Inactive','status')"
                                        class="btn btn-success btn-xs"><?php echo $val->status; ?></button>
                                    <?php } else { ?>
                                    <button type="button"
                                        onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Active','status')"
                                        class="btn btn-warning btn-xs"><?php echo $val->status; ?></button>
                                    <?php } ?>

                                </td>
                                <td class="colum_featured row_show">
                                    <?php if ($val->featured == '1') { ?>
                                    <button type="button"
                                        onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','0','featured')"
                                        class="btn btn-success btn-xs">On</button>
                                    <?php } else { ?>
                                    <button type="button"
                                        onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','1','featured')"
                                        class="btn btn-warning btn-xs">Off</button>
                                    <?php } ?>
                                </td>

                                <td class="colum_meta_title row_hide">
                                    <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_title', '<?php echo $val->meta_title;?>' , 'view_meta_title_<?php echo $mt1++; ?>', 'desc_meta_title_<?php echo $val->product_id; ?>')"><?php echo !empty($val->meta_title)?$val->meta_title:'<i style="color: #ccc;">NULL</i>';?></p>
                                    <span id="view_meta_title_<?php echo $mt++; ?>"></span>
                                </td>
                                <td class="colum_meta_keyword row_hide">
                                    <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_keyword', '<?php echo $val->meta_keyword;?>' , 'view_meta_keyword_<?php echo $mk1++; ?>', 'desc_meta_keyword_<?php echo $val->product_id; ?>')"><?php echo !empty($val->meta_keyword)?$val->meta_keyword:'<i style="color: #ccc;">NULL</i>';?></p>
                                    <span id="view_meta_keyword_<?php echo $mk++; ?>"></span>
                                </td>

                                <td class="colum_meta_description row_hide">
                                    <p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_description', '<?php echo $val->meta_description;?>' , 'view_meta_description_<?php echo $md1++; ?>', 'desc_meta_description_<?php echo $val->product_id; ?>')"><?php echo !empty($val->meta_description)?$val->meta_description:'<i style="color: #ccc;">NULL</i>';?></p>
                                    <span id="view_meta_description_<?php echo $md++; ?>"></span>
                                </td>
                                <td class="colum_action row_show">
                                    <a href="<?php echo base_url('product_update/' . $val->product_id) ?>"
                                        class="btn btn-sm btn-info">Edit</a>
                                    <!-- <a href="<?php echo base_url('product_delete/' . $val->product_id) ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to Delete?')">delete</a> -->
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
            <div class="modal-content">
                <form id="categoryForm" action="<?php echo base_url('bulk_category_update') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Default Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="catData">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" onclick="categoryBulkUpdateAction()" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>