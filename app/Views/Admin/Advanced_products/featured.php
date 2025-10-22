
<button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','<?php echo ($val->featured == '1')?0:'1';?>','featured','reFeaturedUpdate_<?php echo $val->product_id?>')" class="btn <?php echo ($val->featured == '1')?'btn-success':'btn-warning';?> btn-xs"><?php echo ($val->featured == '1')?'On':'Off';?></button>

