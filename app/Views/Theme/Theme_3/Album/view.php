<section class="main-container my-0">
    <div class="container">
        <div class=" bg-white  py-4 mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"> <?= $album->name?></h3>
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                    <?php if (!isset(newSession()->isLoggedInCustomer)){ ?>
                    <button class="btn btn-sm btn-primary border-0 float-end" data-bs-toggle="modal" data-bs-target="#queryModal" style="background-color: #0594eb!important;">Enquiry Now!</button>
                    <?php }else{ ?>
                        <button class="btn btn-sm btn-primary border-0 float-end" onclick="submitQueryQcpictures('<?php echo newSession()->cusAll->email;?>','<?php echo $album->album_id;?>')" style="background-color: #0594eb!important;">Enquiry Now!</button>
                    <?php } ?>
                </div>
                <div class="col-4 col-md-3 mt-4 text-center ">
                    <?php $img = str_replace("pro_", "", $album->thumb); $url = base_url('uploads/album/'.$album->album_id.'/wm_'.$img); ?>
                    <a class="example-image-link" href="<?= $url;?>" data-lightbox="example-set">
                    <?php echo image_view('uploads/album',$album->album_id,'261_wm_'.$album->thumb,'noimage.png','');?>
                    </a>
                </div>
                <?php foreach ($albumAll as $val){ $img2 = str_replace("pro_", "", $val->image); $url2 = base_url('uploads/album/'.$val->album_id.'/'.$val->album_details_id.'/wm_'.$img2); ?>
                <div class="col-4 col-md-3 mt-4 text-center ">
                    <a class="example-image-link" href="<?= $url2;?>" data-lightbox="example-set" >
                    <?php echo multi_image_view('uploads/album', $val->album_id, $val->album_details_id, '261_wm_' . $val->image, 'noimage.png', 'img-fluid');?>
                    </a>
                </div>
                <?php } ?>
                <div class="col-lg-12 mt-5">
                    <a href="<?php echo $back_url;?>" class="btn btn-sm btn-secondary" ><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="queryModal" tabindex="-1" aria-labelledby="queryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">In Query</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="email"  class="form-label">Email address </label>
                    <input type="email"  class="form-control" id="email" placeholder="name@example.com">
                    <span class="text-danger" id="errMss" ></span>
                    <input type="hidden"  class="form-control" id="album_id" value="<?php echo $album->album_id;?>">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitQueryForm()">Query</button>
            </div>
        </div>
    </div>
</div>
