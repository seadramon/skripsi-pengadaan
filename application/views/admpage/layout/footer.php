<footer class="main-footer">
<!--    <div class="pull-right hidden-xs">-->
<!--        <b>Version</b> 2.0-->
<!--    </div>-->
    <strong>Copyright &copy; <?=date('Y')?> <a href="#">Bina Adidaya</a>.</strong> All rights reserved.
</footer>

</div><!-- ./wrapper -->

 <!-- jQuery 2.1.3  -->
<script src="<?=assets_folder('admin')?>plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Custom Aplikasi -->
<script src="<?=assets_folder('admin')?>js/giga.js"></script>
<!-- jQuery UI 1.11.2 -->
<script src="<?=assets_folder('admin')?>plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?=assets_folder('admin')?>js/bootstrap.min.js" type="text/javascript"></script>

<!-- DataTables -->
<script src="<?=assets_folder('admin')?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=assets_folder('admin')?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<!-- Morris.js charts -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!--<script src="--><?//=assets_folder('admin')?><!--plugins/morris/morris.min.js" type="text/javascript"></script>-->
<!-- Sparkline -->
<script src="<?=assets_folder('admin')?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?=assets_folder('admin')?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?=assets_folder('admin')?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?=assets_folder('admin')?>plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
<script src="<?=assets_folder('admin')?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?=assets_folder('admin')?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=assets_folder('admin')?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="<?=assets_folder('admin')?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="<?=assets_folder('admin')?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=assets_folder('admin')?>js/app.min.js" type="text/javascript"></script>

<script src="<?=assets_folder('admin')?>plugins/jquery.confirm.min.js" type="text/javascript"></script>

<!-- Autocomplete -->
<!--<script src="<?=assets_folder('admin')?>plugins/autocomplete/mockjax.js" type="text/javascript"></script>
<script src="<?=assets_folder('admin')?>plugins/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
<script src="<?=assets_folder('admin')?>plugins/autocomplete/autocomplete.js" type="text/javascript"></script>-->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="--><?//=assets_folder('admin')?><!--/js/pages/dashboard.js" type="text/javascript"></script>-->
<script src="<?=assets_folder('admin')?>js/ajax_kategori.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?=assets_folder('admin')?>/js/custom.js" type="text/javascript"></script>
<script type="text/javascript">
	function popupwindow(url, title, w, h) {
	  var left = (screen.width/2)-(w/2);
	  var top = (screen.height/2)-(h/2);
	  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	} 
</script>
</body>
</html>