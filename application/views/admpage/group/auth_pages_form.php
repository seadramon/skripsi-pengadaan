<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {menu_title}
            <small>Authorization</small>
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
                        {error_msg}
                        {warning}
                        {auth_admin}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-{file_app}" name="form-{file_app}" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            {auth_list}
                        </div>

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onClick="javascript:window.location='{cancel_btn}';">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->