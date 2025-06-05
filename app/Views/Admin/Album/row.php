
<td width="40"><?php echo $val->album_id?></td>
<td>
    <p onclick="updateFunctionAlbum('<?= $val->album_id;?>', 'name', '<?= $val->name;?>', 'view_name_<?=$val->album_id?>', 'formEdit_<?=$val->album_id?>','update_<?= $val->album_id;?>')"><?php echo $val->name;?></p>
    <span id="view_name_<?php echo $val->album_id; ?>"></span>
</td>
<td><?php echo common_image_view('uploads/album', $val->album_id, $val->thumb, 'noimage.png', '', '', '50', '50');?></td>
<td width="220">
    <a href="<?php echo base_url('album_update/'.$val->album_id);?>" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Update</a>
    <a href="<?php echo base_url('album_delete/'.$val->album_id);?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Delete</a>
</td>
