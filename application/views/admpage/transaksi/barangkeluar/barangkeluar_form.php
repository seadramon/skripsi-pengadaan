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
                        <h3 class="box-title">Form Barang Keluar</h3>
                        {success_msg}
                        {failed_msg}
                        {error_msg}
                            {warning}
                            {idminta}
                            {tanggal}
                            {keterangan}

                            {idbarang}
                            {jumlah}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="fbarangkeluar" name="fbarangkeluar" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">ID Barang Keluar</label>
                                <input type="text" class="form-control" name="idbarangkeluar" id="idbarangkeluar" value="<?php echo $id; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">ID Minta</label>
                                <input type="text" class="form-control" name="idminta" id="idminta" value="<?php echo isset($post[0]['idminta'])?$post[0]['idminta']:""; ?>" readonly>
                                <input type="button" onClick='targetitem = document.fbarangkeluar.idminta; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/permintaan",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Permintaan">
                            </div>
                            <div class="form-group">
                                <label for="group">Tanggal</label>
                                <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="tanggal" id="tanggal" value="<?php echo isset($post[0]['tanggal'])?$post[0]['tanggal']:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Keterangan</label>
                                <textarea class="form-control" name="keterangan"><?php echo isset($post[0]['keterangan'])?$post[0]['keterangan']:""; ?></textarea>
                            </div>

                            <h4 class="box-title">Form Detail Barang Keluar</h4>

                            <?php 
                            if ($mode=="add") {
                            ?>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label for="name">ID Barang</label>
                                        <input type="text" class="form-control" id="idbarang_0" name="dbarangkeluar[0][idbarang]" readonly>
                                        <input type="button" name="crBrg" onClick="selectBarangkeluar('idbarang_0-jumlahhide_0')" value="Cari Barang">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="group">Jumlah</label>
                                        <input type="hidden" class="form-control" name="dbarangkeluar[0][jumlahhide]" id="jumlahhide_0">
                                        <input type="number" class="form-control" name="dbarangkeluar[0][jumlah]" id="jumlah_0" value="">
                                    </div>
                                    <div class="col-xs-2">
                                        <br>
                                        <button type="button" class="btn btn-default addButtonBarangkeluar"><i class="fa fa-plus"></i></button>
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
                                    <div class="form-group">
                                        <div class="col-xs-4">
                                            <label for="name">ID Barang</label>
                                            <input type="text" class="form-control" id="idbarang_<?php echo $i ?>" name="dbarangkeluar[<?php echo $i ?>][idbarang]" value="<?php echo isset($row['idbarang'])?$row['idbarang']:""; ?>" readonly>
                                            <input type="button" name="crBrg" onClick="selectBarangkeluar('idbarang_0-jumlahhide_0')" value="Cari Barang">
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="group">Jumlah</label>
                                            <input type="hidden" class="form-control" name="dbarangkeluar[<?php echo $i ?>][jumlahhide]" id="jumlahhide_<?php echo $i ?>" value="<?php echo isset($row['jumlah'])?$row['jumlah']:""; ?>">
                                            <input type="number" class="form-control" name="dbarangkeluar[<?php echo $i ?>][jumlah]" id="jumlah_<?php echo $i ?>" value="<?php echo isset($row['jumlah'])?$row['jumlah']:""; ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <br>
                                            <button type="button" class="btn btn-default addButtonBarangkeluar"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                            <?php 
                                    $i++;
                                }
                            }
                            ?>

                            <div class="form-group hide" id="barangkeluarTemplate">
                                <div class="col-xs-4">
                                    <label for="name">ID Barang</label>
                                    <input type="text" class="form-control" id="idbarang" name="idbarang" id="idbarang" value="" readonly>
                                    <input type="button" name="crBrg" onClick="selectBarangkeluar()" value="Cari Barang">
                                </div>
                                <div class="col-xs-4">
                                    <label for="group">Jumlah</label>
                                    <input type="hidden" class="form-control" name="jumlahhide" id="jumlahhide">
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="">
                                </div>
                                <div class="col-xs-2">
                                    <br>
                                    <button type="button" class="btn btn-default removeButtonBarangkeluar"><i class="fa fa-minus"></i></button>
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
    function selectValue(id) {
        window.open('<?php echo base_url() ?>admpage/showtable/barangkeluar/index/' + id,'popuppage',
      'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
    }

    function updateValue(id, value, idjml, valuejml) {
        document.getElementById(id).value = value;
        document.getElementById(idjml).value = valuejml;
    }
</script>
