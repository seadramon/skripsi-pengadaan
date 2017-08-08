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