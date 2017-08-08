
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
                        <h3 class="box-title">Form Order Pembelian</h3>
                        {success_msg}
                        {failed_msg}
                        {error_msg}
                            {warning}
                            {idpo}
                            {idminta}
                            {idsupplier}
                            {tanggal}
                            {deskripsi}
                            {total}

                            {idpo}
                            {idbarang}
                            {jumlah}
                            {harga_satuan}
                            {jumlah_harga}
                            {tanggal_pengiriman}
                            {keterangan}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="fpo" name="fpo" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">ID PO</label>
                                <input type="text" class="form-control" name="idpo" id="idpo" value="<?php echo $id ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">ID Permintaan</label>
                                <input type="text" class="form-control" name="idminta" id="idminta" value="<?php echo isset($post[0]['idminta'])?$post[0]['idminta']:""; ?>" readonly>
                                <input type="button" onClick='targetitem = document.fpo.idminta; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/permintaan",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Permintaan">
                            </div>
                            <div class="form-group">
                                <label for="name">Supplier</label>
                                <input type="text" class="form-control" name="idsupplier" id="idsupplier" value="<?php echo isset($post[0]['idsupplier'])?$post[0]['idsupplier']:""; ?>" readonly>
                                <input type="button" onClick='targetitem = document.fpo.idsupplier; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/supplier",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem' value="Cari Supplier">
                            </div>
                            <div class="form-group">
                                <label for="group">Tanggal</label>
                                <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="tanggal" id="tanggal" value="<?php echo isset($post[0]['tanggal'])?$post[0]['tanggal']:""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi"><?php echo isset($post[0]['deskripsi'])?$post[0]['deskripsi']:""; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Total</label>
                                <input type="text" class="form-control" name="total" id="total" value="<?php echo isset($post[0]['total'])?$post[0]['total']:0; ?>" readonly>
                            </div>

                            <br>
                            <h4 class="box-title">Detail Order Pembelian</h4>

                            <?php 
                            if ($mode=="add") {
                            ?>
                                <div class="form-group">
                                    <fieldset>
                                        <legend>#</legend>
                                        <div class="col-xs-2">
                                            <label for="name">ID Barang</label>
                                            <input type="text" class="form-control" id="idbarang_0" name="dpo[0][idbarang]" id="idbarang_0" value="<?php echo isset($row['idbarang'])?$row['idbarang']:""; ?>">
                                            <input type="button" name="crBrg" onClick="selectBarangminta('idbarang_0-jumlah_0')" value="Cari Barang">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="group">Jumlah</label>
                                            <input type="number" class="form-control" name="dpo[0][jumlah]" id="jumlah_0" value="<?php echo isset($row['jumlah'])?$row['jumlah']:""; ?>">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="group">Harga Satuan</label>
                                            <input type="number" class="form-control" name="dpo[0][harga_satuan]"  onkeyup="subtotalPo(this, 'jumlah_0', 'jumlahharga_0')" id="harga_satuan" value="<?php echo isset($row['harga_satuan'])?$row['harga_satuan']:""; ?>">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="group">Jumlah Harga</label>
                                            <input type="number" class="form-control" name="dpo[0][jumlah_harga]" id="jumlahharga_0" value="<?php echo isset($row['jumlah_harga'])?$row['jumlah_harga']:""; ?>">
                                        </div>
                                        <div class="col-xs-1">
                                            <br>
                                            <button type="button" class="btn btn-default addButtonPO"><i class="fa fa-plus"></i></button>
                                        </div>

                                        <div class="col-xs-3">
                                            <br>
                                            <label for="group">Tgl Pengiriman</label>
                                            <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="dpo[0][tanggal_pengiriman]" id="tanggal_pengiriman" value="<?php echo isset($row['tanggal_pengiriman'])?$row['tanggal_pengiriman']:""; ?>">
                                        </div>
                                        <div class="col-xs-3">
                                            <br>
                                            <label for="name">Keterangan</label>
                                            <textarea class="form-control" name="dpo[0][keterangan]"><?php echo isset($row['keterangan'])?$row['keterangan']:""; ?></textarea>
                                        </div>
                                    </fieldset>
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
                                        <fieldset>
                                            <legend>#</legend>
                                            <div class="col-xs-2">
                                                <label for="name">ID Barang</label>
                                                <input type="text" class="form-control" id="idbarang_<?php echo $i ?>" name="dpo[<?php echo $i ?>][idbarang]" value="<?php echo isset($row['idbarang'])?$row['idbarang']:""; ?>">
                                                <input type="button" name="crBrg" onClick="selectBarangminta('idbarang_<?php echo $i ?>-jumlah_<?php echo $i ?>')" value="Cari Barang">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="group">Jumlah</label>
                                                <input type="number" class="form-control" name="dpo[<?php echo $i ?>][jumlah]" id="jumlah_<?php echo $i ?>" value="<?php echo isset($row['jumlah'])?$row['jumlah']:""; ?>">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="group">Harga Satuan</label>
                                                <input type="number" class="form-control" name="dpo[<?php echo $i ?>][harga_satuan]"  onkeyup="subtotalPo(this, 'jumlah_<?php echo $i ?>', 'jumlahharga_<?php echo $i ?>')" id="harga_satuan" value="<?php echo isset($row['harga_satuan'])?$row['harga_satuan']:""; ?>">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="group">Jumlah Harga</label>
                                                <input type="number" class="form-control" name="dpo[<?php echo $i ?>][jumlah_harga]" id="jumlahharga_<?php echo $i ?>" value="<?php echo isset($row['jumlah_harga'])?$row['jumlah_harga']:""; ?>">
                                            </div>
                                            <div class="col-xs-1">
                                                <br>
                                                <?php 
                                                if ($i==0) {
                                                ?>
                                                    <button type="button" class="btn btn-default addButtonPO"><i class="fa fa-plus"></i></button>
                                                <?php 
                                                } else {
                                                ?>
                                                    <button type="button" class="btn btn-default removeButtonPO"><i class="fa fa-minus"></i></button>
                                                <?php 
                                                }
                                                ?>
                                            </div>

                                            <div class="col-xs-3">
                                                <br>
                                                <label for="group">Tgl Pengiriman</label>
                                                <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="dpo[<?php echo $i ?>][tanggal_pengiriman]" id="tanggal_pengiriman" value="<?php echo isset($row['tanggal_pengiriman'])?$row['tanggal_pengiriman']:""; ?>">
                                            </div>
                                            <div class="col-xs-3">
                                                <br>
                                                <label for="name">Keterangan</label>
                                                <textarea class="form-control" name="dpo[<?php echo $i ?>][keterangan]"><?php echo isset($row['keterangan'])?$row['keterangan']:""; ?></textarea>
                                            </div>
                                        </fieldset>
                                    </div>
                            <?php 
                                    $i++;
                                }
                            }
                            ?>


                            <!-- CLONER -->
                            <div class="form-group hide" id="poTemplate">
                                <fieldset>
                                    <legend id="groupDetail">#</legend>
                                    <div class="col-xs-2">
                                        <label for="name">ID Barang</label>
                                        <input type="text" class="form-control" class="idbarang" id="idbarang" name="idbarang" id="idbarang" value="">
                                        <input type="button" name="crBrg" onClick="selectBarangminta()" value="Cari Barang">
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="group">Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah" id="jumlah" value="{jumlah}">
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="group">Harga Satuan</label>
                                        <input type="number" class="form-control" name="harga_satuan" id="harga_satuan" value="{harga_satuan}">
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="group">Jumlah Harga</label>
                                        <input type="number" class="form-control" name="jumlah_harga" id="jumlahharga" value="{jumlah_harga}">
                                    </div>
                                    <div class="col-xs-1">
                                        <br>
                                        <button type="button" class="btn btn-default removeButtonPO"><i class="fa fa-minus"></i></button>
                                    </div>

                                    <div class="col-xs-3">
                                        <br>
                                        <label for="group">Tgl Pengiriman</label>
                                        <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="tanggal_pengiriman" id="tanggal_pengiriman" value="">
                                    </div>
                                    <div class="col-xs-3">
                                        <br>
                                        <label for="name">Keterangan</label>
                                        <textarea class="form-control" name="keterangan"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <?php 
                                if ($mode=="edit") {
                                ?>
                                    <a href="<?php echo base_url() ?>admpage/po/dokumen/<?php echo $id ?>" target="_blank" class="btn btn-success">Cetak</a>
                                <?php 
                                } else {
                                ?>
                                    <a href="#" target="_blank" class="btn btn-success disabled">Cetak</a>
                                <?php 
                                }
                                ?>
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
