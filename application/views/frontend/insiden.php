
<div class="col-md-9">
    <h2>Insiden</h2>
    <hr class="hrdot">
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
                <h3 class="pull-right"><?php echo $progressPenggalangan; ?>%</h3>
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
    <?php echo $pagination; ?>
    <br>
    <?php 
    if ($this->session->userdata('user')) {
    ?>
        <h4 class="pull-right">
           <a href="<?php echo base_url() ?>laporan/insiden">Cetak Laporan Insiden</a>
        </h4>
    <?php 
    }
    ?>
</div>

