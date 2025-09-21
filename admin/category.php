<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <!-- Basic Bootstrap Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Blog Category</h5>
                <a href="?p=category_form&category=add" class="btn btn-primary">Add Category</a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $no = 1;
                        $query = $kon->query("SELECT * FROM categories ORDER BY id DESC");
                        foreach ($query as $key) { ?>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $no ?></strong></td>
                                <td><span class="badge bg-label-primary me-1"><?= $key['name'] ?></span></td>
                                <td>
                                    <a href="?p=category_form&category=edit&id=<?= $key['id'] ?>" class="btn btn-primary">Edit</a>
                                    <button data-bs-target="#deleteCategoryModal<?= $no ?>" data-bs-toggle="modal" class="btn btn-danger" type="button">Hapus</button>
                                </td>
                            </tr>

                            <!-- Delete Category Modal -->
                            <div class="modal fade" id="deleteCategoryModal<?= $no ?>" tabindex="-1" aria-labelledby="deleteCategoryModalLabel<?= $no ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteCategoryModalLabel<?= $no ?>">Delete Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are You Sure Delete "<strong><?= $key['name'] ?></strong>" Category?</p>
                                            <p class="text-muted">This Action Cannot be Canceled.</p>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="action.php?category=delete&id=<?= $key['id'] ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="my-5" />
        <!-- / Content -->
    </div>
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

