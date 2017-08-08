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
                            {name}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-{file_app}" name="form-{file_app}" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            {post}
                            <input type="hidden" class="form-control" name="iddivisi" id="iddivisi" value="{iddivisi}" placeholder="Group Name">
                            <div class="form-group">
                                <label for="name">Group Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{name}" placeholder="Group Name">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_admin" value="1" {is_admin}> Backend access
                                </label>
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