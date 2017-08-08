<html>
<head>
	<title>Laporan Penerimaan</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Penerimaan Barang</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
<table border="1" width="100%">
	<tr>
		<th>ID Penerimaan</th>
		<th>ID PO</th>
		<th>Supplier</th>
		<th>Barang</th>
		<th>Tanggal</th>
		<th>Jumlah dipesan</th>
		<th>Jumlah diterima</th>
	</tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
			<td><?php echo $row['idpenerimaan'] ?></td>
			<td><?php echo $row['idpo'] ?></td>
			<td><?php echo $row['supplier']; ?></td>
			<td><?php echo $row['barang']; ?></td>
			<td><?php echo $row['tanggal']; ?></td>
			<td><?php echo $row['jmlPesan']; ?></td>
			<td><?php echo $row['jmlTerima']; ?></td>
		</tr>
	<?php
	}
	?>
</table>

</body>
</html>