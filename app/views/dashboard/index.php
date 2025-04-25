<?php require APPROOT . '/app/views/inc/header.php'; ?>

<h1 class="mb-4">Tổng Quan</h1>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng Thuốc</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['totalMedicines']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-capsule fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Danh Mục</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['totalCategories']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-grid fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nhà Cung Cấp</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['totalSuppliers']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sắp Hết Hàng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($data['lowStockMedicines']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Doanh Thu Theo Tháng</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thuốc Sắp Hết Hàng</h6>
            </div>
            <div class="card-body">
                <?php if(count($data['lowStockMedicines']) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tên Thuốc</th>
                                    <th>Danh Mục</th>
                                    <th>Số Lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['lowStockMedicines'] as $medicine) : ?>
                                    <tr>
                                        <td><?php echo $medicine->name; ?></td>
                                        <td><?php echo $medicine->category_name; ?></td>
                                        <td>
                                            <span class="badge bg-danger"><?php echo $medicine->quantity; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p>Không có thuốc nào sắp hết hàng.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Đơn Hàng Gần Đây</h6>
            </div>
            <div class="card-body">
                <?php if(count($data['recentSales']) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Thuốc</th>
                                    <th>Số Lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng Tiền</th>
                                    <th>Khách Hàng</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['recentSales'] as $sale) : ?>
                                    <tr>
                                        <td><?php echo $sale->medicine_name; ?></td>
                                        <td><?php echo $sale->quantity; ?></td>
                                        <td><?php echo number_format($sale->price, 0, ',', '.'); ?>₫</td>
                                        <td><?php echo number_format($sale->total_amount, 0, ',', '.'); ?>₫</td>
                                        <td><?php echo $sale->customer_name; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($sale->sale_date)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p>Không có đơn hàng gần đây.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Monthly Sales Chart
    document.addEventListener('DOMContentLoaded', function() {
        const monthlySalesData = <?php echo json_encode($data['monthlySales']); ?>;
        const months = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
        const salesByMonth = Array(12).fill(0);
        
        monthlySalesData.forEach(item => {
            salesByMonth[item.month - 1] = parseFloat(item.total);
        });
        
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doanh Thu (₫)',
                    data: salesByMonth,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            callback: function(value) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '₫';
                            }
                        },
                        grid: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>

<?php require APPROOT . '/app/views/inc/footer.php'; ?> 