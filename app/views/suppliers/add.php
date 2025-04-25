<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mb-4">
    <a href="<?php echo URLROOT; ?>/suppliers" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm Nhà Cung Cấp Mới</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo URLROOT; ?>/suppliers/add" method="post">
            <div class="form-group mb-3">
                <label for="name">Tên nhà cung cấp: <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ:</label>
                <input type="text" name="address" class="form-control <?php echo (!empty($data['address_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['address']; ?>">
                <span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="phone">Số điện thoại: <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['phone']; ?>">
                <span class="invalid-feedback"><?php echo $data['phone_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm Nhà Cung Cấp</button>
                <a href="<?php echo URLROOT; ?>/suppliers" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 