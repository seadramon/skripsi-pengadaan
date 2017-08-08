<html>
<head>
	<title>Laporan Perintah Bayar</title>
	<link href="<?=assets_folder('admin')?>css/tablePdf.css" rel="stylesheet" type="text/css" />
</head>
<body>

<img src="<?php echo assets_folder('admin') ?>img/bina_adidaya_pt.jpg" width="200px;">
<div style="text-align:center;">
	<h2>Laporan Perintah Bayar</h2>
</div>
Periode		: <?php echo $start.' - '.$end ?><br>
Status		: <?php echo $status ?><br>
<table border="1" width="100%">
	<tr>
        <th>ID Pembayaran</th>
        <th>ID PO</th>
        <th>Supplier</th>
        <th>Tanggal</th>
        <th>Total Harga</th>
        <th>Jumlah Bayar</th>
        <th>Status</th>
    </tr>
	<?php 
	foreach ($data as $row) {
	?>
		<tr>
	        <td><?php echo $row['idpembayaran'];  ?></td>
	        <td><?php echo $row['idpo'];  ?></td>
	        <td><?php echo $row['supplier'];  ?></td>
	        <td><?php echo $row['tanggal_perintahbayar'];  ?></td>
	        <td><?php echo 'Rp. '.number_format($row['total'],2,",",".");  ?></td>
	        <td><?php echo 'Rp. '.number_format($row['jml_bayar'],2,",",".");  ?></td>
	        <td><?php echo $row['status'];  ?></td>
	    </tr>
	<?php 
	}
	?>
</table>

</body>
</html>