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
            <h3>Form Detail Aktivitas</h3>
            <hr>
            <form id="f_register" name="register" action="<?php echo $action ?>" method="post"  enctype="multipart/form-data">
                <?php 
                $i = 0;
                foreach ($f_detail as $value) {
                    $qtyReceived = isset($value['quantity_received'])?$value['quantity_received']:0;
                    $qtySent = isset($value['qtyKeluar'])?$value['qtyKeluar']:0;
                    $qtyTersedia = $qtyReceived-$qtySent;
                ?>
                    <div class="form-group">
                        <label for="kategori"><?php echo $value['item'] ?></label><br>
                        <label>Bantuan Tersedia : <?php echo $qtyTersedia.' '.$value['satuan']; ?></label>
                        <input type="hidden" class="form-control" name="detail[<?php echo $i ?>][qty_tersedia]" value="<?php echo $qtyTersedia; ?>">
                        <input type="hidden" class="form-control" name="detail[<?php echo $i ?>][id_aktivitas]" value="<?php echo $id_aktivitas; ?>">
                        <input type="hidden" class="form-control" name="detail[<?php echo $i ?>][id_item]" value="<?php echo $value['id_item']; ?>">
                        <input type="number" class="form-control" name="detail[<?php echo $i ?>][qty_sent]" value="<?php echo isset($value['qtyKeluar'])?$value['qtyKeluar']:0; ?>">
                    </div>
                <?php
                $i++;
                }
                ?>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo $cancel_btn; ?>" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

</div>