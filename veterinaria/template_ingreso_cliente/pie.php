<footer class="custom-footer">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <h4 class="footer-title">
                                <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                            </h4>
                            <p style="color: var(--text-secondary); font-size: 0.9em;">
                                <i class="fas fa-map-pin me-2" style="color: var(--primary-color);"></i>
                                Veterinaria Animal Heart<br>
                                Carrera 15 # 20-30<br>
                                Tunja, Boyacá
                            </p>
                            <p style="color: var(--text-secondary); font-size: 0.9em;">
                                <i class="fas fa-phone me-2" style="color: var(--primary-color);"></i>
                                +57 311 204 8186
                            </p>
                            <p style="color: var(--text-secondary); font-size: 0.9em;">
                                <i class="fas fa-envelope me-2" style="color: var(--primary-color);"></i>
                                <a href="mailto:Animalheart.vet@gmail.com" class="footer-link">
                                    Animalheart.vet@gmail.com
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <h4 class="footer-title">
                                <i class="fas fa-map me-2"></i>Mapa
                            </h4>
                            <div class="map-container">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.288040175763!2d-73.36697308918588!3d5.524211433944903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e6a7df06b7ebee1%3A0xac0fea03a2e73c62!2sAnimal%20Heart!5e0!3m2!1ses!2sco!4v1690777041618!5m2!1ses!2sco"
                                    width="100%"
                                    height="150"
                                    style="border: 0;"
                                    allowfullscreen=""
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <h4 class="footer-title">
                                <i class="fas fa-share-alt me-2"></i>Redes Sociales
                            </h4>
                            <div class="social-links">
                                <a href="https://www.facebook.com/AnimalHeart.vet" target="_blank" class="footer-link">
                                    <i class="lni lni-facebook-fill"></i>
                                    <span class="d-none d-sm-inline">Facebook</span>
                                </a>
                                <a href="https://www.instagram.com/animalheart.vet/" target="_blank" class="footer-link">
                                    <i class="lni lni-instagram"></i>
                                    <span class="d-none d-sm-inline">Instagram</span>
                                </a>
                                <a href="https://api.whatsapp.com/message/ADEL5G52BMP4L1?autoload=1&app_absent=0" target="_blank" class="footer-link">
                                    <i class="lni lni-whatsapp"></i>
                                    <span class="d-none d-sm-inline">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-bottom">
                        <div class="row">
                            <div class="col-12 text-center">
                                <small>&copy; 2026 Veterinaria - Todos los derechos reservados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('#closeSidebar').on('click', function() {
                $('#sidebar').removeClass('active');
                $('#content').removeClass('active');
            });

            $(document).on('click', function(event) {
                if ($(window).width() <= 768) {
                    if (!$(event.target).closest('#sidebar').length &&
                        !$(event.target).closest('#sidebarCollapse').length &&
                        $('#sidebar').hasClass('active')) {
                        $('#sidebar').removeClass('active');
                        $('#content').removeClass('active');
                    }
                }
            });

            function setTheme(theme) {
                document.body.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);

                $('.theme-toggle span').removeClass('active');

                if (theme === 'dark') {
                    $('.theme-toggle .dark').addClass('active');
                } else {
                    $('.theme-toggle .light').addClass('active');
                }
            }

            const savedTheme = localStorage.getItem('theme') || 'dark';
            setTheme(savedTheme);

            $('.theme-toggle span').on('click', function() {
                const theme = $(this).hasClass('dark') ? 'dark' : 'light';
                setTheme(theme);
            });

            function adjustContentHeight() {
                var windowHeight = $(window).height();
                var navbarHeight = $('.custom-navbar').outerHeight();
                var footerHeight = $('.custom-footer').outerHeight();
                var contentHeight = windowHeight - navbarHeight - footerHeight;
                $('.container-main').css('min-height', contentHeight + 'px');
            }

            adjustContentHeight();
            $(window).on('resize', adjustContentHeight);
        });
    </script>
</body>

</html>