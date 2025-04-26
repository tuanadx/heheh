<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh Sách Thuốc</h1>
    <a href="<?php echo URLROOT; ?>/medicines/add" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Thuốc Mới
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản Lý Thuốc</h6>
    </div>
    <div class="card-body">
        <?php if(count($data['medicines']) > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="medicinesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên Thuốc</th>
                            <th>Danh Mục</th>
                            <th>Nhà Cung Cấp</th>
                            <th>Giá Bán</th>
                            <th>Số Lượng</th>
                            <th>Hạn Sử Dụng</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['medicines'] as $medicine) : ?>
                            <tr>
                                <td><?php echo $medicine->name; ?></td>
                                <td><?php echo $medicine->category_name; ?></td>
                                <td><?php echo $medicine->supplier_name; ?></td>
                                <td><?php echo number_format($medicine->price, 0, ',', '.'); ?>₫</td>
                                <td>
                                    <?php if($medicine->quantity < 10) : ?>
                                        <span class="badge bg-danger"><?php echo $medicine->quantity; ?></span>
                                    <?php else : ?>
                                        <?php echo $medicine->quantity; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($medicine->expiry_date)); ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/medicines/edit/<?php echo $medicine->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form class="d-inline" action="<?php echo URLROOT; ?>/medicines/delete/<?php echo $medicine->id; ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa thuốc này?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php echo $data['pagination']->render(); ?>
            
            <div class="text-center mt-3">
                <p class="text-muted">
                    Hiển thị <?php echo count($data['medicines']); ?> thuốc trên tổng số <?php echo $data['pagination']->getTotalItems(); ?> thuốc
                    (Trang <?php echo $data['pagination']->getCurrentPage(); ?> / <?php echo $data['pagination']->getTotalPages(); ?>)
                </p>
            </div>
        <?php else : ?>
            <p>Không có thuốc nào trong hệ thống.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable - removed pagination since we're using our own
        $('#medicinesTable').DataTable({
            responsive: true,
            paging: false, // Disable DataTable pagination
            language: {
                search: "Tìm kiếm:",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Hiển thị 0 đến 0 của 0 mục",
                emptyTable: "Không có dữ liệu",
                zeroRecords: "Không tìm thấy kết quả phù hợp"
            }
        });
    });
</script>

<?php require APPROOT . '/app/views/inc/footer.php'; ?> 