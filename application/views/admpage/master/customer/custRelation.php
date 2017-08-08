<div class="col-xs-6">
    <div class="box">
        <div class="box-header">
        <h3 class="box-title">Master Credit Limit</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                    <th>Name</th>
                    <th>Credit Limit</th>
                    <th>Date Start</th>
                </tr>
                {credit}
                <tr class="clickRow" href="#" url="<?php echo base_url() ?>admpage/master/customer/tblDetail/{no}">
                    <td>{no}</td>
                    <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                    <td><a href="{edit_href}">{name}</a></td>
                    <td>{credit_limit}</td>
                    <td>{date_start}</td>
                </tr>
                {/credit}
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->

<div id="groupId" class="col-xs-6">
    <div class="box">
        <div class="box-header">
        <h3 class="box-title">Master Group ID</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <form id="form-{file_app}" name="form-{file_app}" action="#" method="post" >
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px"><input type="checkbox" onclick="javascript:checkedAll('form-{file_app}', true);" id="primary_check"></th>
                    <th>Group ID</th>
                    <th>Description</th>
                </tr>
                {groupId}
                <tr class="clickRow" href="#" url="<?php echo base_url() ?>admpage/master/customer/tblDetail/{no}">
                    <td>{no}</td>
                    <td><input type="checkbox" name="CheckBox_Delete_{id}" value="{id}" id="del{id}" class="delete" onclick="javascript:select_record('{id}');"></td>
                    <td><a href="{edit_href}">{customer_group_id}</a></td>
                    <td>{customer_group_desc}</td>
                </tr>
                {/groupId}
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->