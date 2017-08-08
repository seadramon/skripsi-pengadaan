<?php //$this->load->view(admin_folder() . '/layout/header')?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> Home</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            
        </div><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <h2>Hello, <?php echo $user['nama']; ?></h2>
                <h4>Anda Login Sebagai : <?php echo $all['group_name'] ?></h4>
                <!-- Custom tabs (Charts with tabs)-->
                

                <!-- Chat box -->
                <!-- /.box (chat box) -->

                <!-- TO DO List -->
                <!-- /.box -->

                <!-- quick email widget -->
                

            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <!-- <section class="col-lg-5 connectedSortable"> -->

                <!-- Map box -->
                <!-- /.box -->

                <!-- solid sales graph -->
                <!-- /.box -->

                <!-- Calendar -->
                <!-- /.box -->

            <!-- </section> --><!-- right col -->
        </div><!-- /.row (main row) -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view(admin_folder() . '/layout/footer')?>