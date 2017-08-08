<html>
<head>
	<title>Laporan Pembayaran</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Laporan Pembayaran</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
Status		: <?php echo $status ?><br>
<table border="1" width="100%">
	<tr>
		<th>ID Pembayaran</th>
		<th>ID PO</th>
		<th>Supplier</th>
		<th>Nama Barang</th>
		<th>Jumlah Unit</th>
		<th>Harga/Unit</th>
		<th>Subtotal</th>
	</tr>
	<?php 
	foreach ($dataHead as $row) {
		$total = $row['total'];
		$status = $row['status'];
		if ($status=='paid') {
			$status = 'lunas pada '.$row['tanggal_dibayar'];
		} else {
			$status = 'belum lunas';
		}
		$jml_bayar = isset($row['jml_bayar'])?$row['jml_bayar']:0;
		foreach ($data as $rowDet) {
			if ($row['idpembayaran']==$rowDet['idpembayaran']) {
	?>
				<tr>
					<td><?php echo $rowDet['idpembayaran'] ?></td>
					<td><?php echo $rowDet['idpo'] ?></td>
					<td><?php echo $rowDet['supplier'] ?></td>
					<td><?php echo $rowDet['barang'] ?></td>
					<td><?php echo $rowDet['jumlah'] ?></td>
					<td><?php echo 'Rp. '.number_format($rowDet['harga_satuan'],2,",",".") ?></td>
					<td><?php echo 'Rp. '.number_format($rowDet['jumlah_harga'],2,",",".") ?></td>
				</tr>
	<?php 
			}
		}
	?>
		<tr>
			<td colspan="5">Total : </td>
			<td colspan="2"><?php echo 'Rp. '.number_format($total,2,",","."); ?></td>
		</tr>
		<tr>
			<td colspan="5">Jumlah Bayar : </td>
			<td colspan="2"><?php echo 'Rp. '.number_format($jml_bayar,2,",","."); ?></td>
		</tr>
		<tr>
			<td colspan="5">Status : </td>
			<td colspan="2"><?php echo $status; ?></td>
		</tr>
	<?php
	}
	?>
</table>

</body>
</html>