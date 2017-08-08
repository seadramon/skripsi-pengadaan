<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <title>Matahari Mall</title>
        <meta name="author" content="Matahari Mall">
        <meta name="description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan, mulai dari fashion wanita, fashion pria, produk kecantikan, handphone, laptop, gadget, elektronik, hobi, makanan & minuman, dan lainnya.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="developer" content="PT. Jayadata Indonesia">

        <meta property="og:locale" content="id_ID"/>
        <meta property="og:url" content="http://www.mataharimall.com" />
        <meta property="og:title" content="Matahari Mall" />
        <meta property="og:description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan, mulai dari fashion wanita, fashion pria, produk kecantikan, handphone, laptop, gadget, elektronik, hobi, makanan & minuman, dan lainnya." />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?=base_url()?>assets/frontend/img/mataharimall-og.jpg" />
        <meta property="og:site_name" content="Matahari Mall"/>

        <meta name="twitter:card" content="summary">
        <meta name="twitter:creator" content="@mataharimallcom">
        <meta name="twitter:site" content="@mataharimallcom">
        <meta name="twitter:title" content="Matahari Mall">
        <meta name="twitter:description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan">
        <meta name="twitter:image" content="<?=base_url()?>assets/frontend/img/mataharimall-og.jpg" />

		<!-- FAVICON -->
		<link rel="shortcut icon" href="https://cdn2.mataharimall.co/sites/default/files/favicon.ico" />

		<!-- STYLESHEETS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/grid.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/style.css" >

		<!-- FONTS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
	</head>
	<body>
		<section class="container">
			<!-- SPG LOGIN PAGE -->
			<div class="spg-join col-6">
				<div class="mm-logo col-6 landscape">
					<img src="<?php echo base_url() ?>assets/frontend/img/mm-logo.png">
				</div>
				<div class="spg-join-form col-12">
					<?php
					if (is_array($error) && count($error) > 0) {
						foreach ($error as $row) {
					?>
							<h3><?php echo $row ?></h3>
					<?php
						}
					} else {
					?>
							<h3><?php echo $error ?></h3>
					<?php
					}
					?>
					<form action="<?php echo base_url() ?>users/login/2" method="post">
						<input type="text" name="email" placeholder="Email">
						<input type="password" name="password" placeholder="Password">
						<div class="spg-mall">
							<?php echo form_dropdown('mall', $mall, ""); ?>
						</div>
						<input type="submit" class="btn rnd6 col-12" value="Masuk">
					</form>
				</div>
			</div>

		</section>
	</body>
</html>
