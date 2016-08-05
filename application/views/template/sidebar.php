<div class="panel-group" id="accordion">
                        <?php if($this->session->userdata('user_role_id') == 1):?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                                        </span> Master Data</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <span class="glyphicon glyphicon-pencil text-primary"></span> <a href="<?php echo site_url('karyawan');?>">Karyawan</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="glyphicon glyphicon-user"></span> <a href="<?php echo site_url('dashboard/admin');?>">Admin</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFours"><span class="glyphicon glyphicon-file">
                            </span> Kelola Gaji</a>
                        </h4>
                    </div>
                    <div id="collapseFours" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book"></span><a href="<?php echo site_url('karyawan/gaji_pokok');?>"> Gaji Pokok</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book"></span><a href="<?php echo site_url('karyawan/potongan_terlambat');?>"> Potongan Telat</a>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-list-alt"></span><a href="<?php echo site_url('laporan/karyawan');?>"> Lembur</a>
                                    </td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                </div>
                        <?php endif;?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
                            </span> Laporan</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book"></span><a href="<?php echo site_url('laporan/presensi');?>"> Data Presensi</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book"></span><a href="<?php echo site_url('laporan/data_gaji');?>"> Data Gaji</a>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td>
                                        <span class="glyphicon glyphicon-list-alt"></span><a href="<?php echo site_url('laporan/karyawan');?>"> Data Penggajian</a>
                                    </td>
                                </tr>-->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="<?php echo site_url('dashboard/logout');?>"><span class="glyphicon glyphicon-off">
                            </span> Logout</a>
                        </h4>
                    </div>
                </div>
</div>