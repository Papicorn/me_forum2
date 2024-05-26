<!-- MODALS CREATE CATEGORY (ADMIN) -->
<div class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createCategoryLabel">Create Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

    <form action="<?= route_to('post.category') ?>" method="post">
    <?= csrf_field() ?>
      <div class="modal-body">
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>

    </div>
  </div>
</div>
<!-- END MODALS CREATE CATEGORY (ADMIN) -->

<!-- MODALS CREATE PARENTS (ADMIN) -->
<?php if(current_url() == base_url(route_to('home'))): ?>
<div class="modal fade" id="createParents" tabindex="-1" aria-labelledby="createParentsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createParentsLabel">Create Parents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

    <form action="<?= route_to('post.parents') ?>" method="post">
    <?= csrf_field() ?>
      <div class="modal-body row gy-3">
        <div class="col-12">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul parents">
        </div>
        <div class="col-12">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan deskripsi parents">
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="id_category" class="label-control">Category</label>
                    <select name="id_category" id="id_category" class="form-control" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        <?php foreach($category as $rowModals): ?>
                            <option value="<?= $rowModals['id_category'] ?>"><?= $rowModals['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="icon" class="label-control">Icon</label>
                    <select name="icon" id="icon" class="form-control">
                        <option value="" disabled>-- Pilih --</option>
                        <option value="general.png" selected>General</option>
                        <option value="announce.png">Announcement</option>
                        <option value="chat.png">Chat</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>

    </div>
  </div>
</div>

<?php endif; ?>
<!-- END MODALS CREATE PARENTS (ADMIN) -->
