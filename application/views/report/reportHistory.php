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
            	<h3 class="box-title">Laporan History Pemberi Bantuan</h3>
                <p>Tanggal <?php echo $param['start'].' s/d ' .$param['end']; ?></p>

                <div class="box-body">
                    <table width="100%" border="1">
                        <tr style="background-color:#dddddd">
                            <td>No.</td>
                            <td>PemberiBantuan</td>
                            <td>Phone</td>
                            <td>Email</td>
                            <td>Tipe Bantuan</td>
                            <td>Jenis/Jumlah</td>
                        </tr>
                	<?php 
                    $i = 1;
                    $total = 0;
                    if (count($nonfund) > 0) {
	                	foreach ($nonfund as $valnonfund) {
	                	?>
	                		<tr>
	                            <td><?php echo $i ?></td>
	                			<td><?php echo $valnonfund['user']; ?></td>
	                			<td><?php echo $valnonfund['phone'] ?></td>
	                			<td><?php echo $valnonfund['email'] ?></td>
	                			<td><?php echo $valnonfund['tipe'] ?></td>
	                			<td><?php echo $valnonfund['item'].' '.$valnonfund['quantity_received'].' '.$valnonfund['satuan']  ?></td>
	                		</tr>
	                	<?php
	                    $i++;
	                    }
	                } 
	                if (count($fund) > 0) {
	                    foreach ($fund as $valfund) {
	                    ?>
	                    	<tr>
	                            <td><?php echo $i ?></td>
	                			<td><?php echo $valfund['user']; ?></td>
	                			<td><?php echo $valfund['phone'] ?></td>
	                			<td><?php echo $valfund['email'] ?></td>
	                			<td><?php echo $valfund['tipe'] ?></td>
	                			<td><?php echo 'Rp. '.number_format($valfund['quantity'], 0, ".", ".") ?></td>
	                		</tr>
	                    <?php 
	                    $i++;
	                    }
                	}
                	?>
                    </table>
                </div>

            <!-- </div> --><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</body>
</html>