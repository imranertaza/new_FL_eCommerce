
<p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_description', '<?php echo $val->meta_description;?>' , 'view_meta_description_<?php echo $val->product_id; ?>', 'desc_meta_description_<?php echo $val->product_id; ?>','reMetaDescriptionUpdate_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_description)?$val->meta_description:'<i style="color: #ccc;">NULL</i>';?></p>
<span id="view_meta_description_<?php echo $val->product_id; ?>"></span>
