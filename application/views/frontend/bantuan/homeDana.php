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

                	<h3 class="box-title">Anda bisa menyumbang ke nomor-nomor rekening di bawah ini</h3>
                	<hr class="hrdot">
                    <?php 
                    foreach ($bank as $value) {
                    ?>
                      <dl>
                          <dt><?php echo strtoupper($value['bank']) ?></dt>
                          <dd><?php echo $value['cabang'] ?></dd>
                          <dd><?php echo $value['nomor_akun'] ?></dd>
                          <dd>a.n <?php echo $value['nama_akun'] ?></dd>
                      </dl>  
                    <?php
                    }
                    ?><br>
                    <a class="btn btn-primary" href="<?php echo base_url() ?>bantuan/addDana/<?php echo $insiden['id_insiden']; ?>" role="button">Konfirmasi Dana</a>
                </div>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>