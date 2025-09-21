  <main class="container mx-auto p-5 max-w-screen-lg bg-white rounded-md shadow-sm">
      <!-- Blog Post Article -->
      <article class="mb-10">
          <?php
            if (isset($_GET['id'])) {
                $id_post = $_GET['id'];

                $a = "INNER JOIN categories ON posts.category_id = categories.id
                  INNER JOIN users ON posts.author_id = users.id_user";

                $query = $kon->query("SELECT posts.*, categories.name AS category_name,
            users.username AS author_name FROM posts $a WHERE posts.id_post = '$id_post'");

                if ($query->num_rows > 0) {
                    $key = $query->fetch_assoc();
                    // Query to fetch tags related to the post
                    $tagQuery = $kon->query("SELECT tags.name AS tag_name
                FROM post_tags
                INNER JOIN tags ON post_tags.id_tag = tags.id
                WHERE post_tags.id_posts = '$id_post'");

                    // Collecting tags
                    $tags = [];
                    if ($tagQuery->num_rows > 0) {
                        while ($tag = $tagQuery->fetch_assoc()) {
                            $tags[] = $tag['tag_name'];
                        }
                    }
            ?>
                  <!-- Title -->
                  <h2 class="text-3xl font-bold mb-4 text-gray-800 text-center">
                      <?= htmlspecialchars($key['tittle']); ?>
                  </h2>

                  <!-- Meta Information -->
                  <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6 justify-center space-x-4">
                      <div class="flex items-center space-x-2">
                          <a href="?p=categorypage&id=<?= $key['category_id']; ?>" class="text-gray-800"><?= htmlspecialchars($key['category_name']); ?></a>
                          <span>•</span>
                          <span><?= date('F d, Y', strtotime($key['created_at'])) ?></span>
                          <span>•</span>
                          <span>5 min read</span>
                      </div>
                  </div>


                  <!-- Featured Image -->
                  <div class="mb-6">
                      <img src="assets/img/uploads/<?= $key['images'] ?>"
                          alt="Featured Image"
                          class="w-full h-auto object-cover max-h-96 rounded-lg shadow-md">
                  </div>

                  <!-- Blog Content -->
                  <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-6">
                      <?= htmlspecialchars_decode($key['content']); ?>
                  </div>

                  <!-- Tags -->
                  <div class="flex flex-wrap gap-2 mt-4">
                      <?php
                        // Display tags as clickable badges
                        if (!empty($tags)) {
                            foreach ($tags as $tag) {
                                echo "<a href='?p=tagspage&tag=" . urlencode($tag) . "' class='inline-block bg-indigo-100 text-indigo-600 text-sm font-semibold px-3 py-1 rounded-full hover:bg-indigo-200 transition'>#$tag</a>";
                            }
                        } else {
                            echo "<span class='text-gray-500 text-sm'>No Tags</span>";
                        }
                        ?>
                  </div>

              <?php
                } else {
                ?>
                  <!-- Error Message -->
                  <p class="text-lg font-semibold text-red-500 mb-4 text-center">
                      Blog not found or has been deleted.
                  </p>
          <?php
                }
            }
            ?>
          <!-- Interaction Section -->
          <?php
            // Mendapatkan data berdasarkan id_post
            $id_post = $_GET['id'];  // id_post dari request 

            // Query untuk mendapatkan jumlah like, dislike, dan save dari tabel interactions
            $query = "
        SELECT
        COUNT(CASE WHEN interaction_type = 'like' THEN 1 END) AS likes,
        COUNT(CASE WHEN interaction_type = 'dislike' THEN 1 END) AS dislikes,
        COUNT(CASE WHEN interaction_type = 'save' THEN 1 END) AS saves
        FROM interactions
        WHERE post_id = ?";

            // Mempersiapkan statement
            $stmt = mysqli_prepare($kon, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_post);  // Bind parameter 'i' untuk integer
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $likes, $dislikes, $saves);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            // Jika tidak ada hasil, set default nilai
            if (!$likes) $likes = 0;
            if (!$dislikes) $dislikes = 0;
            if (!$saves) $saves = 0;

            ?>
          <div class="max-w-full mx-auto mt-8 border-t pt-8">
              <div class="flex justify-between mb-8">
                  <div class="flex space-x-4">
                      <!-- Like Button -->
                      <button id="like-btn" class="interaction-btn border px-4 py-2 rounded-md flex items-center transition-all duration-300 ease-in-out hover:bg-gray-100" data-post-id="<?= $id_post; ?>">
                          <i class="fas fa-thumbs-up mr-2"></i> <span id="like-count"><?= $likes; ?></span>
                      </button>
                      <!-- Dislike Button -->
                      <button id="dislike-btn" class="interaction-btn border px-4 py-2 rounded-md flex items-center transition-all duration-300 ease-in-out hover:bg-gray-100" data-post-id="<?= $id_post; ?>">
                          <i class="fas fa-thumbs-down mr-2"></i> <span id="dislike-count"><?= $dislikes; ?></span>
                      </button>
                  </div>
                  <div class="flex space-x-4">
                      <!-- Save Button -->
                      <button id="save-btn" class="interaction-btn border px-4 py-2 rounded-md flex items-center transition-all duration-300 ease-in-out hover:bg-gray-100" data-post-id="<?= $id_post; ?>">
                          <i class="fas fa-bookmark mr-2"></i><span id="save-count"><?= $saves; ?></span>
                      </button>
                  </div>
              </div>
          </div>





          <script>
              function toggleOptions(button) {
                  const menu = button.nextElementSibling;
                  menu.classList.toggle("hidden");
              }
          </script>
          <!-- End of comments section Contoh -->


          <?php
            session_start();
            include "include/koneksi.php";

            // Ambil user_id dari sesi
            $current_user_id = $_SESSION['id_user'];
            ?>
          <!-- Comments Section -->
          <div class="">
              <h3 class="text-xl font-semibold mb-4">Comments</h3>
              <form class="mb-6" id="comment-form">
                  <textarea name="comment_text" id="comment_text" class="w-full border border-gray-300 p-3 rounded-md mb-4 placeholder-gray-400 text-black" placeholder="Leave a comment..."></textarea>
                  <input type="hidden" name="post_id" id="post_id" value="<?= $id_post; ?>">
                  <div class="flex justify-end">
                      <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Post Comment</button>
                  </div>
              </form>

              <!-- Display Comments -->
              <div class="space-y-6" id="comments-section">
                  <?php
                    $sql = "SELECT c.id, c.comment, c.created_at, c.user_id, u.username
                FROM comments c
                JOIN users u ON c.user_id = u.id_user
                WHERE c.post_id = '$id_post'
                ORDER BY c.created_at DESC";
                    $result = $kon->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                          <div class="flex space-x-4" id="comment-<?= $row['id'] ?>">
                              <img src="https://t3.ftcdn.net/jpg/05/87/76/66/360_F_587766653_PkBNyGx7mQh9l1XXPtCAq1lBgOsLl6xH.jpg" alt="User Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-dark">
                              <div class="flex-1">
                                  <div class="flex justify-between items-center">
                                      <div>
                                          <p class="font-semibold text-black"><?= htmlspecialchars($row['username']) ?></p>
                                          <p class="text-sm text-gray-500"><?= date("F j, Y", strtotime($row['created_at'])) ?></p>
                                      </div>
                                      <?php if ($row['user_id'] == $current_user_id) { ?>
                                          <div class="relative">
                                              <button class="text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleOptions(this)">
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </button>
                                              <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden">
                                                  <button onclick="enableEdit(<?= $row['id'] ?>)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                      <i class="fas fa-edit mr-2"></i>Edit
                                                  </button>
                                                  <button onclick="showDeletePopup(<?= $row['id'] ?>)" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 w-full text-left">
                                                      <i class="fas fa-trash-alt mr-2"></i>Delete
                                                  </button>
                                              </div>
                                          </div>
                                      <?php } ?>
                                  </div>
                                  <p id="comment-text-<?= $row['id'] ?>" class="mt-2 text-gray-900 leading-relaxed"> <?= nl2br(htmlspecialchars($row['comment'])) ?> </p>
                                  <!-- Input Edit -->
                                  <textarea id="edit-comment-<?= $row['id'] ?>" class="hidden w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:outline-none mt-2"><?= htmlspecialchars($row['comment']) ?></textarea>

                                  <!-- Tombol Simpan & Batal -->
                                  <div id="edit-buttons-<?= $row['id'] ?>" class="flex justify-end hidden flex items-center space-x-2 mt-2">
                                      <button onclick="cancelEdit(<?= $row['id'] ?>)" class="px-4 py-1 bg-gray-300 text-black rounded-md text-sm hover:bg-gray-400">Cancel</button>
                                      <button onclick="saveComment(<?= $row['id'] ?>)" class="px-4 py-1 bg-black text-white rounded-md text-sm hover:bg-gray-700">Save Change</button>
                                  </div>
                              </div>
                          </div>
                  <?php
                        }
                    } else {
                        echo "<p class='text-gray-500 text-center italic'>Jadilah yang pertama memberikan komentar!</p>";
                    }
                    ?>
              </div>
          </div>

          <!-- Pop-Up Konfirmasi Hapus -->
          <div id="delete-popup" class="fixed inset-0 flex justify-center items-center hidden z-10">
              <!-- Background Blur -->
              <div class="absolute inset-0 backdrop-blur-md bg-gray-900/20"></div>
              <!-- Konten Pop-Up -->
              <div class="relative bg-white p-6 rounded-lg shadow-xl w-80 text-center">
                  <button onclick="closeDeletePopup()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                      <i class="fas fa-times"></i>
                  </button>
                  <div class="mb-4">
                      <i class="fas fa-exclamation-triangle text-red-500 text-4xl"></i>
                  </div>
                  <h2 class="text-lg font-semibold text-gray-800">Delete Comment?</h2>
                  <p class="text-gray-600 mt-2 text-sm">This Action Cannot be Canceled.</p>
                  <div class="flex justify-center mt-4 space-x-4">
                      <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 shadow-md">Delete</button>
                      <button onclick="closeDeletePopup()" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400 shadow-md">Cancel</button>
                  </div>
              </div>
          </div>
          <!-- End of Comments Section -->

          <script>
              // JavaScript untuk mengelola tombol like, dislike dan save
              document.addEventListener('DOMContentLoaded', async function() {
                  const likeBtn = document.getElementById('like-btn');
                  const dislikeBtn = document.getElementById('dislike-btn');
                  const saveBtn = document.getElementById('save-btn');
                  const postId = likeBtn.getAttribute('data-post-id');

                  function updateCount(type, count) {
                      document.getElementById(`${type}-count`).innerText = count;
                  }

                  function toggleActive(button, isActive) {
                      if (isActive) {
                          button.classList.add('bg-black', 'text-white');
                      } else {
                          button.classList.remove('bg-black', 'text-white');
                      }
                  }

                  async function sendRequest(interactionType) {
                      try {
                          const response = await fetch('interaction_handler.php', {
                              method: 'POST',
                              headers: {
                                  'Content-Type': 'application/x-www-form-urlencoded',
                              },
                              body: `post_id=${postId}&interaction_type=${interactionType}`,
                          });

                          const data = await response.json();

                          if (data.status === 'success') {
                              return data; // Return data jumlah like, dislike, save, dan userActions
                          } else {
                              alert(data.message); // Error handling lebih baik
                              return null;
                          }
                      } catch (error) {
                          console.error('Error:', error);
                          return null;
                      }
                  }

                  likeBtn.addEventListener('click', async function() {
                      const data = await sendRequest('like');
                      if (data) {
                          toggleActive(likeBtn, true);
                          toggleActive(dislikeBtn, false);
                          updateCount('like', data.likes);
                          updateCount('dislike', data.dislikes);
                      }
                  });

                  dislikeBtn.addEventListener('click', async function() {
                      const data = await sendRequest('dislike');
                      if (data) {
                          toggleActive(dislikeBtn, true);
                          toggleActive(likeBtn, false);
                          updateCount('like', data.likes);
                          updateCount('dislike', data.dislikes);
                      }
                  });

                  saveBtn.addEventListener('click', async function() {
                      const data = await sendRequest('save');
                      if (data) {
                          toggleActive(saveBtn, saveBtn.classList.contains('bg-black') ? false : true);
                          updateCount('save', data.saves);
                      }
                  });

                  async function checkUserActions() {
                      const data = await sendRequest('check');
                      if (data && data.userActions) {
                          toggleActive(likeBtn, data.userActions.includes('like'));
                          toggleActive(dislikeBtn, data.userActions.includes('dislike'));
                          toggleActive(saveBtn, data.userActions.includes('save'));
                      }
                  }

                  checkUserActions();
              });

              // JavaScript untuk mengelola komentar
              function toggleOptions(button) {
                  const options = button.nextElementSibling;
                  options.classList.toggle('hidden');
                  document.addEventListener('click', function(event) {
                      if (!button.contains(event.target) && !options.contains(event.target)) {
                          options.classList.add('hidden');
                      }
                  });
              }

              function enableEdit(commentId) {
                  document.getElementById(`comment-text-${commentId}`).classList.add("hidden");
                  document.getElementById(`edit-comment-${commentId}`).classList.remove("hidden");
                  document.getElementById(`edit-buttons-${commentId}`).classList.remove("hidden");
                  document.getElementById(`edit-comment-${commentId}`).focus();
              }

              function cancelEdit(commentId) {
                  document.getElementById(`comment-text-${commentId}`).classList.remove("hidden");
                  document.getElementById(`edit-comment-${commentId}`).classList.add("hidden");
                  document.getElementById(`edit-buttons-${commentId}`).classList.add("hidden");
              }

              function showDeletePopup(commentId) {
                  document.getElementById("delete-popup").classList.remove("hidden");
                  document.getElementById("delete-popup").setAttribute("data-comment-id", commentId);
              }

              function closeDeletePopup() {
                  document.getElementById("delete-popup").classList.add("hidden");
              }

              function confirmDelete() {
                  const commentId = document.getElementById("delete-popup").getAttribute("data-comment-id");

                  const formData = new FormData();
                  formData.append('comment_id', commentId);

                  fetch('delete_comment.php', {
                          method: 'POST',
                          body: formData
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.status === 'success') {
                              document.getElementById(`comment-${commentId}`).remove();
                              closeDeletePopup();
                          } else {
                              alert(data.message);
                          }
                      })
                      .catch(error => console.error('Error:', error));
              }

              function saveComment(commentId) {
                  const commentText = document.getElementById(`edit-comment-${commentId}`).value;

                  const formData = new FormData();
                  formData.append('comment_id', commentId);
                  formData.append('comment_text', commentText);

                  fetch('edit_comment.php', {
                          method: 'POST',
                          body: formData
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.status === 'success') {
                              document.getElementById(`comment-text-${commentId}`).innerHTML = data.comment;
                              cancelEdit(commentId);
                          } else {
                              alert(data.message);
                          }
                      })
                      .catch(error => console.error('Error:', error));
              }

              document.getElementById('comment-form').addEventListener('submit', function(e) {
                  e.preventDefault();

                  const commentText = document.getElementById('comment_text').value;
                  const postId = document.getElementById('post_id').value;

                  if (commentText.trim() === '') {
                      alert('Comment text is empty');
                      return;
                  }

                  const formData = new FormData();
                  formData.append('comment_text', commentText);
                  formData.append('post_id', postId);

                  fetch('process_comment.php', {
                          method: 'POST',
                          body: formData
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.status === 'success') {
                              const commentsSection = document.getElementById('comments-section');
                              const newComment = document.createElement('div');
                              newComment.classList.add('flex', 'space-x-4');
                              newComment.innerHTML = `
                <img src="https://t3.ftcdn.net/jpg/05/87/76/66/360_F_587766653_PkBNyGx7mQh9l1XXPtCAq1lBgOsLl6xH.jpg" alt="User Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-dark">
                <div>
                    <p class="font-semibold text-black">${data.username}</p>
                    <p class="text-sm text-gray-500">${data.created_at}</p>
                    <p class="mt-2 text-black">${data.comment}</p>
                </div>
            `;
                              commentsSection.prepend(newComment);
                              document.getElementById('comment_text').value = '';
                          } else {
                              alert(data.message);
                          }
                      })
                      .catch(error => console.error('Error:', error));
              });
          </script>
          <style>
              .interaction-btn {
                  transition: background-color 0.3s ease, color 0.3s ease;
              }

              .bg-black {
                  background-color: #000;
              }

              .text-white {
                  color: #fff;
              }
          </style>
          <!-- /Interaction Section -->
      </article>
  </main>

  <!-- Relevant Posts Section -->
  <section class="bg-gray-50 rounded-lg shadow-md mt-12">
      <h3 class="text-2xl font-bold mb-5 text-gray-800 text-center">Relevant Articles</h3>
      <div class="container mx-auto px-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
              <?php
                if (isset($_GET['id'])) {
                    $id_post = $_GET['id'];
                    $a = "INNER JOIN categories ON posts.category_id = categories.id
                  INNER JOIN users ON posts.author_id = users.id_user";
                    // Fetch current post details (category & tags)
                    $postQuery = $kon->query("SELECT category_id FROM posts WHERE id_post = '$id_post'");
                    if ($postQuery->num_rows > 0) {
                        $post = $postQuery->fetch_assoc();
                        $current_category_id = $post['category_id'];

                        // Fetch post tags
                        $tagQuery = $kon->query("SELECT id_tag FROM post_tags WHERE id_posts = '$id_post'");
                        $tag_ids = [];
                        while ($tag = $tagQuery->fetch_assoc()) {
                            $tag_ids[] = $tag['id_tag'];
                        }
                        $tag_ids_string = implode(",", $tag_ids);

                        // Query to fetch relevant posts by category and tags
                        $relevantQuery = $kon->query("
                        SELECT DISTINCT posts.*, categories.name AS category_name, users.username AS author_name
                        FROM posts $a
                        WHERE (category_id = '$current_category_id' OR id_post IN (
                            SELECT post_tags.id_posts FROM post_tags WHERE post_tags.id_tag IN ($tag_ids_string)
                        ))
                        AND id_post != '$id_post'
                        ORDER BY id_post DESC
                        LIMIT 6
                    ");

                        if ($relevantQuery->num_rows > 0) {
                            while ($relevantPost = $relevantQuery->fetch_assoc()) {
                ?>
                              <article class="bg-white rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-lg mb-5">
                                  <a href="?p=readpage&id=<?= htmlspecialchars($relevantPost['id_post']) ?>">
                                      <div class="relative h-48">
                                          <img src="assets/img/uploads/<?= htmlspecialchars($relevantPost['images']) ?>" alt="Blog post" class="object-cover w-full h-full" />
                                      </div>
                                      <div class="p-4">
                                          <div class="flex items-center justify-between mb-2">
                                              <span class="text-xs text-gray-500"><?= date('F d, Y', strtotime($relevantPost['created_at'])) ?></span>
                                              <span class="px-2 py-1 bg-black text-white text-xs font-medium rounded-full">
                                                  <?= htmlspecialchars($relevantPost['category_name']) ?>
                                              </span>
                                          </div>
                                          <h2 class="text-xl font-semibold mb-2 line-clamp-2">
                                              <?= htmlspecialchars($relevantPost['tittle']) ?>
                                          </h2>
                                          <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                              <?= substr($relevantPost['content'], 0, 120) ?>...
                                          </p>
                                          <div class="flex items-center justify-between">
                                              <div class="flex items-center space-x-2 mt-2">
                                                  <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                                  <span class="text-sm font-medium">
                                                      <?= htmlspecialchars($relevantPost['author_name']) ?>
                                                  </span>
                                              </div>
                                              <span class="text-sm text-gray-500">5 min read</span>
                                          </div>
                                      </div>
                                  </a>
                              </article>
              <?php
                            }
                        } else {
                            echo "<p class='text-center text-gray-500'>No relevant posts available.</p>";
                        }
                    }
                } else {
                    echo "<p class='text-center text-gray-500'>No relevant posts available.</p>";
                }
                ?>
          </div>
      </div>
  </section>