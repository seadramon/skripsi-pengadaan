<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
            <small>Add / Edit</small>
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
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
<!--                        <h3 class="box-title">Quick Example</h3>-->
                        {error_msg}
                            {warning}
                            {nama}
                            {status}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="kategori" name="kategori" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            {post}
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="{nama}" placeholder="Nama" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="{email}" placeholder="Email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" readonly>{alamat}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input type="text" name="postal" class="form-control" id="postal" placeholder="Postal" value="{postal}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="{phone}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="pic">Penanggung Jawab</label>
                                <input type="text" name="pic" class="form-control" id="pic" placeholder="Nama Penanggungjawab" value="{pic}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="file">File AD/ART</label>
                                <a href="<?php echo base_url() ?>documents/{file}" target="_blank">{file}</a>
                            </div>
                            <div class="form-group">
                                <label for="group">Status</label>
                                <?php echo form_dropdown('status', $status, array_key_exists('status', $post[0])?$post[0]['status']:"", 'class="form-control" id="status"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
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
