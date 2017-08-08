<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Material Receipt
            <small>Add / Edit</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- form start -->
        <form id="receipt_h" name="receipt_h" action="<?php echo $action ?>" method="post" role="form" enctype="multipart/form-data">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
<!--                        <h3 class="box-title">Quick Example</h3>-->
                        {error_msg}
                            {document_type}
                            {document_origin_id}
                            {document_reference}
                        {/error_msg}
                        {db_msg}
                        {success_msg}
                    </div><!-- /.box-header -->
                        <input type="hidden" name="site_id" value="<?php echo $this->session->userdata('ADM_SESS')['site_id']; ?>">
                        <!-- <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>"> -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="docid">Document ID</label>
                                <input type="text" readonly class="form-control" name="document_id" id="document_id_mReceipt" value="<?php echo $this->session->userdata('RECEIPT')['document_id'] ?>" placeholder="Click to Choose Document ID" onClick='targetitem = document.receipt_h.document_id; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/receipt/getDocId",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem'>
                            </div>
                            <div class="form-group">
                                <label for="transaction">Transaction Type</label>
                                <?php echo form_dropdown('document_type', $document_type, $this->session->userdata('RECEIPT')['document_type'], 'class="form-control" id="document_type"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" name="document_origin_id" id="document_origin_id" value="<?php echo $this->session->userdata('RECEIPT')['document_origin_id'] ?>" placeholder="Supllier" >
                                <input type="button" value="Get Data Supplier" onClick='targetitem = document.receipt_h.document_origin_id; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/supplier",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem'/>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Document Reference</label>
                                <input type="text" class="form-control" name="document_reference" id="document_reference" value="<?php echo $this->session->userdata('RECEIPT')['document_reference'] ?>" placeholder="Document Reference" >
                                <input type="button" value="Get Document Reference" onClick='targetitem = document.receipt_h.document_reference; 
 dataitem = window.open("<?php echo base_url() ?>admpage/showtable/purchase_header",
 "dataitem","width=600,height=400,scrollbars=yes"); dataitem.targetitem = targetitem'/>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="pull-right">
                                <input type="button" id="linkDetail" class="btn btn-primary" onclick="tMaterialAddDetail('toDetail')" url="<?php echo base_url().'admpage/inventory/receipt/transaction/' ?>" value="Add Transaction">
                            </div>
                        </div>
                </div><!-- /.box -->

            </div><!--/.col -->
        </div>   <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Transaction Table</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="parent" class="table table-bordered table-hover">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                <th>Produk ID</th>
                                <th>Name</th>
                                <th>Exp Date</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Gross Amount</th>
                                <th>Net Amount</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                            $totalAmt = 0;
                            $i = 0;
                            if (count($tblTransaction) > 0) {
                                foreach ($tblTransaction as $row) {
                                    if (is_array($row['qty']) && count($row['qty']) > 0) {
                                        $inPrice = $row['price'];
                                        $measure = isset($row['measure'])?$row['measure']:"";
                                        $highMeasure = isset($row['HighestMeasure'])?$row['HighestMeasure']:"";
                                        $lowMeasure = isset($row['lowMeasure']['qty'])?$row['lowMeasure']['qty']:"";
                            ?>
                            <input type="hidden" name="stockEntry" value="<?php echo $lowMeasure; ?>">
                            <?php
                                        foreach ($row['qty'] as $keyQty => $valQty) {
                                            $price = $row['price'];
                                            $curMeasure = 0;
                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                                <td>
                                                    <?php echo $row['product_id']; ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][product_id]" value="<?php echo $row['product_id']; ?>">
                                                </td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td>
                                                    <?php echo $row['expired_date'] ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][batch_number]" value="<?php echo isset($row['batch_number'])?$row['batch_number']:''; ?>">
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][expired_date]" value="<?php echo isset($row['expired_date'])?$row['expired_date']:''; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $keyQty; ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][unit_id]" value="<?php echo $keyQty; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $valQty; ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][qty]" value="<?php echo $valQty; ?>">
                                                </td>
                                                <?php 
                                                    if (is_array($highMeasure) && count($highMeasure) > 0) {
                                                        if (is_array($measure) && count($measure) > 0) {
                                                            foreach ($measure as $mkey => $mval) {
                                                                if ($keyQty==$mkey) $curMeasure = $mval;
                                                            }
                                                        }
                                                        if ($highMeasure['unit_id']!=$keyQty) {
                                                            $price = round($row['price'] / $highMeasure['measure'] * $curMeasure, 2);
                                                        }
                                                    }
                                                ?>
                                                <td>
                                                    <?php echo $price ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][price]" value="<?php echo $price; ?>">
                                                </td>
                                                <td>
                                                    <?php 
                                                        $grossAmt = round($valQty * $price, 2);
                                                        echo $grossAmt;
                                                    ?>
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][gross_amount]" value="<?php echo $grossAmt; ?>">
                                                    <input type="hidden" name="DETAIL[<?php echo $i ?>][nett_amount]" value="<?php echo $grossAmt; ?>">
                                                </td>
                                                <td><?php echo $grossAmt; ?></td>
                                                <td><a href="<?php echo base_url() ?>admpage/inventory/receipt/deleteDetail/<?php echo $row['product_id'].'-'.$keyQty ?>/<?php echo $event ?>">Delete</a></td>
                                            </tr>
                            <?php 
                                            $totalAmt = round($totalAmt + $grossAmt, 2);
                                        $i++;}
                                    } else {
                            ?>
                                        <tr>
                                            <td></td>
                                            <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                            <td><?php echo $row['product_id']; ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['expired_date'] ?></td>
                                            <td><?php echo !is_array($row['qty'])?$row['qty']:"" ?></td>
                                            <td><?php echo ""; ?></td>
                                            <td><?php echo $row['price'] ?></td>
                                        </tr>    
                            <?php
                                    $i++;}
                                }
                            }
                            ?>
                        </table>
                        <div class="form-group">
                            <label for="nett_amount">Nett Amount</label>
                            <input type="hidden" class="form-control" name="gross_amount" value="<?php echo $totalAmt ?>">
                            <input type="text" class="form-control" name="nett_amount" value="<?php echo $totalAmt ?>">
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <input type="hidden" id="temp_id" value=""/>
                        <div class="pull-right">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                            <a href="<?php echo $resetBtn ?>" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
