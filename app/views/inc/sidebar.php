<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="<?php echo URLROOT; ?>" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline"><?php echo SITENAME; ?></span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="<?php echo URLROOT; ?>" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Trang Chủ</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/medicines" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-capsule"></i> <span class="ms-1 d-none d-sm-inline">Thuốc</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/categories" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Danh Mục</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/suppliers" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-truck"></i> <span class="ms-1 d-none d-sm-inline">Nhà Cung Cấp</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/sales" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-cart"></i> <span class="ms-1 d-none d-sm-inline">Bán Hàng</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/reports" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-file-earmark-text"></i> <span class="ms-1 d-none d-sm-inline">Báo Cáo</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/users" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Người Dùng</span>
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/settings" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-gear"></i> <span class="ms-1 d-none d-sm-inline">Cài Đặt</span>
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="User" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">Quản Trị</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Hồ Sơ</a></li>
                <li><a class="dropdown-item" href="#">Cài Đặt</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Đăng Xuất</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="col py-3"><?php if(isset($_SESSION['flash'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['flash']['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?> 