<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="contact.css">
    <title>CONTACT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <div id="header">
                <nav>
                    <ul id="nav">
                        <li>
                            <img src="" alt="logo" class="nav-logo">
                        </li>
                        <li>
                            <a href="index.php">Home
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li>
                            <a href="product.php">Product</a>
                        </li>
                        <li>
                            <a href="">
                                Menu
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="subnav">
                                <li><a href="">Shoes</a></li>
                                <li><a href="">Span</a></li>
                                <li><a href="">Shirt</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="cart.php">
                                CART
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li>
                            <a href="contact.php">
                                Contact
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                More
                                <i class="fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="subnav">
                                <li><a href="">Hot</a></li>
                                <li><a href="">New</a></li>
                                <li><a href="">Sale</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="search-btn">
                        <input type="text" placeholder="Search here.....">
                        <button class="header" type="submit">Search</button>
                        <button class="header"><a href="dangnhap.html">Login</a></button>
                        <button class="header"><a href="dangnhap.html">Logout</a></button>
                    </div>
                </nav>
            </div>
            <div class="baner">
                <img src="https://noithattugia.com/wp-content/uploads/Tong-the-khong-gian-thiet-ke-rong-rai-thoang-rong-voi-mau-sac-tinh-te-an-tuong-1067x800.jpg" alt="" style="width: 100%; height: 500px;">
            </div>
        </header>
    </div>
    <main>
        <div class="container mt-5">
            <h1>Chào mừng đến với Pao Shop</h1>
            <h2>Liên hệ với chúng tôi</h2>
            <form id="contactForm" action="submit_contact.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Chủ đề</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Tin nhắn</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi</button>
            </form>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>Pao</h2>
                <p>Cửa hàng thời trang của bạn với những xu hướng mới nhất. Tại Pao, chúng tôi cung cấp đa dạng các loại trang phục phù hợp với mọi phong cách và dịp.</p>
                <div class="socials">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h2>Liên kết nhanh</h2>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Liên hệ</h2>
                <ul>
                    <li><i class="fa fa-map-marker"></i> 123 Đường ABC, Quận 1, TP. HCM</li>
                    <li><i class="fa fa-phone"></i> +84 123 456 789</li>
                    <li><i class="fa fa-envelope"></i> support@pao.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Pao. All rights reserved.
        </div>
    </footer>
</body>

</html>
