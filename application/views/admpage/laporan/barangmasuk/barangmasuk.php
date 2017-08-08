<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Barang Masuk
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <?php 
                    echo $errStart;
                    echo $errEnd;
                    ?>
                    <div class="box-header">
                        <h3 class="box-title">Laporan Barang Masuk</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="customer" name="customer" action="" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-1 control-label">Periode Dari:</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="start" id="tanggal" value="">
                                </div>
                                <label for="name" class="col-md-1 control-label">Sampai:</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="end" id="tanggal" value="">
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <a href="<?php echo base_url() ?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->

            </div><!--/.col -->
        </div>   <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Barang Masuk</h3>
                    </div><!-- /.box-header -->
                    <table id="dataTable_id" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Penerimaan</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <!-- <th>Status</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($data as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['idpenerimaan'];  ?></td>
                                    <td><?php echo $row['tanggal'];  ?></td>
                                    <td><?php echo $row['barang'];  ?></td>
                                    <td><?php echo $row['jumlah'];  ?></td>
                                    <!-- <td><?php echo $row['status'];  ?></td> -->
                                </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                    <form id="form-{file_app}" name="form-{file_app}" action="<?php echo $actionCetak ?>" method="post" >
                        <input type="hidden" name="start" value="<?php echo $start ?>">
                        <input type="hidden" name="end" value="<?php echo $end ?>">
                        <?php 
                        if ((is_array($data) && count($data) > 0) && ($start!="" && $end!="")) {
                        ?>
                            <div class="box-footer clearfix">
                                <input type="hidden" id="temp_id" value=""/>
                                <div class="pull-right">
                                    <!-- <button type="submit" class="btn btn-success">Cetak</button> -->
                                    <a href="<?php echo base_url() ?>admpage/laporan/barangmasuk/cetak/<?php echo $start.'/'.$end ?>" 
                                    class="btn btn-success" target="_blank">Cetak</a>
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function popup (url) {
        win = window.open(url, "window1", "width=600,height=400,status=yes,scrollbars=yes,resizable=yes");
        win.focus();
    }
</script>
