<div class="col-md-9">
<?php 
// print_r($this->session->userdata());
?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Insiden</h3>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
					        <th>Status</th>
                            <th>Action</th>
                        </tr>
                        {data}
                        <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                            <td>{no}</td>
                            <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record_uuid('{id}');"></td>
                            <td>{nama}</td>
                            <td>{email}</td>
                            <td>{phone}</td>
						    <td><a href="{edit_status}">{status}</a></td>
                            <td><a href="{edit_href}">Edit</a></td>
                        </tr>
                        {/data}
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    {pagination}

                    <input type="hidden" id="temp_id" value=""/>
                    <div class="pull-right">
                        <a href="{add_btn}" type="button" id="{file_app}-add" class="btn btn-success">Add</a>
                        <button type="button" id="{file_app}-delete" onclick="javascript:delete_records_uuid('{path_app}','{current_url}')" class="btn btn-danger">Delete</button>
                    </div>
                </div>
                    </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>