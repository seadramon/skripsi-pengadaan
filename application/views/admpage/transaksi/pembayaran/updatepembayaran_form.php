<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Form Perintah Bayar</h3>
                        {error_msg}
                            {warning}
                            {idpo}
                            {tanggal_perintahbayar}
                            {tanggal_dibayar}
                            {jml_bayar}
                            {status}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="fpembayaran" name="fpembayaran" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            {post}
                            <div class="form-group">
                                <label for="name">ID Pembayaran</label>
                                <input type="text" readonly class="form-control" name="idpembayaran" id="idpembayaran" value="{idpembayaran}" placeholder="idpembayaran">
                            </div>
                            <div class="form-group">
                                <label for="name">ID PO</label>
                                <input type="text" readonly class="form-control" name="idpo" id="idpo" value="{idpo}">
                            </div>
                            <div class="form-group">
                                <label for="name">Tgl Perintah Bayar</label>
                                <input type="text" readonly class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="tanggal_perintahbayar" id="tanggal_perintahbayar" value="{tanggal_perintahbayar}">
                            </div>
                            <div class="form-group">
                                <label for="name">Jumlah Bayar</label>
                                <input type="number" readonly class="form-control" name="jml_bayar" id="jml_bayar" value="{jml_bayar}">
                            </div>
                            {/post}
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->

            </div><!--/.col -->
        </div>   <!-- /.row -->

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Form Update Bayar</h3>
                        {error_msg}
                            {warning}
                            {tanggal_dibayar}
                            {status}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="fpembayaran" name="fpembayaran" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            {post}
                            <input type="hidden" readonly class="form-control" name="idpembayaran" id="idpembayaran" value="{idpembayaran}" placeholder="idpembayaran">
                            <div class="form-group">
                                <label for="name">Tanggal dibayar</label>
                                <input type="text" class="form-control date-picker" readonly data-date-format="yyyy-mm-dd" name="tanggal_dibayar" id="tanggal_dibayar" value="{tanggal_dibayar}">
                            </div>
                            <div class="form-group">
                                <label for="group">Status</label>
                                <?php echo form_dropdown('status', $status, array_key_exists('status', $post[0])?$post[0]['status']:"", 'class="form-control" id="status"'); ?>
                            </div>
                            {/post}
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->

            </div><!--/.col -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function popup (url) {
        win = window.open(url, "window1", "width=600,height=400,status=yes,scrollbars=yes,resizable=yes");
        win.focus();
    }
</script>
