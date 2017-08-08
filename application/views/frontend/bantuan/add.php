<div class="col-md-9">
<?php 
// print_r($this->session->userdata());
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                	<h3 class="box-title">Pantau Insiden</h3>
                	<hr class="hrdot">
                	<h3 class="box-title"><?php echo $insiden['nama']; ?></h3><br>
                	oleh : <?php echo $insiden['organisasi']; ?>
                </div><!-- /.box-header -->

                <div class="box-body">
                	<div class="row">
                		<div class="col-xs-4">Korban Bencana</div>
                		<div class="col-xs-8"><?php echo $insiden['korban']; ?> Jiwa</div>
                	</div>
                	<div class="row">
                		<div class="col-xs-4">Nilai yang dibutuhkan</div>
                		<div class="col-xs-8">Rp. <?php echo $insiden['dana_estimasi']; ?></div>
                	</div>
                	<div class="row">
                		<div class="col-xs-4">Nilai Bantuan Terkumpul</div>
                		<div class="col-xs-8">Rp. 0</div>
                	</div>
                	<div class="row">
                		<div class="col-xs-4">Tanggal dibuat insiden</div>
                		<div class="col-xs-8"><?php echo $insiden['created_at'] ?></div>
                	</div>
                	<div class="row">
                		<div class="col-xs-4">Estimasi insiden berakhir</div>
                		<div class="col-xs-8"><?php echo $insiden['estimasi'] ?></div>
                	</div>
                	<div class="clearfix"></div><br><br>

                	<h3 class="box-title">Bantuan <?php echo $tipe ?> yang bisa diberikan</h3>
                	<hr class="hrdot">
                    <?php 
                    if (count($error_msg) > 0) {
                        foreach ($error_msg as $value) {
                            echo $value;
                        }
                    }
                    ?>
                    <form method="post" action="<?php echo $action ?>">
                        <?php 
                        foreach ($kebutuhan as $row) {
                        ?>
                            <div class="form-group">
                                <label for="kebutuhan"><?php echo $row['item'] ?></label><br>
                                <label for="kebutuhan">Butuh <?php echo $row['quantity'].' '.$row['satuan']; ?></label><br>
                                <label for="kebutuhan">Rp <?php echo $row['harga_satuan'] ?>/<?php echo $row['satuan'] ?></label>
                                <input type="number" class="form-control" name="kebutuhan[<?php echo $row['id_kebutuhan'] ?>]">
                            </div>
                        <?php
                        }
                        ?><br>
                        <hr class="hrdot">
                        <div class="form-group">
                            <label for="tanya">Anda bisa mengantar bantuan ke titik drop off?</label>
                            <select id="dropPostCheck" class="form-control" name="dropPostCheck">
                                <option value="bisa">Bisa</option>
                                <option value="tidak">Tidak Bisa</option>
                            </select>
                        </div>

                        <div id="dropoff-location">
                            <div class="form-group">
                                <label for="dropoff">Pilihan Drop off</label>
                                <?php echo form_dropdown('id_poslogistik', $pos, "", 'class="form-control" id="id_poslogistik"'); ?>
                            </div>
                        </div>

                        <div id="non-dropoff-location" style="display:none;">
                            <div class="form-group">
                                <label for="alamat">Alamat Anda</label>
                                <textarea name="alamat" id="alamat" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="transportasi">Angkutan yang diperlukan</label>
                                <select id="transportasi" class="form-control" name="transportasi">
                                    <option value="">--- Pilih Angkutan ---</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Perahu Karet">Perahu Karet</option>
                                    <option value="Mobil Bak">Mobil Bak</option>
                                    <option value="Truk">Truk</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo $cancel_btn ?>" class="btn btn-danger">Cancel</a>
                    </form>
                </div>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>