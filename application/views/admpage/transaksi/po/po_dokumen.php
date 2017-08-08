<html>
<head>
	<title>Order Pembelian</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="260px;">
<div style="text-align:center;">
	<h2>Order Pembelian</h2>
</div>
<div style="text-align:right;">
	<b>Nomor : </b><?php echo $data[0]['idpo'] ?><br>
	<b>Tanggal :</b><?php echo $data[0]['tanggal'] ?>
</div>
<b>Kepada :</b> <?php echo $data[0]['supplier'] ?><br>
<b>Fax	   :</b> <?php echo $data[0]['supplierfax'] ?>
<table border="1" width="100%">
	<tr>
		<th>Jenis Barang</th>
		<th>Tgl Kirim</th>
		<th>Jumlah Unit</th>
		<th>Harga/Unit</th>
		<th>Subtotal</th>
	</tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
			<td><?php echo $row['barang']; ?></td>
			<td><?php echo $row['tanggal_pengiriman']; ?></td>
			<td><?php echo $row['jumlah'].' '.$row['satuan']; ?></td>
			<td><?php echo 'Rp. '.number_format($row['harga_satuan'],2,",","."); ?></td>
			<td><?php echo 'Rp. '.number_format($row['jumlah_harga'],2,",","."); ?></td>
		</tr>
	<?php 
	}
	?>
	<tr>
		<td colspan="4">Total</td>
		<td><?php echo 'Rp. '.number_format($row['total'],2,",","."); ?></td>
	</tr>
</table>
<b>Terbilang : </b><?php echo terbilang($row['total']).' Rupiah'; ?>

<br><br>
<div width="50%">
	<table>
		<tr>
			<td width="25%">Hormat Kami,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br><br><br><br></td>
			<td  width="25%">Mengetahui&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br><br><br><br></td>
		</tr>
		<tr>
			<td>Pemesan<br><?php echo $this->session->userdata()['ADM_SESS']['nama']; ?></td>
			<td>Supplier<br><?php echo $data[0]['supplier'] ?></td>
		</tr>
	</table>
</div>
</body>
</html>