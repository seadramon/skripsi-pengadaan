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
            <h3>Form Kebutuhan</h3>
            <hr>
            <form id="f_register" name="register" action="{action}" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="id_insiden" value="<?php echo $id_insiden ?>">
                {post}
                <div class="form-group">
                    <label for="kategori">Tipe Kebutuhan</label>
                    <?php echo form_dropdown('id_tipe', $id_tipe, array_key_exists('id_tipe', $post[0])?$post[0]['id_tipe']:"", 'class="form-control" id="id_tipe" onchange="ajaxitem(this.value)"'); ?>
                </div>
                <div class="form-group">
                    <label for="kategori">Item</label>
                    <?php echo form_dropdown('id_item', $id_item, array_key_exists('id_item', $post[0])?$post[0]['id_item']:"", 'class="form-control" id="id_item" onchange="ajaxsatuan(this.value)"'); ?>
                </div>
                <div class="form-group">
                    <label for="kategori">Satuan</label>
                    <?php echo form_dropdown('id_satuan', $id_satuan, array_key_exists('id_satuan', $post[0])?$post[0]['id_satuan']:"", 'class="form-control" id="satuan"'); ?>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{deskripsi}</textarea>
                </div>
                <div class="form-group">
                    <label for="kategori">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="{quantity}" id="quantity" onkeyup="quantityNeed(this.value)">
                </div>
                <div class="form-group">
                    <label for="kategori">Harga Satuan</label>
                    <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" value="{harga_satuan}" onkeyup="unitprice(this.value)">
                </div>
                <div class="form-group">
                    <label for="kategori">Total</label>
                    <input type="text" class="form-control" name="unit_price" id="unit_price" value="{unit_price}" readonly>
                </div>
                {/post}
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>

