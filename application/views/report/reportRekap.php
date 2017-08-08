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
            	<h2 class="box-title">Laporan Penggalangan Bantuan</h2>
                <h3><?php echo $insiden['nama']; ?></h3>
                oleh : <?php echo $insiden['organisasi']; ?>
                
                <h4>Uraian</h4>
                <table width="100%">
                    <tr>
                        <td>Korban Bencana</td>
                        <td>:</td>
                        <td><?php echo $insiden['korban']; ?> Jiwa</td>
                    </tr>
                    <tr>
                        <td>Nilai yang dibutuhkan</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($insiden['dana_estimasi'], 0, ".", "."); ?></td>
                    </tr>
                    <?php 
                        $bantuanTerkumpul = getBantuanTerkumpul($insiden['id_insiden']);
                        $totalTerkumpul = (int)$bantuanTerkumpul['nilaiBantuanDrop'] + (int)$bantuanTerkumpul['nilaiBantuanDana'];
                        ?>
                    <tr>
                        <td>Nilai Bantuan Terkumpul</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($totalTerkumpul, 0, ".", "."); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal dibuat insiden</td>
                        <td>:</td>
                        <td><?php echo $insiden['created_at'] ?></td>
                    </tr>
                    <tr>
                        <td>Estimasi insiden berakhir</td>
                        <td>:</td>
                        <td><?php echo $insiden['estimasi'] ?></td>
                    </tr>
                </table>
                <h4>Bantuan</h4>
                <b>Dana</b>
                <table width="100%">
                    <tr>
                        <td width="40%">Donasi Uang</td>
                        <td width="10%">:</td>
                        <td width="60%">Rp <?php echo isset($danaTerkumpul['qtyDana'])?number_format($danaTerkumpul['qtyDana'], 0, ".", "."):"0"; ?></td>
                    </tr>
                </table><br>
                <?php 
                foreach ($tipeKebutuhan as $grup) { 
                ?>
                    <b><?php echo $grup['tipe']; ?></b>
                    <table width="100%">
                    <?php 
                    foreach ($bantuanTerkumpulDrop as $value) {                        
                        if ($grup['tipe']==$value['tipe']) {
                    ?>
                        <tr>
                            <td width="40%"><?php echo $value['item'] ?></td>
                            <td width="10%">:</td>
                            <td width="50%"><?php echo $value['qtyBantuan'].'/'.$value['qtyKebutuhan'].' '.$value['satuan'] ?></td>
                        </tr>
                    <?php 
                        }
                    }
                    ?>
                    </table><br>
                <?php 
                }
                ?>
                <br>
                <h4>Pos</h4>
                <table width="100%" border="1">
                    <tr style="background-color:#dddddd">
                        <td>Koordinator</td>
                        <td>Nama Pos</td>
                        <td>Alamat</td>
                    </tr>
                    <?php 
                    foreach ($pos as $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['nama_user'] ?></td>
                        <td><?php echo $value['nama'] ?></td>
                        <td><?php echo $value['alamat'] ?></td>
                    </tr>
                    <?php 
                    }
                    ?>
                </table>
            <!-- </div> --><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</body>
</html>