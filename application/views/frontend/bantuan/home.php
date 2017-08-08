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
                		<div class="col-xs-8">Rp. <?php echo number_format($insiden['dana_estimasi'], 0, ".", "."); ?></div>
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

                	<h3 class="box-title">Pilih Tipe Bantuan</h3>
                	<hr class="hrdot">                	
                		<?php 
	                	foreach ($kebutuhan as $row) {
	                	?>
	                		<a class="btn btn-default" href="<?php echo base_url() ?>bantuan/add/<?php echo $row['id_tipe'].'/'.$insiden['id_insiden']; ?>" role="button"><?php echo $row['tipe'] ?></a>
	                	<?php 
	                	}
	                	?>
	                	<a class="btn btn-default" href="<?php echo base_url() ?>bantuan/homeDana/<?php echo $insiden['id_insiden']; ?>" role="button">Dana</a>
                </div>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>