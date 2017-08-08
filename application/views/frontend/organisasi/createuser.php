<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-9">

            <div class="thumbnail">
                <div class="caption-full">
                    <?php 
                    if (is_array($error_msg) && count($error_msg) > 0) {
                        foreach ($error_msg as $val) {
                            echo $val;
                        }
                    }

                    if (is_array($success_msg) && count($success_msg) > 0) {
                        foreach ($success_msg as $val) {
                            echo $val;
                        }
                    }

                    if (is_array($error_sess) && count($error_sess) > 0) {
                        foreach ($error_sess as $val) {
                            echo $val;
                        }
                    }
                    ?>
                    <h3>Create User Organisasi</h3>
                    <hr>
                    <?php 
                    $idorganisasi = $organisasi['id_organisasi'];
                    ?>
                    <form id="bookForm" action="<?php echo base_url() ?>organisasi/submitUser" method="post" class="form-horizontal">
                        <input type="hidden" name="id_organisasi" value="<?php echo $organisasi['id_organisasi']; ?>">
                        <input type="hidden" name="confirmation_code" value="<?php echo $confcode; ?>">
                        <div class="form-group">
                            <div class="col-xs-4">
                                <b>Nama</b>
                                <input type="text" class="form-control" name="user[0][nama]" placeholder="Nama" />
                            </div>
                            <div class="col-xs-4">
                                <b>Email</b>
                                <input type="email" class="form-control" name="user[0][email]" placeholder="Email" />
                            </div>
                            <div class="col-xs-2">
                                <b>Jabatan</b>
                                <?php echo form_dropdown('user[0][role]', $role, "", 'class="form-control" id="role"'); ?>
                            </div>
                            <div class="col-xs-1">
                                &nbsp;
                                <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <!-- The template for adding new field -->
                        <div class="form-group hide" id="bookTemplate">
                            <div class="col-xs-4">
                                <b>Nama</b>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" />
                            </div>
                            <div class="col-xs-4">
                                <b>Email</b>
                                <input type="email" class="form-control" name="email" placeholder="Email" />
                            </div>
                            <div class="col-xs-2">
                                <b>Jabatan</b>
                                <?php echo form_dropdown('role', $role, "", 'class="form-control" id="role"'); ?>
                            </div>
                            <div class="col-xs-1">
                                &nbsp;
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container -->

