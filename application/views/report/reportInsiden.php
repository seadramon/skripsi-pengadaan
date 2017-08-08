<<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Bantuin</title>
        <meta name="author" content="Damar">
        <meta name="description" content="Mitigasi Bencana">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="developer" content="Damar Bantuin">

        <!-- STYLESHEETS -->
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() ?>assets/frontend/css/shop-item.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/frontend/js/datepicker/datepicker3.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/frontend/js/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">

        <link href="<?=assets_folder('admin')?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
        	tr, td {
        		padding: 2px;
        	}
        </style>
    </head>
<body>

<div class="row">
        <div class="col-xs-12">
            <!-- <div class="box"> -->
            	<h3 class="box-title">Laporan Insiden</h3>
            	<p>Tanggal : <?php echo $param['start'].' s/d '.$param['end']; ?></p>


                <div class="box-body">
                	<?php 
                	foreach ($insiden as $valInsiden) {
                	?>
                		<h4><?php echo $valInsiden['nama']; ?></h4>
                		oleh : <?php echo $valInsiden['organisasi'].' '.date("Y-m-d",strtotime($valInsiden['created_at'])) ?><br>

	                	<table>
	                		<tr>
	                			<td>Kategori</td>
	                			<td>:</td>
	                			<td><?php echo $valInsiden['kategori']; ?></td>
	                		</tr>
	                		<tr>
	                			<td>Fase</td>
	                			<td>:</td>
	                			<td><?php echo $valInsiden['fase']; ?></td>
	                		</tr>
	                		<tr>
	                			<td>Alamat</td>
	                			<td>:</td>
	                			<td><?php echo $valInsiden['alamat']; ?></td>
	                		</tr>
	                		<tr>
	                			<td>Korban Bencana</td>
	                			<td>:</td>
	                			<td><?php echo $valInsiden['korban']; ?> Jiwa</td>
	                		</tr>
	                		<tr>
	                			<td>Estimasi Berakhir</td>
	                			<td>:</td>
	                			<td><?php echo $valInsiden['estimasi']; ?> Jiwa</td>
	                		</tr>
	                		<tr>
	                			<td>Nilai yang dibutuhkan</td>
	                			<td>:</td>
	                			<td>Rp. <?php echo number_format($valInsiden['dana_estimasi'], 0, ".", "."); ?></td>
	                		</tr>
	                	</table>
	                	<!-- KEBUTUHAN -->
	                	<h4>Kebutuhan</h4>
	                	<table width="100%" border="1">
                			<tr style="background-color:#dddddd">
                				<td><b>Kebutuhan</b></td>
                				<td><b>Jumlah</b></td>
                			</tr>
	                	<?php 
	                	foreach ($kebutuhan as $valKebutuhan) {
	                		if ($valKebutuhan['id_insiden']==$valInsiden['id_insiden']){
	                	?>
	                			<tr>
	                				<td><?php echo $valKebutuhan['item'] ?></td>
	                				<td><?php echo $valKebutuhan['quantity'].' '.$valKebutuhan['satuan']; ?></td>
	                			</tr>
	                	<?php 
	                		}
	                	}
	                	?>
	                	</table>
	                	<!-- POSKO -->
	                	<h4>Posko</h4>
	                	<table width="100%" border="1">
	                		<tr style="background-color:#dddddd">
                				<td><b>Koordinator</b></td>
                				<td><b>Alamat</b></td>
                			</tr>
                			<?php 
                			foreach ($pos as $valpos) {
                				if ($valpos['id_insiden']==$valInsiden['id_insiden']){
                			?>
                				<tr>
                					<td><?php echo $valpos['korlog'] ?></td>
                					<td><?php echo $valpos['alamat'] ?></td>
                				</tr>
                			<?php
                				}
                			}
                			?>
                		</table>
                		<hr>
                	<?php
                	}
                	?>
                </div>

            <!-- </div> --><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</body>
</html>