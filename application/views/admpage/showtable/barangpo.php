<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bina Adidaya::Pengadaan Barang</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.4 -->
    <link href="<?=assets_folder('admin')?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="<?=assets_folder('admin')?>plugins/datatables/dataTables.bootstrap.css" type="text/css">

    <!-- FontAwesome 4.3.0 -->
    <link href="<?=assets_folder('admin')?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=assets_folder('admin')?>css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="<?=assets_folder('admin')?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?=assets_folder('admin')?>css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?=assets_folder('admin')?>plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?=assets_folder('admin')?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?=assets_folder('admin')?>plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?=assets_folder('admin')?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?=assets_folder('admin')?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?=assets_folder('admin')?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Autocomplete -->
    <link href="<?=assets_folder('admin')?>css/autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="<?=assets_folder('admin')?>css/style.css" rel="stylesheet" type="text/css" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Barang Order Pembelian
        </h1>
    </section>
    <script>
        function select_item(item, jml)
        {
            var jml = document.getElementById(jumlah);
            targetitem.value = item;
            jml.value = jml;
            top.close();

            return false;
        }

        function sendValue(brgAttr, value, jmlAttr, jml) {
            window.opener.updateValue(brgAttr, value, jmlAttr, jml);
            window.close();
        }
    </script>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <!--                        <h3 class="box-title">Quick Example</h3>-->
                    </div><!-- /.box-header -->
                        {error_msg}
                        {success_msg}
                        {info_msg}
                        <form id="listcust" name="listcust" action="#" method="post" >
                            <table id="dataTable_id" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data}
                                    <tr onmouseover="this.style.cursor='pointer'" onclick="clickRow('<?php echo base_url() ?>admpage/master/customer/custRelation/{id}/{customer_group_id}')">
                                        <td>{no}</td>
                                        <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                        <td><a href="" onClick='sendValue("{brgAttr}", "{id}", "{jmlAttr}", "{jumlah}")'>{nama}</a></td>
                                        <td>{jumlah} {satuan}</td>
                                    </tr>
                                    {/data}
                                </tbody>
                            </table>
                            <div class="box-footer clearfix">
                                <input type="hidden" id="temp_id" value=""/>
                                <div class="pull-right"></div>
                            </div>
                        </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper  -->
<?php 
$this->load->view('admpage/layout/footer');
?>