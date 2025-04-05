<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Buy Offer Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                            <li class="breadcrumb-item active">Buy Offer Update</li>
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
                            <h3 class="card-title">Buy Offer Update</h3>
                        </div>
                        <div class="col-md-4"> </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('buy_on_get_one_update_action')?>" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">
                                <h2>Buy</h2>
                                <div class="form-group">
                                    <label>Offer Name</label>
                                    <input type="text" name="offer" oninput="slug_create(this.value)" class="form-control" placeholder="Offer Name" value="<?= $offer->name; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" value="<?= $offer->slug; ?>" required>
                                </div>

                                <div class="form-group category">
                                    <label>Products</label>
                                    <select class="select2_pro" id="keyword" name="products[]" multiple="multiple" style="width: 100%;" >
                                        <?php foreach ($offer_product as $val){ ?>
                                            <option value="<?php echo $val->product_id;?>" selected ><?php echo get_data_by_id('name','cc_products','product_id',$val->product_id);?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Start Date </label>
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= date('Y-m-d', strtotime($offer->start_date)); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Expire Date</label>
                                    <input type="date" name="expire_date" class="form-control" placeholder="Expire Date" value="<?= date('Y-m-d', strtotime($offer->expire_date)); ?>" required>
                                </div>

                                <input type="hidden" name="offer_id"  value="<?= $offer->offer_id; ?>" required>
                                <button type="submit" class="btn btn-primary" >Update</button>
                                <a href="<?php echo base_url('buy_on_get_one')?>" class="btn btn-danger" >Back</a>
                            </div>
                            <div class="col-md-6">
                                <h2>Get</h2>

                                <div class="form-group" >
                                    <label>Description</label>
                                    <textarea name="description" rows="8" class="form-control" placeholder="Description" required><?= $offer->description; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <?= image_view('uploads/offer',$offer->offer_id,'50_'.$offer->banner,'50_noimage.png','','')?>
                                </div>

                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" class="form-control" placeholder="banner" >
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
        function slug_create(data){
            var title = data;
            var slug = title.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
            document.getElementsByName('slug')[0].value = slug;
        }
    </script>
<?= $this->endSection() ?>