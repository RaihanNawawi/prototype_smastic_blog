<?php
include_once 'include/koneksi.php'; // Pastikan koneksi database tersedia

if (isset($_POST['keyword'])) {
    $keyword = $kon->real_escape_string($_POST['keyword']);

    // Function untuk mendapatkan sinonim dari Datamuse API
    function getSynonyms($keyword)
    {
        $api_url = "https://api.datamuse.com/words?rel_syn=" . urlencode($keyword);

        // Lakukan request ke API
        $response = file_get_contents($api_url);
        $synonyms = json_decode($response, true);

        // Periksa jika ada hasil dari API
        $relatedWords = [];
        if (!empty($synonyms)) {
            foreach ($synonyms as $word) {
                $relatedWords[] = $word['word'];  // Ambil kata sinonim
            }
        }
        return $relatedWords;
    }

    // Memperluas pencarian dengan sinonim dari API
    $relatedKeywords = [$keyword]; // Mulai dengan kata kunci asli
    $relatedKeywords = array_merge($relatedKeywords, getSynonyms($keyword)); // Tambahkan sinonim

    // Menggabungkan semua kata kunci menjadi satu string untuk pencarian SQL
    $searchTerms = implode(" | ", array_map(function ($term) use ($kon) {
        return $kon->real_escape_string($term);
    }, $relatedKeywords));

    // Full-Text Search menggunakan MySQL
    $joinQuery = "INNER JOIN categories ON posts.category_id = categories.id
                  INNER JOIN users ON posts.author_id = users.id_user";

    // Pencarian menggunakan Full-Text Index dan pencocokan keyword yang lebih cerdas
    $query = $kon->query("SELECT posts.*, categories.name AS category_name, users.username AS author_name
                          FROM posts $joinQuery
                          WHERE MATCH(posts.tittle, posts.content) AGAINST ('$searchTerms' IN NATURAL LANGUAGE MODE)
                          OR posts.tittle LIKE '%$keyword%'
                          OR posts.content LIKE '%$keyword%'
                          ORDER BY id_post DESC");

    // Cek hasil query
    if ($query->num_rows > 0) {
        while ($post = $query->fetch_assoc()) {
            // Tampilkan post
            echo "
            <div class='bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden'>
                <div class='relative group'>
                    <img src='assets/img/uploads/" . htmlspecialchars($post['images']) . "' alt='Blog Post Image' class='w-full h-64 object-cover transition-transform duration-300 ease-in-out transform group-hover:scale-105' />
                    <div class='absolute top-4 left-4 bg-black text-white text-xs font-semibold px-3 py-1 rounded-full'>
                        " . htmlspecialchars($post['category_name']) . "
                    </div>
                </div>
                <div class='p-6'>
                    <h3 class='text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors'>
                        <a href='?p=readpage&id=" . htmlspecialchars($post['id_post']) . "'>" . htmlspecialchars($post['tittle']) . "</a>
                    </h3>
                    <div class='text-gray-500 mt-2 mb-4'>
                        <span>By " . htmlspecialchars($post['author_name']) . "</span>
                        <span class='mx-2'>|</span>
                        <span>" . date('F d, Y', strtotime($post['created_at'])) . "</span>
                    </div>
                    <p class='text-gray-700 leading-relaxed line-clamp-3'>
                        " . substr($post['content'], 0, 120) . "... 
                    </p>
                    <a href='?p=readpage&id=" . htmlspecialchars($post['id_post']) . "' class='block mt-6 text-black font-semibold hover:underline flex items-center group'>
                        Read More 
                        <span class='ml-2 transition-transform transform group-hover:translate-x-1'>&rarr;</span>
                    </a>
                </div>
            </div>
            ";
        }

        echo "</div>";  // Close grid div
        echo "</div>";  // Close container div
        echo "</section>";  // Close section
    } else {
        // Pesan jika tidak ada post terkait kategori tersebut
        echo "<p class='text-lg font-semibold text-red-500 mb-8 text-center'>No articles found matching your search.</p>";
    }
}
?>

<style>
    /* Fade-in animation for search results */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Styling the card for better visuals */
    .card img {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .card p,
    .card h3 {
        margin-bottom: 0.5rem;
    }

    /* Typography and layout improvements */
    .card p.text-gray-500 {
        color: #6B7280;
        /* Tailwind color gray-500 */
        font-weight: 600;
    }

    .card h3 {
        font-size: 1.25rem;
        /* Larger font for titles */
    }

    .card .text-primary {
        color: #111;
        /* Tailwind color blue-600 */
        font-weight: 700;
    }
</style>