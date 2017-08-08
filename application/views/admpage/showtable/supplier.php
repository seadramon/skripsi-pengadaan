<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jayadata CMS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=assets_folder('admin')?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
<!--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?=assets_folder('admin')?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
<!--    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
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

<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" xmlns="http://www.w3.org/1999/html"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Supplier
        </h1>
    </section>
    <script>
        function select_item(item)
        {
            targetitem.value = item;
            top.close();

            return false;
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
                    <div class="box-body table-responsive">

                        {error_msg}
                        {success_msg}
                        {info_msg}

                        <form id="listcust" name="listcust" action="#" method="post" >
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                                <th>Supplier ID</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Fax</th>
                            </tr>
                            {data}
                            <tr>
                                <td>{no}</td>
                                <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                <td><a href="" onClick='return select_item("{id}")'>{id}</a></td>
                                <td>{email}</td>
                                <td>{telp}</td>
                                <td>{fax}</td>
                            </tr>
                            {/data}
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {pagination}

                        <input type="hidden" id="temp_id" value=""/>
                        <div class="pull-right"></div>
                    </div>
                        </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
<!-- </div> --><!-- /.content-wrapper -->