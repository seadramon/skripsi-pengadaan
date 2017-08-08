<div class="col-md-9">
<?php 
// print_r($this->session->userdata());
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Kebutuhan</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    {error_msg}
                    {success_msg}
                    {info_msg}
                    <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
                    <table id="parent" class="table table-bordered table-hover">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll_uuid('form-{file_app}', true);" id="primary_check"></th>
                            <th>Tipe</th>
                            <th>Barang</th>
					        <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        {data}
                        <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                            <td>{no}</td>
                            <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record_uuid('{id}');"></td>
                            <td>{tipe}</td>
                            <td>{item}</td>
						    <td>{quantity}</td>
                            <td>{unit_price}</td>
                            <?php 
                            if($this->session->userdata('user')['role']=='korlap' || $this->session->userdata('user')['role']=='leader'){
                            ?>
                                <td>
                                    <?php
                                    if ($this->session->userdata('user')['role']=='korlap') {
                                    ?>
                                        <a href="<?php echo base_url() ?>kebutuhan/edit/{id_insiden}/{id}">Edit</a> | 
                                    <?php 
                                    } else {
                                    ?>
                                        <a href="<?php echo base_url() ?>insiden/edit/{id}">Detail</a>
                                    <?php 
                                    }
                                    ?>
                                </td>
                            <?php 
                            }
                            ?>
                        </tr>
                        {/data}
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    {pagination}

                    <input type="hidden" id="temp_id" value=""/>
                    <div class="pull-right">
                        <a href="{add_btn}" type="button" id="{file_app}-add" class="btn btn-success">Add</a>
                        <a href="{back_btn}" type="button" id="{file_app}-back" class="btn btn-primary">Back</a>
                        <button type="button" id="{file_app}-delete" onclick="javascript:delete_records_uuid('{path_app}','{current_url}')" class="btn btn-danger">Delete</button>
                    </div>
                </div>
                    </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>