
<p onclick="descriptionTableDataUpdateFunction('<?php echo $val->product_desc_id; ?>','meta_keyword', '<?php echo $val->meta_keyword;?>' , 'view_meta_keyword_<?php echo $val->product_id; ?>', 'desc_meta_keyword_<?php echo $val->product_id; ?>','reMetaKeywordUpdate_<?php echo $val->product_id?>')"><?php echo !empty($val->meta_keyword)?$val->meta_keyword:'<i style="color: #ccc;">NULL</i>';?></p>
<span id="view_meta_keyword_<?php echo $val->product_id; ?>"></span>
