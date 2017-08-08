<div class="col-md-9">

    <div class="thumbnail">
        <div class="caption-full">
            <?php 
            if (is_array($error_msg) && count($error_msg) > 0) {
                foreach ($error_msg as $val) {
                    echo $val;
                }
            }

            if (is_array($success_msg) && count($success_msg) > 0) {
                foreach ($success_msg as $val) {
                    echo $val;
                }
            }

            if (is_array($error_sess) && count($error_sess) > 0) {
                foreach ($error_sess as $val) {
                    echo $val;
                }
            }
            ?>
            <h3>Daftar Organisasi</h3>
            <hr>
            <form id="f_register" name="register" action="" method="post"  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Organisasi</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Organisasi">
                </div>
                <div class="form-group">
                    <label for="emai">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Alamat Organisasi"></textarea>
                </div>
                <div class="form-group">
                    <label for="postal">Postal</label>
                    <input type="text" name="postal" class="form-control" id="postal" placeholder="Postal">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="pic">Penanggung Jawab</label>
                    <input type="text" name="pic" class="form-control" id="pic" placeholder="Nama Penanggungjawab">
                </div>
                <div class="form-group">
                    <label for="file">File AD/ART</label>
                    <input type="file" name="dokumen">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo base_url() ?>" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

