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
            Data Customer
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
            <div class="col-md-12">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> Search {menu_title}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="search-{file_app}" name="search-{file_app}" action="{path_app}/search" method="post" role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <input type="text" class="form-control" name="s_name" id="s_name" value="{s_name}" placeholder="Group Name">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- ./box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Group</th>
                                <th>Curren Credit Limit</th>
                                <th>Bill To</th>
                                <th>Status</th>
                            </tr>
                            {data}
                            <tr>
                                <td>{no}</td>
                                <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                                <td><a href="" onClick='return select_item("{id}")'>{name}</a></td>
                                <!-- <td><input type="hidden" name="id" value="{id}">
                                    <a href="" onClick="window.opener.customer.bill_to.value={id}">{name}</a></td> -->
                                <td>{phone1}</td>
                                <td>{cust_group}</td>
                                <td>{current_credit_limit}</td>
                                <td>{bill_toDesc}</td>
                                <td>{status}</td>
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