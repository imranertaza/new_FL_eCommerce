
<p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_title', '<?php echo $val->meta_title;?>' , 'view_meta_title_<?php echo $val->product_id; ?>', 'desc_meta_title_<?php echo $val->product_id; ?>','reMetaTitleUpdate_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_title)?$val->meta_title:'<i style="color: #ccc;">NULL</i>';?></p>
<span id="view_meta_title_<?php echo $val->product_id; ?>"></span>

