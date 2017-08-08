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
        <meta property="og:url" content="<?=base_url()?>" />
        <meta property="og:title" content="Matahari Mall" />
        <meta property="og:description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan" />
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
    <?php //print_r($this->session->userdata('userConnected')); ?>
        <section class="container">

            <div class="join">
                <div class="join-title">
                    <h1>Mohon lengkapi field dibawah</h1>
                </div>
                <div class="join-form gap center">
                    <div class="join-disini col-6">
                        <form action="<?php echo base_url() ?>hauth/<?php echo $provider ?>" method="post">
                            <?php
                            if (is_array($error) && count($error) > 0) {
                                foreach ($error as $row) {
                            ?>
                                    <h3><?php echo $row; ?></h3>
                            <?php
                                }
                            }
                            ?>
                            <input type="text" name="name" placeholder="Name" value="<?php echo isset($name)?$name:"" ?>">
                            <input type="mail" name="email" placeholder="Email" value="<?php echo isset($email)?$email:"" ?>">
                            <input type="tel" name="phone" placeholder="Phone" value="<?php echo isset($phone)?$phone:"" ?>">
                            <input type="submit" class="btn rnd6" value="Lanjutkan">
                        </form>
                    </div>
                </div>
            </div>

            <!-- BOTTOM LOGO -->
            <div class="bottom-logo col-2">
                <a class="landscape" href=""><img src="<?php echo base_url() ?>assets/frontend/img/mm-logo.png"></a>
            </div>

        </section>
    </body>
</html>
