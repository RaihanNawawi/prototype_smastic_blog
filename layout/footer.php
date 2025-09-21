<!-- Footer -->
<footer class="bg-black text-white py-10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- School Information Section with Logo -->
            <div class="text-center md:text-left">
                <img src="img/ic1.png" alt="SMA Sains Tahfizh Logo" class="mx-auto md:mx-0 mb-4" style="max-width: 150px;">
                <h4 class="font-bold text-xl text-green-400">SMA Sains Tahfizh</h4>
                <p class="text-green-200">Islamic Center Siak</p>
                <p class="mt-4 text-gray-300 leading-relaxed">
                    School Address:<br>
                    Komplek Islamic Center Kampung Rempak<br>
                    Provinsi Kec. Siak, Kab. Siak - Riau, Indonesia
                </p>
            </div>
            <!-- Contact Details -->
            <div class="text-center md:text-left">
                <h4 class="font-bold text-lg mb-5">Contact Us</h4>
                <ul class="text-gray-300 space-y-4">
                    <li class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-phone-alt mr-2 text-green-400"></i>
                        <span>Phone: (0764) 3249465</span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-envelope mr-2 text-green-400"></i>
                        <span>Email: <a href="mailto:smastics@gmail.com" class="hover:text-white">smastics@gmail.com</a></span>
                    </li>
                    <li class="flex items-center justify-center md:justify-start">
                        <i class="fas fa-globe mr-2 text-green-400"></i>
                        <span>Website: <a href="http://www.smastic.sch.id" class="hover:text-white">www.smastic.sch.id</a></span>
                    </li>
                </ul>
                <h4 class="font-bold text-lg mt-8 mb-4">Stay Connected</h4>
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-start space-y-4 md:space-y-0 md:space-x-4 mb-2">
                    <a href="https://www.facebook.com/share/g4kocCusPFdRtJ8U/" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f text-lg"></i>
                        <span class="text-sm md:text-base">Facebook</span>
                    </a>
                    <a href="https://youtube.com/@smasticofficial?si=GoqizrA1K9zlRhvP" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                        <i class="fab fa-youtube text-lg"></i>
                        <span class="text-sm md:text-base">YouTube</span>
                    </a>
                    <a href="https://www.instagram.com/smasticsofficial?igsh=MWJ1bnlodzNtdWZ6cQ==" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                        <i class="fab fa-instagram text-lg"></i>
                        <span class="text-sm md:text-base">Instagram</span>
                    </a>
                </div>
            </div>
            <!-- Blog and Social Media Section -->
            <div class="text-center md:text-left">
                <h4 class="font-bold text-lg mb-4">Explore Our Blog</h4>
                <ul class="text-gray-300 space-y-4">
                    <?php
                    $query = $kon->query("SELECT * FROM categories ORDER BY id DESC");
                    foreach ($query as $key) { ?>
                        <li><a href="main.php?p=categorypage&id=<?= $key['id'] ?>" class="hover:text-white"><?= $key['name'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- Map Section  -->
        <div class="mt-8">
            <div class="rounded-lg overflow-hidden shadow-lg">
                <iframe class="w-full h-64"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4134134496894!2d102.02761527407107!3d0.816285963060398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d420d42727d795%3A0x643a20ddb060fc0b!2sSMA%20SAINS%20TAHFIZH%20ISLAMIC%20CENTER%20SIAK!5e0!3m2!1sms!2sid!4v1740654725694!5m2!1sms!2sid"
                    allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
        <!-- Footer Bottom Text -->
        <div class="mt-10 text-center text-sm text-gray-500">
            <p>&copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
                SMA Sains Tahfizh. All rights reserved.
            </p>
        </div>
    </div>
</footer>