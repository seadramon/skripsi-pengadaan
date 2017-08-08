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
                            {phone1}
                            {customer_group_id}
                            {bill_to}
                            {current_credit_limit}
                        {/error_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="customer" name="customer" action="{action}" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="site_id" value="<?php echo $this->session->userdata('ADM_SESS')['site_id']; ?>">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            {post}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{name}" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address">{address}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="merk">Phone</label>
                                <input type="text" class="form-control" name="phone1" id="phone1" value="{phone1}" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label for="group">Group</label>
                                <?php echo form_dropdown('customer_group_id', $groupId, array_key_exists('customer_group_id', $post[0])?$post[0]['customer_group_id']:"", 'class="form-control" id="customer_group_id"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="bill_to">Bill To</label>
                                <input type="text" class="form-control" name="bill_to" id="bill_to" value="{bill_to}" placeholder="Bill to" >
                                <!-- <input type="button" onclick="popup('<?php echo base_url() ?>admpage/showtable/customer')" value="Get Data Customer"> -->
                                <input type="button" value="Get Data Customer" onClick='targetitem = document.customer.bill_to; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/customer",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem'/>
                            </div>
                            <div class="form-group">
                                <label for="current_credit_limit">Current Credit Limit</label>
                                <input type="text" class="form-control" name="current_credit_limit" id="current_credit_limit" value="{current_credit_limit}" placeholder="Current Credit Limit">
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
