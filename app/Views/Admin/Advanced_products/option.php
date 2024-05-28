
<div class="col-md-12 mt-2" id="mesError"></div>
<form id="optionForm" action="<?php echo base_url('bulk_option_update') ?>" data-row="update_<?php echo $product_id;?>" method="post">
    <div class="modal-header">
        <h4 class="modal-title">Options</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>  </button>
    </div>
    <div class="modal-body" >

        <div class="row">
            <div class="col-5 col-sm-3 h-100">
                <div class="nav flex-column nav-tabs h-100 text-right font-weight-bolder tab-link-ajax" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    <?php foreach ($prodOption as $key => $op){ $option = get_all_row_data_by_id('cc_option','option_id',$op->option_id); ?>
                        <a class="nav-link  <?php echo ($key ==0)?'active':'';?> text-dark" id="<?php echo strtolower(str_replace(' ','',$option->name)); ?>_remove"  data-toggle="pill" href="#<?php echo strtolower(str_replace(' ','',$option->name)) ?>" role="tab" aria-controls="vert-tabs-home" aria-selected="true"><?php echo $option->name ?><button type="button" class="btn btn-sm" onclick="remove_option_new_ajax('<?php echo strtolower(str_replace(' ','',$option->name)) ?>_remove','<?php echo strtolower(str_replace(' ','',$option->name)) ?>')"><i class="fa fa-trash text-danger"></i></button></a>
                    <?php } ?>
                </div>

                <div class=" flex-column search mt-2 h-100">
                    <input type="text" class="form-control keyoption" name="keyoption" oninput="searchOptionUp(this.value)" >
                    <span id="dataView"></span>
                </div>

            </div>

            <div class="col-7 col-sm-9">
                <div class="tab-content tab-content-ajax" id="vert-tabs-tabContent">
                    <?php foreach ($prodOption as $key => $op){ $option = get_all_row_data_by_id('cc_option','option_id',$op->option_id); ?>
                        <div class="tab-pane text-left fade  show <?php echo ($key ==0)?'active':'';?>" id="<?php echo strtolower(str_replace(' ','',$option->name)) ?>" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                            <div class="col-md-12 mt-2"> <h5>Click on add option</h5></div><hr>
                            <div id="<?php echo strtolower(str_replace(' ','',$option->name)) ?>_op">
                                <?php
                                $opValue = option_id_or_product_id_by_option_value($op->option_id,$product_id);
                                $opVal = get_array_data_by_id('cc_option_value','option_id',$op->option_id);
                                ?>
                                <?php $i=101; foreach ($opValue as $val ){  ?>
                                    <div class='col-md-12 mt-3' id='new_<?php echo $i++.$option->name;?>' ><input type='hidden' name='option[]' value='<?php echo $val->option_id;?>' ><select name='opValue[]' id='valId_"+new_chq_no+"' style='padding: 3px;'><option value=''>Please select</option><?php foreach ($opVal as $p){ ?><option value='<?php echo $p->option_value_id; ?>'  <?php echo ($p->option_value_id == $val->option_value_id)?'selected':''; ?> ><?php echo $p->name; ?></option><?php } ?></select><select name='subtract[]' style='padding: 3px;'><option value='plus' <?php echo ($val->subtract == null)?'selected':'';?> >Plus</option><option value='minus' <?php echo ($val->subtract != null)?'selected':'';?> >Minus</option></select><input type='number' placeholder='Quantity' name='qty[]' value='<?php echo $val->quantity;?>' required> <input type='number' placeholder='Price' name='price_op[]' value='<?php echo $val->price;?>' required> <a href='javascript:void(0)' onclick='remove_option(this)' class='btn btn-sm btn-danger' style='margin-top: -5px;'>X</a></div>
                                <?php } ?>
                            </div>
                            <input type="hidden" value="1" id="total_chq">
                            <div class="col-md-12 mt-2" >
                                <a href="javascript:void(0)" style="float: right; margin-right: 150px;" onclick="add_option_new_ajax('<?php echo strtolower(str_replace(' ','',$option->name)) ?>_op','<?php echo $option->option_id ?>');"class="btn btn-sm btn-primary">Add option</a>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                </div>
            </div>

        </div>

    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="optionBulkUpdateAction()" class="btn btn-primary">Save changes</button>
    </div>
</form>