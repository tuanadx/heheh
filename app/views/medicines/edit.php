<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="mb-4">
    <a href="<?php echo URLROOT; ?>/medicines" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay Lại Danh Sách
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Chỉnh Sửa Thuốc</h6>
    </div>
    <div class="card-body">
        <form action="<?php echo URLROOT; ?>/medicines/edit/<?php echo $data['id']; ?>" method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Tên Thuốc: <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id">Danh Mục: <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control <?php echo (!empty($data['category_id_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Chọn Danh Mục</option>
                            <?php foreach($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id; ?>" <?php echo ($data['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo $category->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['category_id_err']; ?></span>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier_id">Nhà Cung Cấp: <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-control <?php echo (!empty($data['supplier_id_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Chọn Nhà Cung Cấp</option>
                            <?php foreach($data['suppliers'] as $supplier) : ?>
                                <option value="<?php echo $supplier->id; ?>" <?php echo ($data['supplier_id'] == $supplier->id) ? 'selected' : ''; ?>>
                                    <?php echo $supplier->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['supplier_id_err']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Giá Bán: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₫</span>
                            </div>
                            <input type="text" name="price" class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['price']; ?>">
                            <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity">Số Lượng: <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control <?php echo (!empty($data['quantity_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['quantity']; ?>">
                        <span class="invalid-feedback"><?php echo $data['quantity_err']; ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="expiry_date">Hạn Sử Dụng: <span class="text-danger">*</span></label>
                        <input type="date" name="expiry_date" class="form-control <?php echo (!empty($data['expiry_date_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['expiry_date']; ?>">
                        <span class="invalid-feedback"><?php echo $data['expiry_date_err']; ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô Tả:</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $data['description']; ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?> 