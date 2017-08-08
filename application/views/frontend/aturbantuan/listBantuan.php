<h4>Persentase</h4>
<?php 
foreach ($persentase as $data) {
?>
	<div class="row">
		<div class="col-xs-4"><?php echo $data['item']  ?></div>
		<div class="col-xs-8"><?php echo sprintf("%d/%d %s", $data['qtyBantuan'], $data['qtyKebutuhan'], $data['satuan']) ?></div>
	</div>
<?php
}
?>
<div class="clearfix"></div><br>
<h4>Bantuan Tersubmit</h4>
<table id="parent" class="table table-bordered table-hover">
    <tr>
        <th style="width: 10px">#</th>
        <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll_uuid('form-{file_app}', true);" id="primary_check"></th>
        <th>Pemberi Bantuan</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    {arrdata}
    <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
        <td>{no}</td>
        <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record_uuid('{id}');"></td>
        <td>{pemberibantuan}</td>
        <td>{item}</td>
        <td>{quantity_received}/{quantity} {satuan}</td>
	    <td>{created}</td>
	    <td>{status}</td>
        <td>
        	<a href="<?php echo base_url() ?>bantuan/updateBantuan/{id_tipe}/{id_insiden}/{id_bantuan}">Terima</a>
        </td>
    </tr>
    {/arrdata}
</table>
{pagination}




<!-- ============================================FOOTER ===========================================================-->
</div><!-- box body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>