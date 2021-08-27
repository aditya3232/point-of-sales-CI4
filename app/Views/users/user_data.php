<!-- dashboard extend dengan template -->
<?= $this->extend('template') ?>

<!-- title -->
<?= $this->section('title') ?>
<title>Users Data &mdash; myPOS</title>
<?= $this->endSection()?>


<!-- konten tampil customer data -->
<?= $this->section('content') ?>
<!-- Judul Utama -->
<div class="card-header">
    <div class="row">
        <div class="col-xl-6 text-left">
            <i class="align-middle mr-2" data-feather="user"></i><span class="align-middle"><strong class="mr-2">Users</strong>Pengguna</span>
        </div>
        <div class="col-xl-6 text-right">
            <a href="<?= site_url('user/add') ?>" class="btn btn-success"><i class="align-middle mr-2" data-feather="plus"></i> Add New</a>
        </div>
    </div>
</div>

<!-- menampilkan session dengan key 'pesan' -->
<?php if(session()->getFlashdata('pesan')) : ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="alert-message">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
</div>
<?php endif; ?>

<!-- table -->
<div class="col-12 col-xl mt-3">
    <div class="card">
        <div class="card-header">
            <!-- form search/pencarian -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 text-left">
                        <h1 class="card-title">Data Users</h1>
                    </div>
                    <div class="col-6 text-right">
                        <form class="d-none d-sm-inline-block" method="GET">
                            <div class="input-group input-group-navbar">
                                <input type="text" class="form-control" placeholder="Search…" aria-label="Search" name="keyword">
                                <button class="btn" type="submit" name="submit">
                                    <i class="align-middle" data-feather="search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- akhir form search/pencarian  -->
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Level</th>
                        <th>User Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- inisialisasi $i = 1; (digunakan untuk looping nomor baris)-->
                    <!-- page dimulai dengan no.1 + (banyak data yg ditampilkan x (currentPage-1)) -->
                    <!-- misal kita berada di halaman 2, -->
                    <!-- maka $i = 1 + (5 x (2-1)), $i = 6, -->
                    <!-- jadi penomoran data dihalaman ke-2 akan dimulai dari no.6 -->
                    <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                    <?php foreach($user as $users): ?>
                    <tr>
                        <td><?= $i++; ?></td> <!-- looping $i (nomor baris) -->
                        <td><?= $users['username']; ?></td>
                        <td><?= $users['name']; ?></td>
                        <td><?= $users['address']; ?></td>
                        <td><?= $users['level']; ?></td>
                        <td><img src="<?= base_url(); ?>/img/<?= $users['user_image']; ?>" alt="" class="ukuran_image"></td>
                        <td class="table-action">
                            <form action="<?= site_url('user/setting/'. $users['user_id']) ?>" method="POST" class="d-inline" id="edit">
                                <?= csrf_field(); ?>
                                <button class="btn btn-outline-warning btn-sm"><i class="align-middle" data-feather="edit-2"></i></button>
                            </form>
                            <!-- fitur delete dengan http method spoofing -->
                            <!-- menuju controller User dengan mengirimkan user_id berdasarkan database -->
                            <!-- ketika menggunakan http method spoofing harus diberikan routes -->
                            <form action="<?= site_url('user/del/' . $users['user_id']); ?>" method="POST" class="d-inline" id="GFG">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('apakah anda yakin?')"><i class="align-middle" data-feather="trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endForeach; ?>
                </tbody>
            </table>
            <br>
            <!-- pager  parameter1=nama tabel, parameter2=file pagination-->
            <?= $pager->links('user', 'my_pagination') ?>


        </div>

    </div>
</div>
<?= $this->endSection()?>