

<p onclick="updateFunction('<?php echo $val->product_id; ?>', 'model', '<?php echo $val->model; ?>', 'view_model_<?php echo $val->product_id; ?>','bulkForm_model_<?php echo $val->product_id; ?>','reModelUpdate_<?php echo $val->product_id?>')">
    <?php echo !empty($val->model)?$val->model:'<i style="color: #ccc;">NULL</i>'; ?> </p>
<span id="view_model_<?php echo $val->product_id; ?>"></span>
