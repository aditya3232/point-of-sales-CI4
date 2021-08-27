<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- konten title -->
<?= $this->section('title') ?>
<title>Dashboard &mdash; myPOS</title>
<?= $this->endSection()?>


<!-- konten dashboard -->
<?= $this->section('content') ?>
<i class="align-middle mr-2 " data-feather="aperture"></i><span class="align-middle"><strong>Dashboard</strong> Control Panel</span>

<div class="row mt-3">
    <!-- card 1 -->
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">ITEMS</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle mr-2" data-feather="briefcase"></i>
                        </div>
                    </div>
                </div>
                <!-- atur basecontroller agar dapat meload variabel Datadashboard-->
                <!-- echo bisa diganti dengan '=' -->
                <h1 class="mt-1 mb-3"><?= $count_item; ?></h1>
            </div>
        </div>
    </div>

    <!-- card 2 -->
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">SUPPLIERS</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="truck"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?php echo $count_supplier; ?></h1>
            </div>
        </div>
    </div>

    <!-- card 3 -->
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">CUSTOMERS</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle mr-2" data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?php echo $count_customer; ?></h1>
            </div>
        </div>
    </div>

    <!-- card 4 -->
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">USERS</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle mr-2" data-feather="user-plus"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?= $count_user; ?></h1>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection()?>