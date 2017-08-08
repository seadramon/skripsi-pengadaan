<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <div class="page-content">
      <!-- BEGIN PAGE CONTENT-->        
      <div class="row">
         <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->                
            <div class="portlet">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-search"></i><?php echo $title ?></div>
                  <div class="tools"><a href="javascript:;" class="expand"></a></div>
               </div>
            </div>
            <!-- END Portlet PORTLET-->            
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->                
            <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="16%">Tanggal &amp; Jam</th>
                           <th width="14%">Mall &amp; Kota</th>
                           <th width="14%">Nama</th>
                           <th width="14%">No. Telepon</th>
                           <th width="14%">Email</th>
                           <th width="14%">Provider</th>
                           <!-- <th width="14%">Status</th> -->
                           <th width="14%">Hadiah</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($groups as $val) { ?>
                           <tr>
                              <td><?php echo $val['datetime'] ?></td>
                               <td><?php echo $val['mall'] ?></td>
                               <td><?php echo $val['name'] ?></td>
                               <td><?php echo $val['phone'] ?></td>
                               <td><?php echo $val['email'] ?></td>
                               <td>
                                 <?php
                                    echo $val['provider'];
                                    /*if ($val['status']=='1') {
                                       echo 'Menang';
                                    } else {
                                       echo 'Kalah';
                                    }*/
                                 ?>
                               </td>
                               <td><?php echo $val['prize'] ?></td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->            
         </div>
      </div>
      <!-- END PAGE CONTENT-->    
   </div>
</div>
<!-- END CONTENT

