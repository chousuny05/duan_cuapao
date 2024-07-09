<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <title>Document</title>
    <style>
        canvas {
            width: 500px;
            height: 200px;
            border: 1px solid #000;
        }
     .form_contact {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .footer-container {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        
    </style>
</head>

<body>
    <div id="main">
        <div id="header">
            <!-- begin nav -->
            <ul id="nav">
                <img src="" alt="logo">
                <li>
                    <a href="index.php">Home
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li>
                    <a href="index.php?act=adddm">
                        Danh mục
                    </a>
                </li>
                <li> <a href="index.php?act=addsp">
                        Hàng hóa
                        <i class="fa-solid fa-caret-down"></i>
                    </a>
                    <ul class="subnav">
                        <li><a href="">food</a></li>
                        <li><a href="">drinks</a></li>
                        <li><a href="">
                                otheritems</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.php?act=dskh">
                        Khách hàng
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>
                <li>
                    <a href="index.php?act=dsbl">
                       Bình luận
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>
                <li> <a href="index.php?act=thongke">
                        Thống kê
                        <i class="fa-solid fa-caret-down"></i>
                    </a>
                    <ul class="subnav">
                        <li><a href="">contactus</a></li>
                        <li><a href="">feedback</a></li>
                        <li><a href="">sale</a></li>
                    </ul>
                </li>
            </ul>  
               <!-- end nav -->
                <!-- begin search nav -->
                <!-- button search nav -->
                <!-- <div class="search-btn">
                    <input type="text" placeholder="Search here.....">
                    <button type="submit">Search</button>
                    <button><a href="dangnhap.html">Login</a> </button>
                </div>     -->
        </div>
        <div id="slide" class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://donchicken.vn/pub/media/wysiwyg/HBT.jpg" alt=""
                        style="width:1500px; height: 700px;">
                </div>
                <div class="swiper-slide">
                    <img src="https://donchicken.vn/pub/media/wysiwyg/HBT.jpg" alt=""
                        style="width:1500px; height: 700px;">
                </div>
                <div class="swiper-slide">
                    <img src="https://donchicken.vn/pub/media/wysiwyg/HBT.jpg" alt=""
                        style="width:1500px; height: 700px;">
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>