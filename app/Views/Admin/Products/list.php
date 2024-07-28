<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                    <div class="col-md-6">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <div class="col-md-6">
                        <form id="multisubmitform" action="<?php echo base_url('product_copy_action'); ?>" method="post">
                            <a href="<?php echo base_url('product_create') ?>" class="btn btn-primary btn-xs float-right"><i class="fas fa-plus"></i> Add</a>
                            <?php if(modules_key_by_access('bulk_edit_products') == '1' ){?>
                            <a href="<?php echo base_url('bulk_edit_products') ?>" onclick="bulk_datatable_reset()" class="btn btn-info btn-xs float-right mr-2"><i class="fas fa-plus"></i> Bulk Edit Products</a>
                            <?php } ?>
                            <button type="submit" class="btn btn-secondary btn-xs float-right mr-2"><i class="nav-icon fas fa-copy"></i> Copy</button>
                            <?php if(modules_key_by_access('image_crop') == '1' ){?>
                            <button type="submit"  formaction="<?php echo base_url('product_image_crop_action'); ?>" class="btn btn-info btn-xs float-right mr-2"><i class="fas fa-file"></i> Crop image</button>
                            <?php } ?>
                            <?php if(modules_key_by_access('multi_delete') == '1' ){ ?>
                            <button type="submit" formaction="<?php echo base_url('product_multi_delete_action'); ?>" class="btn btn-danger btn-xs float-right mr-2"><i class="fas fa-trash"></i> Multi delete</button>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="tableForm" action="<?php echo base_url('products')?>" method="GET" >
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
                                <input name="keyWord" class="form-control form-control-sm border-end-0 border search-tab ml-2" onkeyup="table_form_submit()"  type="search" value="<?= $keyWord?>" id="example-search-input">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" onclick="allchecked(this)" ></th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($product as $val){ ?>
                        <tr id="hide_<?php echo $val->product_id;?>">
                            <td width="10">
                                <input type="checkbox" name="productId[]" value="<?php echo $val->product_id;?>" form="multisubmitform" >
                            </td>
                            <td width="50"><?php echo image_view('uploads/products',$val->product_id,'50_'.$val->image,'50_noimage.png','');?></td>
                            <td><?php echo $val->name;?></td>
                            <td><?php echo $val->model;?></td>
                            <td> <?php echo $val->quantity;?></td>
                            <td width="140">
                                <a href="<?php echo base_url('product_update/'.$val->product_id)?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="product_delete('<?php echo $val->product_id;?>')">delete</a>
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
            <!-- /.card-body -->
            <div class="card-footer">
<!--                --><?php //echo $total; ?>
                <?php //echo $links; ?>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->


    </section>
    <!-- /.content -->
</div>

