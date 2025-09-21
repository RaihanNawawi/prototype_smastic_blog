    <!-- Slider -->
    <section class="mb-16 relative overflow-hidden rounded-lg" id="slider-wrapper">
        <div id="slider">
            <!-- Slide PHP Loop -->
            <?php
            $a = "INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.author_id = users.id_user";
            $query = $kon->query("SELECT posts.*, categories.name AS category_name, users.username AS author_id FROM posts $a ORDER BY id_post DESC LIMIT 4");
            foreach ($query as $key) {
            ?>
                <div class="slide">
                    <div class="relative h-[400px]">
                        <img src="assets/img/uploads/<?= $key['images'] ?>" alt="Featured Post" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 p-6 text white text-container">
                            <a href="?p=categorypage&id=<?= $key['category_id'] ?>" class="bg-white text-black py-1 px-3 rounded"><?= $key['category_name'] ?></a>
                            <a href="?p=readpage&id=<?= $key['id_post'] ?>" class="text-3xl font-bold mb-2 text-white"><?= $key['tittle'] ?></a>
                            <p class="mb-4 mt-2 text-white"><?= $key['author_id'] ?> • <?= date('F d, Y', strtotime($key['created_at'])) ?></p>
                            <a href="?p=readpage&id=<?= $key['id_post'] ?>" class="text-white border-white hover:bg-white hover:text-black border px-4 py-2">Read More</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Pagination Dots -->
        <div class="pagination" id="pagination-dots"></div>
    </section>
    <style>
        /* Slider Styles */
        #slider-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            cursor: pointer;
        }

        #slider {
            display: flex;
            transition: transform 1s ease-in-out;
        }

        .slide {
            min-width: 100%;
            position: relative;
        }

        .slide img {
            transition: none;
        }

        /* Pagination Dots */
        .pagination {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: white;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .dot.active {
            opacity: 1;
        }

        /* Dark theme for text */
        .dark-theme .text {
            color: white;
        }

        /* Light theme for text */
        .light-theme .text {
            color: black;
        }

        .dark-theme a {
            background-color: white;
            color: black;
        }

        .light-theme a {
            background-color: black;
            color: white;
        }
    </style>
    <script>
        // Slider element
        const slider = document.getElementById('slider');
        const slides = document.querySelectorAll('.slide');
        const pagination = document.getElementById('pagination-dots');
        let currentSlide = 0;
        const totalSlides = slides.length;

        // Create dots based on the number of slides
        slides.forEach((slide, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active'); // Active first dot
            pagination.appendChild(dot);
        });

        const dots = document.querySelectorAll('.dot');

        // Function to detect contrast
        function getContrastYIQ(hexcolor) {
            hexcolor = hexcolor.replace("#", "");
            const r = parseInt(hexcolor.substr(0, 2), 16);
            const g = parseInt(hexcolor.substr(2, 2), 16);
            const b = parseInt(hexcolor.substr(4, 2), 16);
            const yiq = (r * 299 + g * 587 + b * 114) / 1000;
            return yiq >= 128 ? 'dark' : 'light';
        }

        // Apply contrast detection to each slide
        slides.forEach(slide => {
            const img = slide.querySelector('img');

            // Create a temporary image to detect contrast
            const tempImage = new Image();
            tempImage.src = img.src;
            tempImage.onload = function() {
                const colorThief = new ColorThief();
                const dominantColor = colorThief.getColor(tempImage);
                const dominantHex = rgbToHex(dominantColor[0], dominantColor[1], dominantColor[2]);
                const contrast = getContrastYIQ(dominantHex);
                const textContainer = slide.querySelector('.text-container');
                if (contrast === 'dark') {
                    textContainer.classList.add('dark-theme');
                } else {
                    textContainer.classList.add('light-theme');
                }
            };
        });

        // Utility function to convert RGB to HEX
        function rgbToHex(r, g, b) {
            return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        // Function to show the current slide
        function showSlide(index) {
            slider.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach(dot => dot.classList.remove('active'));
            dots[index].classList.add('active');
        }

        // Function to go to the next slide
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        // Function to go to the previous slide
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        // Auto slide functionality
        setInterval(nextSlide, 5000); // Adjust time interval for smoother transition

        // Handle dot clicks
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Handle click on the edges for next/previous slide
        document.getElementById('slider-wrapper').addEventListener('click', (event) => {
            // Menghitung posisi X klik relatif terhadap slider-wrapper
            const clickX = event.clientX;
            const sliderLeft = slider.getBoundingClientRect().left;
            const middleX = sliderLeft + slider.offsetWidth / 2; // Titik tengah slider

            // Jika klik di sisi kanan, geser ke slide berikutnya, jika di kiri, geser ke slide sebelumnya
            if (clickX > middleX) {
                nextSlide();
            } else {
                prevSlide();
            }
        });
    </script>
    <!-- Include ColorThief Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>