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
            <h3>Form Pos Logistik</h3>
            <hr>
            <form id="f_register" name="register" action="{action}" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="id_insiden" value="<?php echo $id_insiden ?>">
                {post}
                <div class="form-group">
                    <label for="kategori">Korlog</label>
                    <?php echo form_dropdown('id_user', $id_user, array_key_exists('id_user', $post[0])?$post[0]['id_user']:"", 'class="form-control" id="id_user"'); ?>
                </div>
                <div class="form-group">
                    <label for="kategori">Nama</label>
                    <input type="text" class="form-control" name="nama" value="{nama}" id="nama">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control">{alamat}</textarea>
                </div>
                <div class="form-group">
                    <label for="telp">No Telp</label>
                    <input type="number" class="form-control" name="telp" value="{telp}" id="telp">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{deskripsi}</textarea>
                </div>
                {/post}
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

