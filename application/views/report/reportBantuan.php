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
            	<h3 class="box-title">Laporan Penerimaan Bantuan</h3>
                <p><?php echo $donasi[0]['nama']; ?><br>
                oleh : <?php echo $donasi[0]['organisasi']; ?></p>

                <div class="box-body">
                    <table width="100%" border="1">
                        <tr style="background-color:#dddddd">
                            <td>No.</td>
                            <td>Kolaborator</td>
                            <td>Jenis Kebutuhan</td>
                            <td>Jumlah</td>
                        </tr>
                	<?php 
                    $i = 1;
                	foreach ($donasi as $valDonasi) {
                	?>
                		<tr>
                            <td><?php echo $i ?></td>
                			<td><?php echo $valDonasi['donatur']; ?></td>
                			<td><?php echo $valDonasi['item'] ?></td>
                			<td><?php echo $valDonasi['quantity'].' '.$valDonasi['satuan'] ?></td>
                		</tr>
                	<?php
                    $i++;
                	}
                	?>
                    </table>
                </div>

            <!-- </div> --><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</body>
</html>