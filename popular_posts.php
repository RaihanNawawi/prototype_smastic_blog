        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Popular Article Card Loop -->
            <?php
            // Use the same query or modify it for popular articles (Example logic: change ordering, limit, etc.)
            foreach ($query as $key) { // You can modify this query to pull popular posts specifically
            ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-lg">
                    <a href="?p=readpage&id=<?= $key['id_post'] ?>">
                        <div class="relative h-48">
                            <img src="assets/img/uploads/<?= $key['images'] ?>" alt="Article Image" class="object-cover w-full h-full" />
                        </div>
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-gray-500"><?= date('F d, Y', strtotime($key['created_at'])) ?></span>
                            <a href="main.php?p=categorypage&id=<?= $key['category_id'] ?>" class="px-2 py-1 bg-black text-white text-xs font-medium rounded-full">
                                <?= $key['category_name'] ?>
                            </a>
                        </div>
                        <a href="main.php?p=readpage&id=<?= $key['id_post'] ?>" class="text-xl font-semibold mb-2 line-clamp-2">
                            <?= $key['tittle'] ?>
                        </a>
                        <a href="main.php?p=readpage&id=<?= $key['id_post'] ?>" class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?= substr(strip_tags($key['content']), 0, 100) ?>...
                        </a>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium"><?= $key['author_id'] ?></span>
                            </div>
                            <span class="text-sm text-gray-500">5 min read</span>
                        </div>
                    </div>
                    </>
                </article>
            <?php } ?>
        </div>