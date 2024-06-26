 // Khởi tạo Swiper
 const swiper = new Swiper('.swiper', {
    // Các tham số tùy chọn
    direction: 'horizontal', // Hướng chuyển động ngang
    loop: true, // Lặp lại các slide
    autoplay: { // Tự động chuyển slide
        delay: 3000, // Thời gian chờ giữa các slide (5 giây)
    },
    // Cấu hình phân trang
    pagination: {
        el: '.swiper-pagination', // Chọn phần tử phân trang
    },
    // Cấu hình các nút điều hướng
    navigation: {
        nextEl: '.swiper-button-next', // Nút chuyển tới slide sau
        prevEl: '.swiper-button-prev', // Nút quay lại slide trước
    },
    // Nếu cần thanh cuộn
    scrollbar: {
        el: '.swiper-scrollbar', // Chọn phần tử thanh cuộn
    },
});