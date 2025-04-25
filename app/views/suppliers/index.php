<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <h1>Quản lý nhà cung cấp</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/suppliers/add" class="btn btn-primary float-end">
            <i class="bi bi-plus-circle"></i> Thêm nhà cung cấp
        </a>
    </div>
</div>

<?php if(isset($_SESSION['flash'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['flash']['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh Sách Nhà Cung Cấp</h6>
    </div>
    <div class="card-body">
        <?php if(count($data['suppliers']) > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Địa chỉ</th>
                            <th>Điện thoại</th>
                            <th>Email</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['suppliers'] as $supplier) : ?>
                            <tr>
                                <td><?php echo $supplier->id; ?></td>
                                <td><?php echo $supplier->name; ?></td>
                                <td><?php echo $supplier->address; ?></td>
                                <td><?php echo $supplier->phone; ?></td>
                                <td><?php echo $supplier->email; ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/suppliers/edit/<?php echo $supplier->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form class="d-inline" action="<?php echo URLROOT; ?>/suppliers/delete/<?php echo $supplier->id; ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">Không có nhà cung cấp nào trong hệ thống.</p>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 