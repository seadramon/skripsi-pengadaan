<div class="col-md-9">
<?php 
// print_r($this->session->userdata());
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Preview Insiden</h3>
                    <hr class="hrdot">
                    <h3 class="box-title"><?php echo $insiden['nama']; ?></h3><br>
                    oleh : <?php echo $insiden['organisasi']; ?>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <img src="<?php echo base_url() ?>documents/insiden/<?php echo $insiden['image']; ?>"><br>
                    <p><?php echo $insiden['deskripsi']; ?></p><br>

                    <div class="row">
                        <div class="col-xs-4">Nama Insiden</div>
                        <div class="col-xs-8"><?php echo $insiden['nama']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">Kategori</div>
                        <div class="col-xs-8"><?php echo $insiden['kategori']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">Fase</div>
                        <div class="col-xs-8"><?php echo $insiden['fase']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">Lokasi Insiden</div>
                        <div class="col-xs-8"><?php echo $insiden['alamat']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">Estimasi Korban</div>
                        <div class="col-xs-8"><?php echo $insiden['korban']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">Estimasi Berakhir</div>
                        <div class="col-xs-8"><?php echo $insiden['estimasi']; ?></div>
                    </div>
                    <div class="clearfix"></div><br><br>

                    <h4 class="box-title">Bantuan yang dibutuhkan</h4>
                    <hr>
                    <?php
                    foreach ($tipe as $tipenya) {
                        if ($tipenya['nama']!='Dana') {
                    ?>
                            <h4><?php echo $tipenya['nama'] ?></h4>
                            <hr class="hrdot">
                            <div class="row">
                                <div class="col-xs-2"><label>Kebutuhan</label></div>
                                <div class="col-xs-2"><label>Jumlah</label></div>
                                <div class="col-xs-2"><label>Harga Satuan<label></div>
                                <div class="col-xs-2"><label>Total</label></div>
                                <!-- isset($data['qtyDana'])?number_format($data['qtyDana'], 0, ".", "."):"0"; -->
                            </div>
                    <?php
                        }
                        foreach ($kebutuhan as $value) {
                            if ($value['tipe']==$tipenya['nama']) {
                    ?>
                            <div class="row">
                                <div class="col-xs-2"><?php echo $value['item']; ?></div>
                                <div class="col-xs-2"><?php echo $value['quantity'].' '.$value['satuan'] ?></div>
                                <div class="col-xs-2">Rp <?php echo number_format($value['harga_satuan'], 0, ".", ".") ?></div>
                                <div class="col-xs-2">Rp <?php echo number_format($value['unit_price'], 0, ".", ".") ?></div>
                            </div>
                    <?php
                            }
                        }
                    }
                    ?>
                    <br><br>

                    <h4 class="box-title">Pos Logistik</h4>
                    <hr class="hrdot">
                        <div class="row">
                            <div class="col-xs-4"><label>Nama Pos</label></div>
                            <div class="col-xs-4"><label>Lokasi/Alamat</label></div>
                            <div class="col-xs-4"><label>Korlog</label></div>
                        </div>
                        <?php 
                        foreach ($posko as $value) {
                        ?>
                            <div class="row">
                                <div class="col-xs-4"><?php echo $value['nama'] ?></div>
                                <div class="col-xs-4"><?php echo $value['alamat'] ?></div>
                                <div class="col-xs-4"><?php echo $value['nama_user'] ?></div>
                            </div>
                        <?php 
                        }
                        ?>
                    <br>
                    <h4>Konfirmasi Insiden</h4>
                    <hr class="hrdot">
                    <form method="post" action="<?php echo $action ?>">
                        <input type="hidden" name="id_insiden" value="<?php echo $insiden['id_insiden'] ?>">
                        <div class="form-group">
                            <label for="keterangan">Status</label>
                            <select name="status" class="form-control">
                                <option value="publish">Publish</option>
                                <option value="hide">Unpublish</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo $cancel_btn ?>" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>