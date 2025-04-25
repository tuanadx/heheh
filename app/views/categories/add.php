<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-4">
    <a href="<?php echo URLROOT; ?>/categories" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm Danh Mục Mới</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo URLROOT; ?>/categories/add" method="post">
            <div class="form-group mb-3">
                <label for="name">Tên danh mục: <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="description">Mô tả:</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $data['description']; ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
                <a href="<?php echo URLROOT; ?>/categories" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 