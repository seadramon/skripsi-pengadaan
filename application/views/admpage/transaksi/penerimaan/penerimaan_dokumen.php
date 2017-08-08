<html>
<head>
	<title>Penerimaan Barang</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Penerimaan Barang</h2>
</div>
<div style="text-align:right;">
	<b>Nomor : </b><?php echo $data[0]['idpenerimaan'] ?><br>
	<b>Tanggal :</b><?php echo $data[0]['tanggal'] ?>
</div>

<table>
	<tr>
		<td>Nama Supplier : <?php echo $data[0]['supplier'] ?></td>
		<td>No. PO : <?php echo $data[0]['idpo'] ?></td>
	</tr>
</table><br>

<table border="1" width="100%">
	<tr>
		<th>ID Barang</th>
		<th>Barang</th>
		<th>Satuan</th>
		<th>Jumlah Pesan</th>
		<th>Jumlah Terima</th>
	</tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
			<td><?php echo $row['idbarang']; ?></td>
			<td><?php echo $row['barang']; ?></td>
			<td><?php echo $row['satuan']; ?></td>
			<td><?php echo $row['jmlPesan']; ?></td>
			<td><?php echo $row['jmlTerima']; ?></td>
		</tr>
	<?php 
	}
	?>
</table>
<br>
<div width="50%">
	<table>
		<tr>
			<td>Dikirim Oleh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br></td>
			<td>Diterima Oleh&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br></td>
			<td>Staff Qc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br></td>
			<td>Kepala Gudang&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>Nama</td>
			<td>Nama</td>
			<td>Nama</td>
		</tr>
	</table>
</div>
</body>
</html>