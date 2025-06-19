<?php
require_once('app/models/AccountModel.php');
$accountModel = new AccountModel((new Database())->getConnection());
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng cầu lông</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Thêm icon cầu lông từ Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 100%) !important;
            box-shadow: 0 4px 16px rgba(60, 72, 88, 0.13);
            padding: 1.2rem 2.2rem;
            border-bottom-left-radius: 32px;
            border-bottom-right-radius: 32px;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 2rem;
            color: #fff !important;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .navbar-brand .bi-shuttlecock {
            font-size: 2.3rem;
            margin-right: 14px;
            color: #fbbf24;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.13));
            animation: shuttleAnim 1.2s infinite alternate;
        }
        @keyframes shuttleAnim {
            0% { transform: rotate(-10deg) scale(1);}
            100% { transform: rotate(10deg) scale(1.08);}
        }

        .nav-link {
            font-weight: 500;
            color: #f1f5f9 !important;
            margin: 0 12px;
            transition: color 0.3s, background 0.3s, box-shadow 0.3s;
            border-radius: 12px;
            padding: 10px 20px;
            position: relative;
        }

        .nav-link:hover, .nav-item.active .nav-link {
            color: #fff !important;
            background: linear-gradient(90deg, #818cf8 0%, #38bdf8 100%);
            box-shadow: 0 2px 12px rgba(56,189,248,0.12);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-icon {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 7px;
            border: 2.5px solid #38bdf8;
            background: #fff;
            box-shadow: 0 2px 8px rgba(56,189,248,0.10);
        }

        .user-info {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: #fff;
        }

        /* Hiệu ứng cho nút đăng xuất/đăng nhập */
        .nav-link[href*="logout"], .nav-link[href*="login"] {
            background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%);
            color: #fff !important;
            border-radius: 12px;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(251,191,36,0.10);
            font-weight: 600;
        }
        .nav-link[href*="logout"]:hover, .nav-link[href*="login"]:hover {
            background: linear-gradient(90deg, #f59e42 0%, #fbbf24 100%);
            color: #fff !important;
        }

        /* Thêm hiệu ứng underline cho nav-link khi hover */
        .nav-link::after {
            content: "";
            display: block;
            width: 0;
            height: 3px;
            background: #fbbf24;
            border-radius: 2px;
            transition: width 0.3s;
            position: absolute;
            left: 20px;
            bottom: 5px;
        }
        .nav-link:hover::after, .nav-item.active .nav-link::after {
            width: 60%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-shuttlecock"></i>Cầu Lông Việt
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/Product/">
                            <i class="fas fa-list mr-1"></i>Danh sách sản phẩm
                        </a>
                    </li>
                    <?php if (SessionHelper::isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Category">
                                <i class="fas fa-list mr-1"></i>Danh sách danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Account">
                                <i class="fas fa-list mr-1"></i>Danh sách người dùng
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="/Product/cart">
                            <i class="fas fa-shopping-cart mr-1"></i>Giỏ hàng
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <?php
                        if (SessionHelper::isLoggedIn()) {
                            $account = $accountModel->getAccountByUsername($_SESSION['username']);
                            echo "<a class='nav-link user-info' href='/account/edit'>";
                            if (!empty($account->image)) {
                                echo "<img src='/uploads/" . htmlspecialchars($account->image) . "' class='avatar-img' alt='Avatar'>";
                            } else {
                                echo "<img src='https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png?w=300&ssl=1' class='avatar-img' alt='Default Avatar'>";
                            }
                            if (SessionHelper::isAdmin()){
                                echo "<span>" . $_SESSION['username'] . " (" . SessionHelper::getRole() . ")</span>";
                            } else {
                                echo "<span>" . $_SESSION['username'] . "</span>";
                            }
                            echo "</a>";
                        } else {
                            echo  "<a class='nav-link'href='/account/login'>Đăng nhập</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (SessionHelper::isLoggedIn()) {
                            echo  "<a class='nav-link'href='/account/logout'>Đăng xuất</a>";
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>