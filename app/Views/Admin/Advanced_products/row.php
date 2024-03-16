
<td width="10">
    <input type="checkbox" name="productId[]" value="<?php echo $val->product_id;?>" >
</td>
<td class="colum_id row_show "> <?php echo $val->product_id; ?></td>
<td class="colum_image row_show "> <?php echo image_view('uploads/products',$val->product_id,'50_'.$val->image,'50_noimage.png','');?></td>
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
    <p onclick="updateFunction('<?php echo $val->product_id; ?>', 'price', '<?php echo $val->price; ?>', 'view_price_<?php echo $val->product_id; ?>','bulkForm_price_<?php echo $val->product_id; ?>','update_<?php echo $val->product_id?>')">
        <?php echo !empty($val->price)?$val->price:'<i style="color: #ccc;">NULL</i>'; ?></p>
    <span id="view_price_<?php echo $val->product_id; ?>"></span>
</td>
<td class="colum_status row_show">

    <?php if ($val->status == 'Active') { ?>
        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Inactive','status','update_<?php echo $val->product_id?>')" class="btn btn-success btn-xs"><?php echo $val->status; ?></button>
    <?php } else { ?>
        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Active','status','update_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs"><?php echo $val->status; ?></button>
    <?php } ?>

</td>
<td class="colum_featured row_show">
    <?php if ($val->featured == '1') { ?>
        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','0','featured','update_<?php echo $val->product_id?>')" class="btn btn-success btn-xs">On</button>
    <?php } else { ?>
        <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','1','featured','update_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs">Off</button>
    <?php } ?>
</td>

<td class="colum_option row_show">
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