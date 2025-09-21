<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Blog Tags</h5>
                <a href="?p=tags_form&tag=add" class="btn btn-primary">Add #Tags</a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tags</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $no = 1;
                        $query = $kon->query("SELECT * FROM tags ORDER BY id DESC");
                        foreach ($query as $key) { ?>
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $no ?></strong></td>
                                <td><span class="badge bg-label-primary me-1"><?= $key['name'] ?></span></td>
                                <td>
                                    <a href="?p=tags_form&tag=edit&id=<?= $key['id'] ?>" class="btn btn-primary">Edit</a>
                                    <button data-bs-target="#deleteTag<?= $no ?>" data-bs-toggle="modal" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                            <!-- Delete Tag Modal -->
                            <div class="modal fade" id="deleteTag<?= $no ?>" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteCategoryModalLabel<?= $no ?>">Delete Tag</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are You Sure Delete "<strong><?= $key['name'] ?></strong>" Tag?</p>
                                            <p class="text-muted">This Action Cannot be Canceled.</p>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="action.php?tag=delete&id=<?= $key['id'] ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $no++;
                                        } ?>
                        </tbody>
                        </table>
            </div>
        </div>
    </div>
    <hr class="my-5" />
    <!-- / Content -->
</div>
<div class="content-backdrop fade"></div>