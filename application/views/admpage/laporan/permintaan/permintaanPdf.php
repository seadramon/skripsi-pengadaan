<html>
<head>
	<title>Laporan Permintaan</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Permintaan Barang</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
Status		: <?php echo $status ?><br>
<table border="1" width="100%">
	<tr>
		<th>Staff GBB</th>
		<th>ID Minta</th>
		<th>Nama Barang</th>
		<th>Jumlah</th>
		<th>Keterangan</th>
		<th>Tgl Kirim</th>
		<th>Tgl Disetujui</th>
		<th>Status</th>
	</tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
			<td><?php echo $row['gbb'] ?></td>
			<td><?php echo $row['idminta'] ?></td>
			<td><?php echo $row['nama'] ?></td>
			<td><?php echo $row['jumlah'] ?></td>
			<td><?php echo $row['keterangan'] ?></td>
			<td><?php echo $row['tanggal_pengiriman'] ?></td>
			<td><?php echo $row['tanggal_disetujui'] ?></td>
			<td><?php echo $row['status'] ?></td>
		</tr>
	<?php 
	}
	?>
</table>

</body>
</html>