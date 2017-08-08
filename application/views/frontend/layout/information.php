<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-md-9">

            <div class="thumbnail">
                <div class="caption-full">
                    <?php 
                    if ($sukses=='yes') {
                    ?>
                        <h3>SUKSES!</h3>
                        <hr>
                        <p style="color:green;"><?php echo $information ?></p>
                    <?php 
                    }else{
                    ?>
                        <h3>WARNING!</h3>
                        <hr>
                        <p style="color:red;"><?php echo $information ?></p>
                    <?php 
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container -->