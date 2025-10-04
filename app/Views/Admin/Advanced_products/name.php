

<p  onclick="updateFunction('<?php echo $val->product_id; ?>','name','<?php echo esc(str_replace("'", "\\'", $val->name)); ?>','view_name_<?php echo $val->product_id; ?>','bulkForm_name_<?php echo $val->product_id; ?>','reNameUpdate_<?php echo $val->product_id?>')">
    <?php echo !empty($val->name)?$val->name:'<i style="color: #ccc;">NULL</i>'; ?></p>
<span id="view_name_<?php echo $val->product_id; ?>"></span>
