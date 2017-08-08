<body>
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url() ?>">Bantuin</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo base_url() ?>home/insiden">Insiden</a>
                    </li>
                    <?php 
                    if (!$this->session->userdata('user')) {
                    ?>
                        <li>
                            <a href="<?php echo base_url() ?>organisasi/register">Daftar Organisasi</a>
                        </li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <?php 
                if ($this->session->userdata('user')) {
                ?>
                    <p class="lead"><?php echo 'Haii, '.$this->session->userdata('user')['nama'] ?></p>
                <?php 
                }
                ?>
                <div id="MainMenu">
                    <div class="list-group panel">
                        <?php 
                        if ($this->session->userdata('user')) {
                            echo sprintf("<a href='%s' class='list-group-item'>Profil</a>", base_url().'profile');
                            if ($this->session->userdata('user')['role']=='korlap') {
                                echo sprintf("<a href='%s' class='list-group-item'>Atur Insiden</a>", base_url().'insiden');
                                // echo sprintf("<a href='%s' class='list-group-item'>Atur Aktivitas</a>", base_url().'aktivitas');
                            }
                            if ($this->session->userdata('user')['role']=='admin_org') {
                            ?>
                                <a href='#org' class='list-group-item' data-toggle="collapse" data-parent="#MainMenu">Atur Organisasi &nbsp;<i class="fa fa-caret-down"></i></a>
                                <div class="collapse" id="org">
                                    <a href="<?php echo base_url() ?>organisasibank" class="list-group-item">Bank</a>
                                    <a href="<?php echo base_url() ?>userorganisasi" class="list-group-item">User Organisasi</a>
                                </div>
                        <?php
                        }
                        ?>
                            <?php 
                            if ($this->session->userdata('user')['role']=='korlog') {
                                echo sprintf("<a href='%s' class='list-group-item'>Atur Insiden</a>", base_url().'insiden');
                            }
                            ?>
                            <?php 
                            if ($this->session->userdata('user')['role']=='leader') {
                                echo sprintf("<a href='%s' class='list-group-item'>Atur Insiden</a>", base_url().'insiden');
                            }
                            ?>
                            <a target="_blank" href="<?php echo base_url() ?>laporan/history" class="list-group-item">Laporan Pemberi Bantuan</a>
                            <a href="<?php echo base_url() ?>users/logout" class="list-group-item">Keluar</a>
                        <?php 
                        } else {
                        ?>
                            <a href="<?php echo base_url() ?>pemberibantuan/register" class="list-group-item">Daftar</a>
                            <a href="<?php echo base_url() ?>users/login" class="list-group-item">Masuk</a>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
            </div>