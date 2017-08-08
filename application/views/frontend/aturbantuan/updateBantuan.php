<h4>Penerimaan Bantuan</h4>
<hr class="hrdot">
<?php 
if (is_array($error_msg) && count($error_msg) > 0) {
    foreach ($error_msg as $row) {
    	echo $row;
    }
}
echo $success_msg;
?>
<form method="post" action="<?php echo $action ?>">
	<?php 
	$i = 0;
	foreach ($valueUpdate as $attr) {
	?>
		<div class="form-group">
            <label for="nama"><?php echo $attr['item'] ?></label><br>
            <label for="nama"><?php echo $attr['quantity_received'].'/'.$attr['quantity'].' '.$attr['satuan'] ?></label><br>
            <input type="number" name="detailBantuan[<?php echo $i ?>][qtyTerima]" class="form-control">
            <input type="hidden" name="detailBantuan[<?php echo $i ?>][item]" value="<?php echo $attr['item'] ?>" class="form-control">
            <input type="hidden" name="detailBantuan[<?php echo $i ?>][id_detail_bantuan]" value="<?php echo $attr['id_detail_bantuan'] ?>" class="form-control">
            <input type="hidden" name="detailBantuan[<?php echo $i ?>][quantity_received]" value="<?php echo $attr['quantity_received'] ?>" class="form-control">
            <input type="hidden" name="detailBantuan[<?php echo $i ?>][quantity]" value="<?php echo $attr['quantity'] ?>" class="form-control">
        </div>
	<?php 
	$i++;
	}
	?>
	<button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?php echo $cancel_btn ?>" class="btn btn-danger">Kembali</a>
</form>