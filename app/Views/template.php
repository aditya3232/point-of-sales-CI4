<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="shortcut icon" href="<?= base_url() ?>/assets/dist/img/icons/icon-48x48.png" />

    <!-- judul dinamis -->
    <?= $this->renderSection('title') ?>

    <!-- <link href="css/app.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>/assets/dist/css/app.css" rel="stylesheet">
    <!-- my css -->
    <link href="<?= base_url() ?>/assets/dist/css/mystyle.css" rel="stylesheet">
    <!-- datatable -->
    <link href="<?= base_url() ?>/assets/dist/dtable/datatables.min.css" rel="stylesheet">
    <!-- script jquery -->
    <!-- script jquery harus diletakkan diatas, karena ada bebrapa view yg membutuhkan jquery -->
    <script src="<?= base_url(); ?>/assets/dist/js/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="wrapper">
        <!-- sidebar -->
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="<?= site_url() ?>">
                    <span class="align-middle">myPOS</span>
                </a>

                <ul class="sidebar-nav">

                    <li class="sidebar-header">
                        MAIN NAVIGATION
                    </li>

                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'dashboard' ? 'active' : '';  ?>">
                        <a class="sidebar-link" href="<?= site_url() ?>">
                            <i class="align-middle mr-2" data-feather="aperture"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'supplier' ? 'active' : '';  ?>">
                        <a class="sidebar-link" href="<?= site_url('supplier') ?>">
                            <i class="align-middle mr-2" data-feather="truck"></i> <span class="align-middle">Supplier</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'customer'  ? 'active' : '';  ?>">
                        <a class="sidebar-link" href="<?= site_url('customer') ?>">
                            <i class="align-middle mr-2" data-feather="users"></i> <span class="align-middle">Customers</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'category' || current_url(true)->getSegment(1) == 'unit' || current_url(true)->getSegment(1) == 'item' ? 'active' : '';  ?>">
                        <a data-target="#ui" data-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Products</span>
                        </a>
                        <ul id="ui"
                            class="sidebar-dropdown list-unstyled collapse <?= current_url(true)->getSegment(1) == 'category' || current_url(true)->getSegment(1) == 'unit' || current_url(true)->getSegment(1) == 'item' ? 'show' : '';  ?>"
                            data-parent="#sidebar">
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'category' ? 'active' : '';  ?>">
                                <a class="sidebar-link" href="<?= site_url('category') ?>">Categories</a>
                            </li>
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'unit' ? 'active' : '';  ?>">
                                <a class="sidebar-link" href="<?= site_url('unit') ?>">Units</a>
                            </li>
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'item' ? 'active' : '';  ?>">
                                <a class="sidebar-link" href="<?= site_url('item') ?>">Items</a>
                            </li>
                        </ul>
                    </li>
                    <!-- activekan menu ketika ada segment(1) == stock, non-activekan ketika tidak ada segemnt(1) == 'stock'   -->
                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'stock' || current_url(true)->getSegment(1) == 'sale' ? 'active' : '';  ?>">
                        <a data-target="#forms1" data-toggle="collapse" class="sidebar-link">
                            <i class="align-middle mr-2" data-feather="shopping-cart"></i> <span class="align-middle">Transactions</span>
                        </a>
                        <!-- ketika ada segment(1) url == 'stock', maka akan menampilkan menu dropdown -->
                        <ul id="forms1" class="sidebar-dropdown list-unstyled collapse <?= current_url(true)->getSegment(1) == 'stock' || current_url(true)->getSegment(1) == 'sale'  ? 'show' : '';  ?>" data-parent="#sidebar">
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'sale' ? 'active' : '';  ?>"><a class="sidebar-link" href="<?= site_url('sale'); ?>">Sales</a></li>
                            <!-- activekan menu ketika ada segment(1,2) == stock/in, non-activekan ketika tidak ada segemnt(1,2) == 'stock/in'   -->
                            <li class="sidebar-item  <?= current_url(true)->getSegment(1) == 'stock' && current_url(true)->getSegment(2) == 'in' ? 'active' : '';  ?>"><a class="sidebar-link" href="<?= site_url('stock/in'); ?>">Stock In</a>
                            </li>
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'stock' && current_url(true)->getSegment(2) == 'out' ? 'active' : '';  ?>"><a class="sidebar-link" href="<?= site_url('stock/out'); ?>">Stock
                                    Out</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'reportsale' ? 'active' : '';  ?>">
                        <a data-target="#forms2" data-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle mr-2" data-feather="activity"></i> <span class="align-middle">Reports</span>
                        </a>
                        <ul id="forms2" class="sidebar-dropdown list-unstyled collapse <?= current_url(true)->getSegment(1) == 'reportsale'? 'show' : '';  ?>" data-parent="#sidebar">
                            <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'reportsale' ? 'active' : '';  ?>"><a class="sidebar-link" href="<?= site_url('reportsale'); ?>">Sales</a></li>
                        </ul>
                    </li>

                    <!-- menampilkan tampilan menu users jika ada session 1 saja -->
                    <?php if(session('level') == 1) { ?>
                    <li class="sidebar-header">
                        SETTINGS
                    </li>
                    <li class="sidebar-item <?= current_url(true)->getSegment(1) == 'user' ? 'active' : '';  ?>">
                        <a class="sidebar-link" href="<?= site_url('user') ?>">
                            <i class="align-middle mr-2" data-feather="user"></i> <span class="align-middle">Users</span>
                        </a>
                    </li>
                    <?php } ?>

                </ul>
            </div>
        </nav>
        <!-- akhir sidebar -->

        <!-- navbar -->
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">4</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 New Notifications
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-danger" data-feather="alert-circle"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Update completed</div>
                                                <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                                                <div class="text-muted small mt-1">30m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-warning" data-feather="bell"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Lorem ipsum</div>
                                                <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-primary" data-feather="home"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Login from 192.186.1.8</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-success" data-feather="user-plus"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">New connection</div>
                                                <div class="text-muted small mt-1">Christina accepted your request.</div>
                                                <div class="text-muted small mt-1">14h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/dist/img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Vanessa Tucker</div>
                                                <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
                                                <div class="text-muted small mt-1">15m ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/dist/img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">William Harris</div>
                                                <div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
                                                <div class="text-muted small mt-1">2h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/dist/img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Christina Mason</div>
                                                <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
                                                <div class="text-muted small mt-1">4h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <img src="/assets/dist/img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="text-dark">Sharon Lessman</div>
                                                <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
                                                <div class="text-muted small mt-1">5h ago</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                                <img src="<?= base_url('/img/'.session()->get('user_image')); ?>" class="avatar img-fluid rounded mr-1" /> <span class="text-dark"><?= session()->get('name'); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="pages-profile.html"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages-settings.html"><i class="align-middle mr-1" data-feather="settings"></i> Settings & Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <!-- logout -->
                                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- akhir navbar -->

            <!-- content -->
            <main class="content">
                <!-- konten dinamis -->
                <?= $this->renderSection('content') ?>
            </main>
            <!-- akhir konten -->

            <!-- footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <p class="mb-0">
                                <a href="index.html" class="text-muted"><strong>Copyright &copy; <?= date('Y'); ?> Muhammad Aditya.</strong></a>
                                <span>All rights reserved</span>
                            </p>
                        </div>
                        <div class="col-6 text-right">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- akhir footer -->
        </div>
    </div>


    <!-- script theme -->
    <script src="<?= base_url() ?>/assets/dist/js/app.js"></script>

    <!-- script preview gambar -->
    <script>
    function previewImg() {
        // ambil image-nya
        const imgPreview = document.querySelector('.img-preview');
        // ambil file yg diupload (di tag input wajib set id='image')
        const fileImage = new FileReader();
        fileImage.readAsDataURL(image.files[0]);
        // ganti preview-nya
        fileImage.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
    </script>

    <!-- script yg akan muncul ketika diklik button [dengan id="select"]. berada di create_stock_in_data -->
    <!-- 
    - sebelum menjalankan jquery jgn lupa aplikasinya harus sudah ada jquery ny
    - $(document).ready(function() { adalah event dari JQuery yang dijalankan pertama kali setelah dokumen dimuat.
    - ketika diklik bagian id select (id select ada di button), maka akan menjalankan function()
    - functionnya akan menyimpan data ketika di klik select, kemudian menset form sesuai dengan isi yang diselect 
    -->
    <script>
    $(document).ready(function() {
        $(document).on('click', '#select', function() {
            // data-id di button select modal, disimpan di variabel item_id
            var item_id = $(this).data('id');
            var barcode = $(this).data('barcode');
            var name = $(this).data('name');
            var unit_name = $(this).data('unit');
            var stock = $(this).data('stock');
            // data variabel item_id, kemudian ditampilan di <input id="item_id">
            // pakai val jika <input>
            $('#item_id').val(item_id);
            $('#barcode').val(barcode);
            $('#item_name').val(name);
            $('#unit_name').val(unit_name);
            $('#stock').val(stock);
            $('#modal-item').modal('hide');

        })
    })
    </script>

    <!-- script yg akan muncul ketika diklik button [dengan id="detail_stock_in"] -->
    <!-- val ganti text, karena pakai span -->
    <script>
    $(document).ready(function() {
        $(document).on('click', '#detail_stock_in', function() {
            // data-barcode di button detail disimpan di variabel barcode
            var barcode = $(this).data('barcode');
            var itemname = $(this).data('itemname');
            var detail = $(this).data('detail');
            var suppliername = $(this).data('suppliername');
            var qty = $(this).data('qty');
            var date = $(this).data('date');
            // data variabel barcode, kemudian ditampilan di <span id="barcode">
            // pakai text jika <span>
            $('#barcode').text(barcode);
            $('#item_name').text(itemname);
            $('#detail').text(detail);
            $('#supplier_name').text(suppliername);
            $('#qty').text(qty);
            $('#date').text(date);

        })
    })
    </script>

    <!-- script datatable -->
    <script src="<?= base_url() ?>/assets/dist/dtable/datatables.min.js"></script>

    <!-- script untuk implementasi datatable hanya untuk table_for_modal -->
    <script>
    $(document).ready(function() {
        $('#table_datatables').DataTable();
    });
    </script>

    <!-- script agar ketika tag span diklik maka yg keluar adalah input file (yg terhidden) -->
    <!-- script ini digunakan di tombol upload di user -->
    <script>
    document.getElementById('button_upload').addEventListener('click', openDialog);

    function openDialog() {
        document.getElementById('image').click();
    }
    </script>

    <!-- hidden element -->
    <!-- <script>
    document.getElementById('button_add').addEventListener('click', closeElement);

    function closeElement() {
        document.getElementById('no_item_available').style.visibility = 'hidden';
    }
    </script> -->



</body>

</html>