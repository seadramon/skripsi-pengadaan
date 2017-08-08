<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
            <small>List of {menu_title}</small>
        </h1>
        <ol class="breadcrumb">
            {breadcrumbs}
            <li>
                <a href="{href}">{text}</a>
            </li>
            {/breadcrumbs}
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Search {menu_title}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="search-{file_app}" name="search-{file_app}" action="{path_app}/search" method="post" role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Item Name</label>
                                    <input type="text" class="form-control" name="s_name" id="s_name" value="{s_name}" placeholder="Group Name">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- ./box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Master Item</h3>
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
                                <th>Tipe</th>
                                <th>Status</th>
                            </tr>
                            {data}
                            <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                                <td>{no}</td>
                                <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record_uuid('{id}');"></td>
                                <td><a href="{edit_href}">{nama}</a></td>
                                <td>{tipe}</td>
                                <td><a href="{edit_status}">{status}</a></td>
                            </tr>
                            {/data}
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {pagination}

                        <input type="hidden" id="temp_id" value=""/>
                        <div class="pull-right">
                            <a href="{add_btn}" type="button" id="{file_app}-add" class="btn btn-success">Add</a>
                            <!-- <button type="button" id="{file_app}-delete" onclick="javascript:delete_records_uuid('{path_app}','{current_url}')" class="btn btn-danger">Delete</button> -->
                        </div>
                    </div>
                        </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->