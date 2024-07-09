 <!-- footer am here -->
 
        <footer>
            <div class="footer-container">
                <div class="footer-section about">
                    <h4>ABOUT PAO</h4>
                    <p>Chúng tôi là công ty cung cấp dịch vụ áo polo tốt nhất.</p>
                    <svg id="svgelem" height="100px">
                        <circle id="redcircle" cx="20" cy="20" r="20" fill="red" />
                    </svg>
                </div>
                <div class="footer-section links">
                    <h4>USEFUL LINKS</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-section social-media">
                    <h4>FOLLOW PAO</h4>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
               
            </div>
            <div class="footer-bottom">
                &copy; 2024 YourCompany. All rights reserved. 
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="index.js"></script>
    <script src="https://kit.fontawesome.com/e5e78b1ae2.js" crossorigin="anonymous"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 4000,
            },
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });
    </script>
    
    

</body>

</html>