<html>
<head>
	<title>Laporan Barang Masuk</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Barang Masuk</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
Status		: <?php echo $status ?><br>
<table border="1" width="100%">
	<thead>
        <tr>
            <th>ID Penerimaan</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <!-- <th>Status</th> -->
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row['idpenerimaan'];  ?></td>
                <td><?php echo $row['tanggal'];  ?></td>
                <td><?php echo $row['barang'];  ?></td>
                <td><?php echo $row['jumlah'];  ?></td>
                <!-- <td><?php echo $row['status'];  ?></td> -->
            </tr>
        <?php 
        }
        ?>
    </tbody>
</table>

</body>
</html>