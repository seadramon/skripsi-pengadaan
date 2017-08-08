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

            if ($success_reg!="") {
                echo $success_reg;
            }
            ?>
            <h3>Form Pendaftaran Pemberi Bantuan</h3>
            <hr>
            <form id="f_register" name="register" action="{action}" method="post"  enctype="multipart/form-data">
                {post}
                <div class="form-group">
                    <label for="kategori">Nama</label>
                    <input type="text" class="form-control" name="nama" value="{nama}" id="nama">
                </div>
                <div class="form-group">
                    <label for="kategori">Jenis Kelamin</label>
                    <?php echo form_dropdown('jk', $jk, array_key_exists('jk', $post[0])?$post[0]['jk']:"", 'class="form-control" id="jk"'); ?>
                </div>
                <div class="form-group">
                    <label for="kategori">Tanggal Lahir</label>
                    <input type="text" name="birth_date" class="form-control date-picker" data-date-format="yyyy-mm-dd" id="birth_date" placeholder="Tanggal Lahir" value="{birth_date}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control">{alamat}</textarea>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{email}" id="email">
                </div>
                <div class="form-group">
                    <label for="phone">No phone</label>
                    <input type="number" class="form-control" name="phone" value="{phone}" id="phone">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" value="{password}" id="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" value="{confirm_password}" id="confirm_password">
                </div>
                {/post}
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

