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
            <h3>Form Organisasi Bank</h3>
            <hr>
            <form id="f_register" name="register" action="{action}" method="post"  enctype="multipart/form-data">
                {post}
                <div class="form-group">
                    <label for="kategori">Bank</label>
                    <?php echo form_dropdown('id_bank', $id_bank, array_key_exists('id_bank', $post[0])?$post[0]['id_bank']:"", 'class="form-control" id="id_bank"'); ?>
                </div>
                <div class="form-group">
                    <label for="cabang">Cabang</label>
                    <input type="text" name="cabang" class="form-control" id="cabang" placeholder="cabang" value="{cabang}">
                </div>
                <div class="form-group">
                    <label for="nama_akun">Atas nama_akun</label>
                    <input type="text" name="nama_akun" class="form-control" id="nama_akun" placeholder="nama_akun" value="{nama_akun}">
                </div>
                <div class="form-group">
                    <label for="nomor_akun">Nomor</label>
                    <input type="text" name="nomor_akun" class="form-control" id="nomor_akun" placeholder="nomor_akun" value="{nomor_akun}">
                </div>
                {/post}
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

