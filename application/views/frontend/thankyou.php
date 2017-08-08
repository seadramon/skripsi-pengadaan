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
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/style.css">

        <!-- FONTS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
    </head>
    <body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
        <section class="container">
            <!-- TOP MENU -->
            <div class="header col-12">
                <div class="left-menu col-8">
                    <ul>
                        <li><a href="<?php echo base_url()?>">Home</a></li>
                        <li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
                        <?php
                        if ($this->session->userdata('spgConnected')['group_id']=='1') {
                        ?>
                            <li><a href="<?php echo base_url() ?>participation">Participation</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="right-menu col-4">
                    <ul>
                        <li><a href=""><?php echo $this->session->userdata('spgConnected')['name'] ?></a></li>
                        <li><a href="<?php echo base_url() ?>users/logout">Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="gap thankyou blue rnd6">
                <div class="col-12 center">
                    <?php
                        $firstname  = "";
                        $arrTemp    = explode(" ", $this->session->userdata('userConnected')['name']);
                        if (count($arrTemp) > 0) $firstname = $arrTemp[0];
                    ?>
                    <h2>Hi <?=$firstname?>, </h2>
                    <h3>Terima Kasih telah Berpartisipasi! Anda mendapatkan</h3>
                    <h1><?php echo urldecode($prize); ?></h1>

                    <div class="social">
                        <div class="social-share">
                            <a href="http://www.facebook.com/sharer.php?u=https://www.mataharimall.com/" class="fesbuk rnd6" onclick="return fbs_click(400, 300)">Share on Facebook</a>
                            <a href="http://twitter.com/intent/tweet?text=Online%20shop%20MatahariMall.com%20menyediakan%20ratusan%20ribu%20pilihan%20produk%20dengan%20harga%20terbaik%20dari%20segala%20kebutuhan%20http://bit.ly/1KzQgBc" class="twitter rnd6" onclick="return tws_click(400, 300)">Tweet This</a>
                        </div>
                        <div class="like-follow">
                            <div class="fb-like" data-href="https://www.facebook.com/mataharimallcom/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                            <a href="https://twitter.com/mataharimallcom" class="twitter-follow-button" data-show-count="true" data-lang="id" data-size="large">Ikuti @mataharimallcom</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </div>
                        <!-- <div class="social-like">
                            <a class="fesbuk rnd6" href="https://www.facebook.com/mataharimallcom" target="_blank">Like MatahariMall</a>
                            <a class="twitter rnd6" href="https://twitter.com/mataharimallcom" target="_blank">Follow MatahariMall</a>
                        </div> -->
                    </div>
                    <a class="home-btn
                    " href="<?php echo base_url() ?>users/logout/cust">Home</a>
                </div>
            </div>

            <!-- BOTTOM LOGO -->
            <div class="bottom-logo col-2">
                <a class="landscape" href=""><img src="<?php echo base_url() ?>assets/frontend/img/mm-logo.png"></a>
            </div>

        </section>

        <script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/jquery-2.1.4.min.js"></script>
    </body>
    <script>
        function fbs_click(width, height) {
            var leftPosition, topPosition;
            leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
            topPosition = (window.screen.height / 2) - ((height / 2) + 50);

            var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
            u=location.href;
            t=document.title;

            window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer', windowFeatures);
            return false;
        }

        function tws_click(width, height) {
            var leftPosition, topPosition;
            leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
            topPosition = (window.screen.height / 2) - ((height / 2) + 50);

            var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";

            window.open('http://twitter.com/intent/tweet?text=Online%20shop%20MatahariMall.com%20menyediakan%20ratusan%20ribu%20pilihan%20produk%20dengan%20harga%20terbaik%20dari%20segala%20kebutuhan%20http://bit.ly/1KzQgBc','tweet', windowFeatures);
            return false;
        }
    </script>
</html>
