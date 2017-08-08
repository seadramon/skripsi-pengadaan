<style type="text/css">
    .table-responsive {
      overflow-x: visible !important;
      overflow-y: visible !important;
    }
</style>
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
                            <th>Kategori</th>
                            <th>Fase</th>
					        <th>Jumlah Korban</th>
					        <th>Status</th>
                            <?php 
                            if($this->session->userdata('user')['role']=='korlap' || $this->session->userdata('user')['role']=='leader' || $this->session->userdata('user')['role']=='korlog'){
                            ?>
                                <th>Action</th>
                            <?php 
                            }
                            ?>
                        </tr>
                        {data}
                        <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                            <td>{no}</td>
                            <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record_uuid('{id}');"></td>
                            <td>{nama}</td>
                            <td>{kategori}</td>
                            <td>{fase}</td>
						    <td>{korban}</td>
						    <td>{status}</td>
                            <?php 
                            if($this->session->userdata('user')['role']=='korlap' || $this->session->userdata('user')['role']=='leader' || $this->session->userdata('user')['role']=='korlog'){
                            ?>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <?php
                                                if ($this->session->userdata('user')['role']=='korlap') {
                                                ?>
                                                    <li><a href="<?php echo base_url() ?>insiden/edit/{id}">Edit</a></li>
                                                    <li><a href="<?php echo base_url() ?>kebutuhan/index/{id}">Kebutuhan</a></li>
                                                    <li><a href="<?php echo base_url() ?>poslogistik/index/{id}">Pos</a></li>
                                                <?php 
                                                } 
                                                if ($this->session->userdata('user')['role']=='leader') {
                                                ?>
                                                    <li><a href="<?php echo base_url() ?>insiden/detail/{id}">Preview</a></li>
                                                <?php 
                                                }
                                                if ($this->session->userdata('user')['role']=='korlap' || $this->session->userdata('user')['role']=='korlog') {
                                                ?>
                                                    <li><a href="<?php echo base_url() ?>insiden/bantuan/{id}">Bantuan</a></li>
                                                <?php 
                                                }
                                                ?>
                                                <?php 
                                                if ($this->session->userdata('user')['role']=='korlap') {
                                                ?>
                                                    <li><a href="<?php echo base_url() ?>aktivitas/index/{id}">Aktivitas</a></li>
                                                <?php 
                                                }
                                                ?>
                                            </ul>
                                    </div>
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
                        <button type="button" id="{file_app}-delete" onclick="javascript:delete_records_uuid('{path_app}','{current_url}')" class="btn btn-danger">Delete</button>
                    </div>
                </div>
                    </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</div>