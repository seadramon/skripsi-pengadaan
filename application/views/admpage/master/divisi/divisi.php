<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Master Divisi</h3>
                    </div><!-- /.box-header -->
                        {error_msg}
                        {success_msg}
                        {info_msg}
                        <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
                            <!-- <table id="parent" class="table table-bordered table-hover"> -->
                            <table id="dataTable_id" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data}
                                    <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                                        <td>{no}</td>
                                        <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                        <td><a href="{edit_href}">{nama}</a></td>
                                        <th><a href="{edit_status}">{status}</a></th>
                                    </tr>
                                    {/data}
                                </tbody>
                            </table>

                            <div class="box-footer clearfix">
                                <input type="hidden" id="temp_id" value=""/>
                                <div class="pull-right">
                                    <a href="{add_btn}" type="button" id="{file_app}-add" class="btn btn-success">Add</a>
                                    <!-- <button type="button" id="{file_app}-delete" onclick="javascript:delete_records('{path_app}','{current_url}')" class="btn btn-danger">Delete</button> -->
                                </div>
                            </div>
                        </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->