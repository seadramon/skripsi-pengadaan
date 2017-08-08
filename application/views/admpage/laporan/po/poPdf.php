<html>
<head>
	<title>Laporan Order Pembelian</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Order Pembelian Barang</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
<table border="1" width="100%">
	<tr>
		<th>ID PO</th>
		<th>Supplier</th>
		<th>Nama Barang</th>
		<th>Tanggal</th>
		<th>Tgl Kirim</th>
		<th>Jumlah Unit</th>
		<th>Subtotal</th>
	</tr>
	<?php 
	foreach ($dataHead as $row) {
		$total = $row['total'];
		foreach ($data as $rowDet) {
			if ($row['idpo']==$rowDet['idpo']) {
	?>
				<tr>
					<td><?php echo $rowDet['idpo'] ?></td>
					<td><?php echo $rowDet['supplier'] ?></td>
					<td><?php echo $rowDet['barang'] ?></td>
					<td><?php echo $rowDet['tanggal'] ?></td>
					<td><?php echo $rowDet['tanggal_pengiriman'] ?></td>
					<td><?php echo $rowDet['jumlah'] ?></td>
					<td><?php echo 'Rp. '.number_format($rowDet['jumlah_harga'],2,",","."); ?></td>
				</tr>
	<?php 
			}
		}
	?>
		<tr>
			<td colspan="6">Total : </td>
			<td><?php echo 'Rp. '.number_format($total,2,",","."); ?></td>
		</tr>
	<?php
	}
	?>
</table>

</body>
</html>