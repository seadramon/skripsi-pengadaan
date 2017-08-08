<div class="col-md-9">
	<h2>Cetak Laporan History</h2>
	<hr class="hrdot">

	<form method="post" action="">
		<div class="form-group">
			<label class="col-md-2">Tanggal Bantuan</label>
			<div class="col-md-10">
				<div class="form-group row">
					<label class="col-md-1">Start</label>
					<div class="col-md-4">
						<input type="text" name="start" class="form-control date-picker" data-date-format="yyyy-mm-dd">		
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-1">End</label>
					<div class="col-md-4">
						<input type="text" name="end" class="form-control date-picker" data-date-format="yyyy-mm-dd">		
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Tipe</label>
			<?php echo form_dropdown('id_tipe', $tipe, "", 'class="form-control"'); ?>
		</div>
		

		<button type="submit" class="btn btn-primary">Cetak</button>
        <a href="<?php echo base_url() ?>home/insiden" class="btn btn-danger">Cancel</a>
	</form>
</div>