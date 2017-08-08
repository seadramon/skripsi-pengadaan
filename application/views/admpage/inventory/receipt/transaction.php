<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaction
            <small>Add / Edit</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
<!--                        <h3 class="box-title">Quick Example</h3>-->
                        {info_msg}
                            {product_id}
                            {batch_number}
                            {expired_date}
                            {qty}
                            {price}
                        {/info_msg}
                        {error_msg}
                        {success_msg}
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="receipt_h" name="receipt_h" action="<?php echo $action ?>" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="site_id" value="<?php echo $this->session->userdata('ADM_SESS')['site_id']; ?>">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div id="produkId" class="form-group">
                                <label for="produkId">Product ID</label>
                                <input id="produk_id" type="text" class="form-control" name="product_id" placeholder="Produk ID" readonly>
                                <input type="hidden" class="form-control" name="name" id="produk_name">
                            </div>
                            <div id="batch" class="form-group">
                                <label for="batch">Batch</label>
                                <input type="text" class="form-control" name="batch_number" placeholder="Batch">
                            </div>
                            <div id="expired" class="form-group">
                                <label for="exp_date">Expired Date</label>
                                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" name="expired_date" placeholder="Exp Date">
                            </div>
                            <h4 id="qtyId">Quantity</h4>
                            <!-- <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <div class="form-group" id="qtyId">
                                    <label for="CRT">CRT</label>
                                    <input type="text" class="form-control" name="crt" placeholder="CRT">
                                    <label for="PCS">PCS</label>
                                    <input type="text" class="form-control" name="pcs" placeholder="PCS">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" placeholder="Price">
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <a href="<?php echo base_url() ?>admpage/inventory/receipt/header" class="btn btn-danger">Back to Header</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col -->

            <div id="paginationID">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Pilih Product</h3>
                            <div class="box-tools">
                                <form method="post" name="fsearchProduct" id="fsearchProduct" url="<?php echo base_url() ?>admpage/inventory/receipt/transactionMirror">
                                    <div class="input-group">
                                      <?php echo form_dropdown('searchBy', $msProduct['searchBy'], "", 'id="searchBy"'); ?>
                                      <input type="text" name="searchVal" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                      <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default" onclick="searchProduct()"><i class="fa fa-search"></i></button>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
                            <div class="box-body table-responsive">
                                <table id="parent" class="table table-bordered table-hover">
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                    </tr>
                                    <?php 
                                    if (count($msProduct['product']) > 0) {
                                        foreach ($msProduct['product'] as $rowProduct) {
                                    ?>
                                    <tr onmouseover="this.style.cursor='pointer'" onclick="rowProductMReceipt('<?php echo base_url() ?>admpage/inventory/receipt/freceiptDetailCustom/<?php echo $rowProduct['product_id'] ?>')">
                                        <td></td>
                                        <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                        <td><a href="{edit_href}"><?php echo $rowProduct['product_id'] ?></a></td>
                                        <td><?php echo $rowProduct['name'] ?></td>
                                        <td><?php echo $rowProduct['stock'] ?></td>
                                        <td><?php echo $rowProduct['price'] ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </table>
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <?php echo $msProduct['page_links']; ?>
                                <input type="hidden" id="temp_id" value=""/>
                                <div class="pull-right">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div>
            </div>
        </div>   <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
