<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
            <!-- <small>Add / Edit</small> -->
        </h1>
        <!-- <ol class="breadcrumb">
            {breadcrumbs}
            <li>
                <a href="{href}">{text}</a>
            </li>
            {/breadcrumbs}
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Form Permintaan</h3>
                        {success_msg}
                        {failed_msg}
                        {error_msg}
                            {warning}
                            {nik}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="customer" name="customer" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            {post}
                            <div class="form-group">
                                <label for="name">ID Minta</label>
                                <input type="text" class="form-control" name="idminta" id="idminta" value="{idminta}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="group">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik" value="{nik}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Deskripsi</label>
                                <textarea class="form-control" readonly name="deskripsi">{deskripsi}</textarea>
                            </div>
                            {/post}
                        </div><!-- /.box-body -->

                        <!-- <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div> -->
                    </form>
                </div><!-- /.box -->
            </div><!--/.col-md-6 -->
        </div>   <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Permintaan</h3>
                        {listsuccess_msg}
                        {listfailed_msg}
                    </div><!-- /.box-header -->
                    
                    <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
                        <table id="dataTable_id" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tgl Pengiriman</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {data}
                                <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                                    <td>{no}</td>
                                    <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                    <td><a href="{edit_href}">{namaBrg}</a></td>
                                    <td>{jumlah} {satuan}</td>
                                    <td>{tanggal_pengiriman}</td>
                                    <td>{keterangan}</td>
                                </tr>
                                {/data}
                            </tbody>
                        </table>
                        <div class="box-footer clearfix">
                            <input type="hidden" id="temp_id" value=""/>
                            <div class="pull-right">
                                <!-- <button type="button" id="{file_app}-delete" onclick="javascript:delete_records('{path_app}','{current_url}')" class="btn btn-danger">Delete</button> -->
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Konfirmasi Permintaan</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="konfirmasi" name="konfirmasi" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="group">Status</label>
                                <?php echo form_dropdown('status', $confirm, "", 'class="form-control" id="status"'); ?>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col-md-6 -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function popup (url) {
        win = window.open(url, "window1", "width=600,height=400,status=yes,scrollbars=yes,resizable=yes");
        win.focus();
    }
</script>
