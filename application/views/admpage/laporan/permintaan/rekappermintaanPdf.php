<html>
<head>
	<title>Laporan Rekap Permintaan</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="200px;">
<div style="text-align:center;">
	<h2>Laporan Rekap Permintaan Barang</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
<table border="1" width="100%">
	<tr>
        <th>ID Minta</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Tgl Kirim</th>
        <th>Keterangan</th>
        <th>Status</th>
    </tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
            <td><?php echo $row['idminta'];  ?></td>
            <td><?php echo $row['nama'];  ?></td>
            <td><?php echo $row['jumlah'];  ?></td>
            <td><?php echo $row['tanggal_pengiriman'];  ?></td>
            <td><?php echo $row['keterangan'];  ?></td>
            <td><?php echo $row['status'];  ?></td>
        </tr>
	<?php 
	}
	?>
</table><br>
<table width="50%" border="1">
	<tr>
		<td>Total Permintaan :</td>
		<td><?php echo $jmlminta ?></td>
	</tr>
	<tr>
		<td>Total Permintaan Disetujui :</td>
		<td><?php echo $jmlmintaSetuju ?></td>
	</tr>
	<tr>
		<td>Total Permintaan Belum Disetujui :</td>
		<td><?php echo $jmlmintaSent ?></td>
	</tr>
	<tr>
		<td>Total Permintaan Ditolak :</td>
		<td><?php echo $jmlmintaTolak ?></td>
	</tr>
	<tr>
		<td>Total Permintaan Diterima :</td>
		<td><?php echo $jmlmintaMasuk ?></td>
	</tr>
	<tr>
		<td>Total Permintaan Terpakai :</td>
		<td><?php echo $jmlmintaKeluar ?></td>
	</tr>
</table>

</body>
</html>