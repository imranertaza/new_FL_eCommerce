<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Blog Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Blog Update</h3>
                    </div>
                    <div class="col-md-4"> </div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== null) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('blog_update_action')?>" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blog Title <span class="requi">*</span></label>
                                <input type="text" name="blog_title" oninput="page_slug(this.value)" class="form-control" placeholder="Blog Title" value="<?php echo $blog->blog_title;?>" required>
                            </div>

                            <div class="form-group">
                                <label>Slug <span class="requi">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="<?php echo $blog->slug;?>" required>
                            </div>

                            <div class="form-group category">
                                <label>Category <span class="requi">*</span></label>
                                <select class="select2bs4" name="cat_id" data-placeholder="Select a Category" style="width: 100%;" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($category as $cat) { ?>
                                        <option value="<?php echo $cat->cat_id; ?>" <?php echo ($cat->cat_id == $blog->cat_id) ? 'selected' : '';?> ><?php echo display_blog_category_with_parent($cat->cat_id); ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <?php echo common_image_view('uploads/blog', $blog->blog_id, $blog->image, 'noimage.png', '', '', '100', '100');?><br>

                                <label>Image </label>
                                <input type="file" name="image"  class="form-control" placeholder="Image" >
                                <span>Recommended Size (900x500)</span>
                            </div>

                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_des" class="form-control" placeholder="Short Description" ><?php echo $blog->short_des;?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="editor" rows="4" class="form-control" placeholder="Description" ><?php echo $blog->description;?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status <span class="requi">*</span></label>
                                <select name="status" class="form-control">
                                    <?php echo globalStatus($blog->status);?>
                                </select>
                            </div>
                            <input type="hidden" name="blog_id"  class="form-control" placeholder="blog_id" value="<?php echo $blog->blog_id;?>" >
                            <button class="btn btn-primary" >Update</button>
                            <a href="<?php echo base_url('admin-blog')?>" class="btn btn-danger" >Back</a>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video Id </label>
                                <input type="text" name="video_id"  class="form-control" placeholder="embed(I85ET56TEWT)" value="<?php echo $blog->video_id;?>" >
                            </div>

                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="<?php echo $blog->meta_title;?>" placeholder="Meta Title">
                            </div>

                            <div class="form-group">
                                <label>Meta Keyword</label>
                                <input type="text" name="meta_keyword" class="form-control" placeholder="Meta Keyword" value="<?php echo $blog->meta_keyword;?>">
                            </div>

                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="meta_description" rows="3" class="form-control" placeholder="Meta Description"><?php echo $blog->meta_keyword;?></textarea>
                            </div>

                            <div class="form-group ">
                                <br><label>Carousel Image</label>
                                <div id="frames"></div><br>
                                <input type="file" class="form-control" id="image" name="multiImage[]" multiple />
                                Recommended Size (900x500)
                                <div class="row" id="reloadImg">
                                    <?php foreach ($crassulaImage as $img){ ?>
                                        <div class="col-md-4 position-relative">
                                            <?php echo common_image_view('uploads/blog', $blog->blog_id.'/'.$img->blog_crassula_image_id, $img->image, 'noimage.png', 'mt-2', '100', '150', '100');?>
                                            <a href="javascript:void(0);" onclick="removeBlogImage('<?php echo $img->blog_crassula_image_id;?>','<?php echo $blog->blog_id;?>')" class="btn btn-danger remove_btn" >X</a>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>
<?= $this->section('java_script') ?>
    <script>
        function page_slug(Text) {
            var slug = Text.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            $("#slug").val(slug);
        }
        function removeBlogImage(id,blogid){
            var result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                    method: 'POST',
                    url: "<?php echo base_url('blog_image_remove_action')?>",
                    data: {id:id,blogId:blogid},
                    success: function(response) {
                        $("#message").html(response);
                        $('#reloadImg').load(document.URL + ' #reloadImg');
                    }
                });
            }
        }
    </script>
<?= $this->endSection() ?>
