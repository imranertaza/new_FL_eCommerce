
<button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','<?php echo ($val->status == 'Active')?'Inactive':'Active';?>','status','reStatusUpdate_<?php echo $val->product_id?>')" class="btn <?php echo ($val->status == 'Active')?'btn-success':'btn-warning';?> btn-xs"><?php echo $val->status; ?></button>


