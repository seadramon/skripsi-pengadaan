<html>
<head>
	<title>Laporan Barang Keluar</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Barang Keluar</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
<table border="1" width="100%">
	<thead>
        <tr>
            <th>ID BarangKeluar</th>
            <th>ID Minta</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Ket</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row['idbarangkeluar'];  ?></td>
                <td><?php echo $row['idminta'];  ?></td>
                <td><?php echo $row['tanggal'];  ?></td>
                <td><?php echo $row['barang'];  ?></td>
                <td><?php echo $row['jumlah'];  ?></td>
                <td><?php echo $row['keterangan'];  ?></td>
            </tr>
        <?php 
        }
        ?>
    </tbody>
</table>

</body>
</html>