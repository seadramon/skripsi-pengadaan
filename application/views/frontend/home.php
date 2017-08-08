
<div class="col-md-9">

	<div class="row carousel-holder">
        <div class="col-md-12">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img class="slide-image" src="<?php echo base_url() ?>assets/frontend/img/slide_1.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="slide-image" src="<?php echo base_url() ?>assets/frontend/img/slide_2.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="slide-image" src="<?php echo base_url() ?>assets/frontend/img/slide_3.jpg" alt="">
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>

    <?php 
    foreach ($insidens as $insiden) {
        $bantuanTerkumpul = getBantuanTerkumpul($insiden['id_insiden']);
        $totalTerkumpul = (int)$bantuanTerkumpul['nilaiBantuanDrop'] + (int)$bantuanTerkumpul['nilaiBantuanDana'];

        $dana_estimasi = $insiden['dana_estimasi'];
        $progressPenggalangan = round(($totalTerkumpul/$dana_estimasi)*100, 2);
    ?>
        <div class="thumbnail">
            <!-- <img class="img-responsive" src="http://placehold.it/800x300" alt=""> -->
            <div class="caption-full">
                <h4 style="color:red;" class="pull-right"><?php echo $progressPenggalangan; ?>%</h4>
                <h4><a href="<?php echo base_url() ?>pantauinsiden/detail/<?php echo $insiden['id_insiden'] ?>"><?php echo $insiden['nama'].'  ('.$insiden['fase'].')'; ?></a></h4>              
                oleh : <?php echo $insiden['organisasi']; ?><br><br>
                <p><?php echo $insiden['deskripsi'] ?></p>
            </div>
            <div class="ratings">
                <p class="pull-right"><a href="<?php echo base_url() ?>pantauinsiden/detail/<?php echo $insiden['id_insiden'] ?>">Detail</a></p>
                <p>Estimasi Dana yang dibutuhkan Rp. <?php echo number_format($insiden['dana_estimasi'], 0, ".", "."); ?></p>
            </div>
        </div>
    <?php
    }
    ?>
</div>

