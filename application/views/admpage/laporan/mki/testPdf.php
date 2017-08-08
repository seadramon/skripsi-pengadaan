<html>
<head>
	<title>Laporan Order Pembelian</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>


<div style="text-align:center;">
	<h2>Laporan Order Pembelian Barang</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
<table border="1" width="100%">
	<tr>
		<th>Kode</th>
		<th>Uraian</th>
		<th>Tanggal</th>
		<th>Tgl Kirim</th>
		<th>Harga/Unit</th>
		<th>Jumlah Unit</th>
		<th>Subtotal</th>
	</tr>
	<?php 
	foreach ($dataHead as $row) {
		$total = $row['total'];
	?>
		<tr>
			<td><?php echo $row['idpo'] ?></td>
			<td><b><?php echo $row['supplier'] ?></b></td>
			<td><?php echo $row['tanggal'] ?></td>
			<td>-</td>
			<td>-</td>
			<td><?php echo $row['jumlah'] ?></td>
			<td><?php echo $row['jumlah_harga'] ?></td>
		</tr>
	<?php
		foreach ($data as $rowDet) {
			if ($row['idpo']==$rowDet['idpo']) {
	?>
				<tr>
					<td style="padding-left:25px;"><?php echo $rowDet['idpo'].'.'.$rowDet['idbarang'] ?></td>
					<td style="padding-left:25px;">-<?php echo $rowDet['barang'] ?></td>
					<td>-</td>
					<td><?php echo $rowDet['tanggal_pengiriman'] ?></td>
					<td><?php echo $rowDet['harga_satuan'] ?></td>
					<td><?php echo $rowDet['jumlah'] ?></td>
					<td><?php echo $rowDet['jumlah_harga'] ?></td>
				</tr>
	<?php 
			}
		}
	?>
		<tr>
			<td colspan="6">Total : </td>
			<td><?php echo $total; ?></td>
		</tr>
	<?php
	}
	?>
</table>

</body>
</html>