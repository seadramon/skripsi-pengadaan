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

                    <form method="post" action="<?php echo $action ?>">
                        <div class="form-group">
                            <label for="jumlah">Jumlah Dana</label>
                            <input type="number" class="form-control" name="quantity" id="quantity">
                        </div>
                        <div class="form-group">
                            <label for="dropoff">Bank Tujuan</label>
                            <?php echo form_dropdown('id_organisasi_bank', $bank, "", 'class="form-control" id="id_organisasi_bank"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Bank Asal</label>
                            <input type="text" class="form-control" name="originating_bank" id="originating_bank">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Nomor Akun</label>
                            <input type="number" class="form-control" name="nomor_akun" id="nomor_akun">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Tanggal Transfer</label>
                            <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" name="trf_date" id="trf_date">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Keterangan</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo $cancel_btn ?>" class="btn btn-danger">Cancel</a>
                    </form>
                </div>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>