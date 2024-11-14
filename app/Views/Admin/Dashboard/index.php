<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $allOrder; ?></h3>

                            <p>All Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        <a href="<?php echo base_url('order_list');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $pendingOrder; ?></h3>

                            <p>Pending Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        <a href="<?php echo base_url('order_list');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>


                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $processingOrder; ?></h3>

                            <p>Processing Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        <a href="<?php echo base_url('order_list');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $canceledOrder; ?></h3>

                            <p>Canceled Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        <a href="<?php echo base_url('order_list');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>
                <!-- ./col -->

            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-dark">
                        <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Customers</span>
                            <span class="info-box-number"><?php echo $totalCustomer; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-dark">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Customers This Year</span>
                            <span class="info-box-number"><?php echo $totalCustomerYears; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-dark">
                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending review</span>
                            <span class="info-box-number"><?php echo $totalReviewPending; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-dark">
                        <span class="info-box-icon bg-success"><i class="fas fa-warehouse"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Short list products</span>
                            <span class="info-box-number"><?php echo $totalProductShort; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->


            </div>

            <div class="card bg-dark ">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="description-block border-right">
                                <!--                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>-->
                                <h5 class="description-header"><?php echo $order;?></h5>
                                <span class="description-text">TOTAL SALE</span>
                            </div>
                            <!-- /.description-block -->
                        </div>

                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="description-block border-right">
                                <!--                                <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>-->
                                <h5 class="description-header"><?php echo $orderYear;?></h5>
                                <span class="description-text">TOTAL SALE THIS YEAR</span>

                            </div>
                            <!-- /.description-block -->
                        </div>
                        <?php $symbol = get_lebel_by_value_in_settings('currency_symbol');?>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="description-block border-right">
                                <!--                                <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>-->
                                <h5 class="description-header"><?php echo currency_symbol_with_symbol($orderAmo,$symbol); ?></h5>
                                <span class="description-text">SALE AMOUNT</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="description-block">
                                <!--                                <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>-->
                                <h5 class="description-header"><?php echo currency_symbol_with_symbol($orderAmoYear,$symbol); ?></h5>
                                <span class="description-text">SALE AMOUNT THIS YEAR</span>

                            </div>
                            <!-- /.description-block -->
                        </div>


                    </div>
                </div>
            </div>



            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable ">
                    <!-- solid sales graph -->
                    <div class="card bg-dark">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Latest Orders
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn  btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn  btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table " >
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php foreach ($orderLast as $val){ $fname = !empty($val->firstname)?$val->firstname:$val->payment_firstname; $lname = !empty($val->lastname)?$val->lastname:$val->payment_lastname; ?>
                                    <tr>
                                        <td><?php echo $val->order_id;?></td>
                                        <td><?php echo $fname.' '.$lname;?></td>
                                        <td><span class="badge badge-default"><?php echo get_data_by_id('name','cc_order_status','order_status_id',$val->status);?></span></td>

                                        <td><a href="<?php echo base_url('order_view/'.$val->order_id);?>" class="btn btn-success btn-xs"><i class="fas fa-eye"></i> View</a></td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-transparent">
                            <div class="row">

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">

                    <div id="sparkline-1" style="display: none;"></div>
                    <div id="sparkline-2" style="display: none;"></div>
                    <div id="sparkline-3" style="display: none;"></div>


                    <!-- Calendar -->
                    <div class="card bg-gradient-success">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                            </h3>
                            <!-- tools card -->
                            <div class="card-tools">
                                <!-- button with a dropdown -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown" data-offset="-52">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a href="#" class="dropdown-item">Add new event</a>
                                        <a href="#" class="dropdown-item">Clear events</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View calendar</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <!--The calendar -->
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>

    </script>
<?= $this->endSection() ?>