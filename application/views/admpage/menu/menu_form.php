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
                            {parent_id}
                            {menu}
                            {file}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-{file_app}" name="form-{file_app}" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            {post}
                            <div class="form-group">
                                <label>Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="0">-- ROOT --</option>
                                    {list_parent_option}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{name}" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="name">File</label>
                                <input type="text" class="form-control" name="file" id="file" value="{file}" placeholder="File">
                            </div>
                            <div class="form-group">
                                <label for="name">Icon</label>
                                <input type="text" class="form-control" name="icon" id="icon" value="{icon}" placeholder="Icon">
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