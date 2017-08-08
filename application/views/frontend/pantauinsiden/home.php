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
                	<img src="<?php echo base_url() ?>documents/insiden/<?php echo $insiden['image']; ?>"><br>
                	<p><?php echo $insiden['deskripsi']; ?></p><br>

                	<div class="row">
                		<div class="col-xs-4">Korban Bencana</div>
                		<div class="col-xs-8"><?php echo $insiden['korban']; ?> Jiwa</div>
                	</div>
                	<div class="row">
                		<div class="col-xs-4">Nilai yang dibutuhkan</div>
                		<div class="col-xs-8">Rp. <?php echo number_format($insiden['dana_estimasi'], 0, ".", "."); ?></div>
                	</div>
                	<div class="row">
                        <?php 
                        $bantuanTerkumpul = getBantuanTerkumpul($insiden['id_insiden']);
                        $totalTerkumpul = (int)$bantuanTerkumpul['nilaiBantuanDrop'] + (int)$bantuanTerkumpul['nilaiBantuanDana'];
                        ?>
                		<div class="col-xs-4">Nilai Bantuan Terkumpul</div>
                		<div class="col-xs-8">Rp. <?php echo number_format($totalTerkumpul, 0, ".", "."); ?></div>
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

                	<h4 class="box-title">Bantuan</h4>
                	<hr class="hrdot">
                    <h4>Dana</h4>
                    <div class="row">
                        <div class="col-xs-4">Donasi Uang</div>
                        <div class="col-xs-8">Rp <?php echo isset($danaTerkumpul['qtyDana'])?number_format($danaTerkumpul['qtyDana'], 0, ".", "."):"0"; ?></div>
                    </div>
                    <?php 
                    if ($this->session->userdata('user')) {
                    ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url().'laporan/terimaDonasi/'.$insiden['id_insiden']; ?>" target="_blank">Cetak Laporan Dana Bantuan</a>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>
                    <?php 
                    foreach ($tipeKebutuhan as $grup) {
                            echo "<h4>".$grup['tipe']."</h4>";
                            foreach ($bantuanTerkumpulDrop as $value) {                        
                                if ($grup['tipe']==$value['tipe']) {
                    ?>
                                    <div class="row">
                                        <div class="col-xs-4"><?php echo $value['item'] ?></div>
                                        <div class="col-xs-8"><?php echo $value['qtyBantuan'].'/'.$value['qtyKebutuhan'].' '.$value['satuan'] ?></div>
                                    </div>
                    <?php
                                }
                            }
                    }
                    ?>
                    <?php 
                    if ($this->session->userdata('user')) {
                    ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url().'laporan/terimaBantuan/'.$insiden['id_insiden']; ?>" target="_blank">Cetak Laporan Penerimaan Bantuan</a>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>
                    <br><br>

                	<a class="btn btn-success" href="<?php echo base_url() ?>bantuan/index/<?php echo $insiden['id_insiden'] ?>" role="button">Bantu</a>
                	<a class="btn btn-info" target="_blank" href="<?php echo base_url().'laporan/rekap/'.$insiden['id_insiden'] ?>" role="button">Report</a>
                	<a class="btn btn-primary" target="_blank" href="<?php echo base_url().'laporan/penyaluran/'.$insiden['id_insiden'] ?>" role="button">Laporan Penyaluran</a><br><br>

                	<h4 class="box-title">Pos Logistik</h4>
                	<hr class="hrdot">
                	<ul>
                		<?php 
                		foreach ($pos as $value) {
                		?>
                			<li><?php echo $value['nama'] ?></li>
                		<?php 
                		}
                		?>
                	</ul>
                </div>

            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>