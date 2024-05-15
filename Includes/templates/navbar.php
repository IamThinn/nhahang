<!-- START NAVBAR SECTION -->
<header id="header" class="header-section">
    <div class="container">
        <nav class="navbar">
            <a href="index.php" class="navbar-brand">
                <img src="Design/images/restaurant-logo.png" alt="Restaurant Logo" style="width: 150px;">
            </a>
            <div class="d-flex menu-wrap align-items-center">
                <div class="mainmenu" id="mainmenu">
                    <ul class="nav">
                        <li><a href="index.php#home">Trang chủ</a></li>
                        <li><a href="index.php#menus">Thực đơn</a></li>
                        <li><a href="index.php#gallery">Trưng bày</a></li>
                        <li><a href="index.php#about">Giới thiệu</a></li>
                        <li><a href="index.php#contact">Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Thêm đoạn mã sau vào vị trí bạn muốn hiển thị ô tìm kiếm -->
                <div class="header-btn">
                    <a href="table-reservation.php" target="_blank" class="menu-btn">Đặt bàn</a>
                    <!-- Thêm đoạn mã button tìm kiếm với icon -->
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="header-height" style="height: 120px;"></div>

<style>
    .header-btn {
        display: flex;
        align-items: center;
        justify-content: flex-end; /* Đưa nút "Đặt bàn" về phía bên phải */
    }

    button {
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #555;
    }
</style>

<!-- END NAVBAR SECTION -->
