<div class="col-md-9">

    <div class="thumbnail">
        <div class="caption-full">
            <?php 
            if (is_array($error_msg) && count($error_msg) > 0) {
                foreach ($error_msg as $row) {
                    foreach ($row as $val) {
                        echo $val;
                    }
                }
            }
            ?>
            <h3>Form Insiden</h3>
            <hr>
            <form id="f_register" name="register" action="{action}" method="post"  enctype="multipart/form-data">
                {post}
                <div class="form-group">
                    <label for="nama">Nama Insiden</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Insiden" value="{nama}">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori Insiden</label>
                    <?php echo form_dropdown('id_kategori', $id_kategori, array_key_exists('id_kategori', $post[0])?$post[0]['id_kategori']:"", 'class="form-control" id="id_kategori"'); ?>
                </div>
                <div class="form-group">
                    <label for="fase">Fase Insiden</label>
                    <?php echo form_dropdown('id_fase', $id_fase, array_key_exists('id_fase', $post[0])?$post[0]['id_fase']:"", 'class="form-control" id="id_fase"'); ?>
                </div>
                <div class="form-group">
                    <label for="keterangan">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" id="deskripsi">{deskripsi}</textarea>
                </div>
                <div class="form-group">
                    <label for="keterangan">Lokasi Bencana</label>
                    <textarea name="alamat" class="form-control" id="alamat">{alamat}</textarea>
                </div>
                <div class="form-group">
                    <label for="term">Term</label>
                    <textarea name="terms" class="form-control" id="terms">{terms}</textarea>
                </div>
                <div class="form-group">
                    <label for="postal">Estimasi Korban</label>
                    <input type="number" name="korban" class="form-control" id="korban" placeholder="Estimasi Korban" value="{korban}">
                </div>
                <div class="form-group">
                    <label for="postal">Estimasi Berakhir</label>
                    <input type="text" name="estimasi" class="form-control date-picker" data-date-format="yyyy-mm-dd" id="estimasi" placeholder="Estimasi Korban" value="{estimasi}">
                </div>
                <div class="form-group">
                    <label for="file">Image</label>
                    <input type="file" name="image">
                </div>
                {/post}
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

