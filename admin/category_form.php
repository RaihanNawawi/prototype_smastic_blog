<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php
        if ($_GET['category'] == "add") {
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Add Category</h5>
                        <div class="card-body">
                            <form action="?p=action&category=add" method="post">
                                <div>
                                    <label for="defaultFormControlInput" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="defaultFormControlInput" placeholder="Tech" aria-describedby="defaultFormControlHelp" name="name" />
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            // Jika user mengedit kategori
        } elseif ($_GET['category'] == "edit") {
            $kategori  = $kon->query("SELECT * FROM categories WHERE id ='$_GET[id]' ");
            $key = mysqli_fetch_array($kategori);
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Category Edit</h5>
                        <div class="card-body">
                            <form action="?p=action&category=edit" method="post">
                                <div><!-- Tambahkan input hidden untuk mengirimkan id kategori -->
                                    <input type="hidden" name="id" value="<?= $key['id'] ?>" />
                                </div>
                                <div>
                                    <label for="defaultFormControlInput" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="defaultFormControlInput" placeholder="Tech" aria-describedby="defaultFormControlHelp" name="name" value="<?= $key['name'] ?>" />
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="submit" class="btn btn-primary">Confirm Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="content-backdrop fade"></div>
</div>