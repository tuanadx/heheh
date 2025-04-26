<?php
require_once 'config/config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';

$app = new App(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MVC App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">
                            <i class="bi bi-clock-history"></i> Lịch sử
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear-fill"></i> Công cụ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="backup.php"><i class="bi bi-download"></i> Sao lưu dữ liệu</a></li>
                            <li><a class="dropdown-item" href="restore.php"><i class="bi bi-upload"></i> Phục hồi dữ liệu</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="benchmark.php"><i class="bi bi-speedometer"></i> Benchmark hiệu suất</a></li>
                            <li><a class="dropdown-item" href="edit_json.php"><i class="bi bi-pencil-square"></i> Cập nhật hàng loạt</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Main content will be loaded here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 