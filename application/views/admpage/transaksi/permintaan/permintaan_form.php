<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Form Permintaan</h3>
                        {success_msg}
                        {failed_msg}
                        {error_msg}
                            {warning}
                            {nik}

                            {idbarang}
                            {jumlah}
                            {tanggal_pengiriman}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="permintaanForm" name="permintaanForm" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">ID Minta</label>
                                <input type="text" class="form-control" name="idminta" id="idminta" readonly value="<?php echo $id ?>">
                            </div>
                            <div class="form-group">
                                <label for="group">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik" readonly value="<?php echo $nik ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Deskripsi</label>
                                <textarea id="desk" class="form-control" name="deskripsi"><?php echo isset($post[0]['deskripsi'])?$post[0]['deskripsi']:""; ?></textarea>
                            </div>

                            <br>
                            <h4 class="box-title">Detail Permintaan</h4>

                            <?php 
                            if ($mode=="add") {
                            ?>
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="name">ID Barang</label>
                                        <input type="text" class="form-control" name="idbarang_0" id="idbarang" value="" readonly>
                                        <input type="button" name="cariBrg" onClick='targetitem = document.permintaanForm.idbarang_0; 
     dataitem = window.open("<?php echo base_url() ?>admpage/showtable/barang",
     "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Barang">
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="group">Jumlah</label>
                                        <input type="number" class="form-control" name="dpermintaan[0][jumlah]" id="jumlah" value="">
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="group">Tgl Pengiriman</label>
                                        <input type="text" readonly class="form-control date-picker" data-date-format="yyyy-mm-dd" name="dpermintaan[0][tanggal_pengiriman]" value="">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="name">Keterangan</label>
                                        <textarea class="form-control" name="dpermintaan[0][keterangan]"></textarea> 
                                    </div>
                                    <div class="col-xs-1">
                                        <br>
                                        <button type="button" class="btn btn-default addButtonPermintaan"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            <?php 
                            } else {
                            ?>
                                <input type="hidden" id="maxbookIndex" value="<?php echo count($post) - 1 ?>">
                            <?php
                                $i = 0;
                                foreach ($post as $row) {
                            ?>
                                    <div class="form-group" <?php if ($i>0) echo "data-book-index='1'" ?>>
                                        <div class="col-xs-3">
                                            <label for="name">ID Barang</label>
                                            <input type="text" class="form-control" name="idbarang_<?php echo $i ?>" id="idbarang" value="<?php echo isset($row['idbarang'])?$row['idbarang']:""; ?>" readonly>
                                            <input type="button" name="cariBrg" onClick='targetitem = document.permintaanForm.idbarang_<?php echo $i ?>; 
         dataitem = window.open("<?php echo base_url() ?>admpage/showtable/barang",
         "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Barang">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="group">Jumlah</label>
                                            <input type="number" class="form-control" name="dpermintaan[<?php echo $i ?>][jumlah]" id="jumlah" value="<?php echo isset($row['jumlah'])?$row['jumlah']:""; ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="group">Tgl Pengiriman</label>
                                            <input type="text" readonly class="form-control date-picker" data-date-format="yyyy-mm-dd" name="dpermintaan[<?php echo $i ?>][tanggal_pengiriman]" value="<?php echo isset($row['tanggal_pengiriman'])?$row['tanggal_pengiriman']:""; ?>">
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="name">Keterangan</label>
                                            <textarea class="form-control" name="dpermintaan[<?php echo $i ?>][keterangan]"><?php echo isset($row['keterangan'])?$row['keterangan']:""; ?></textarea> 
                                        </div>
                                        <div class="col-xs-1">
                                            <br>
                                            <?php 
                                            if ($i==0) {
                                            ?>
                                                <button type="button" class="btn btn-default addButtonPermintaan"><i class="fa fa-plus"></i></button>
                                            <?php 
                                            } else {
                                            ?>
                                                <button type="button" class="btn btn-default removeButtonPermintaan"><i class="fa fa-minus"></i></button>
                                            <?php 
                                            }
                                            ?>
                                        </div>
                                    </div>
                            <?php 
                                    $i++;
                                }
                            }
                            ?>

                            <div class="form-group hide" id="permintaanTemplate">
                                <div class="col-xs-3">
                                    <label for="name">ID Barang</label>
                                    <input type="text" class="form-control" name="idbarang_Clone" value="" readonly>
                                    <input type="button" name="cariBrg" onClick='targetitem = document.permintaanForm.idbarang; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/barang",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Barang">
                                </div>
                                <div class="col-xs-2">
                                    <label for="group">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="">
                                </div>
                                <div class="col-xs-2">
                                    <label for="group">Tgl Pengiriman</label>
                                    <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" name="tanggal_pengiriman" value="">
                                </div>
                                <div class="col-xs-4">
                                    <label for="name">Keterangan</label>
                                    <textarea class="form-control" name="keterangan"></textarea>    
                                </div>
                                <div class="col-xs-1">
                                    <br>
                                    <button type="button" class="btn btn-default removeButtonPermintaan"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col-md-6 -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function popup (url) {
        win = window.open(url, "window1", "width=600,height=400,status=yes,scrollbars=yes,resizable=yes");
        win.focus();
    }
</script>
