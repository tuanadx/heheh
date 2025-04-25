<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <h1>Quản lý danh mục</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/categories/add" class="btn btn-primary float-end">
            <i class="bi bi-plus-circle"></i> Thêm danh mục
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
        <h6 class="m-0 font-weight-bold text-primary">Danh Sách Danh Mục</h6>
    </div>
    <div class="card-body">
        <?php if(count($data['categories']) > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="25%">Tên danh mục</th>
                            <th width="45%">Mô tả</th>
                            <th width="20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['categories'] as $category) : ?>
                            <tr>
                                <td><?php echo $category->id; ?></td>
                                <td><?php echo $category->name; ?></td>
                                <td><?php echo $category->description; ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/categories/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form class="d-inline" action="<?php echo URLROOT; ?>/categories/delete/<?php echo $category->id; ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($data['categories'])) : ?>
                            <tr>
                                <td colspan="4" class="text-center">Không có danh mục nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">Không có danh mục nào trong hệ thống.</p>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 