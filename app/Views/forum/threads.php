<?= $this->include('partials/header') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>"><?= $category['category'] ?></a></li>
        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/forum/'.$parents['id_parents'].'/'.url_title($parents['title'], '-', true)) ?>"><?= $parents['title'] ?></a></li>
        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/forum/'.$subparents['id_parents'].'/'. $subparents['id_subparents'] . '/' . url_title($subparents['title'], '-', true)); ?>"><?= $subparents['title'] ?></a></li>
        <li class="breadcrumb-item active text-body-tertiary" aria-current="page"><?= $threads['title'] ?></li>
    </ol>

    <div class="row gy-4">
        <div class="col-12">
            <?php if(session()->has('alert')):
                $alert = session('alert'); ?>
                <div class="alert alert-<?= $alert['alert'] ?> alert-dismissible fade show"><?= $alert['pesan'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            <?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                    <?php foreach(session('error') as $errors): ?>
                    <li><?= esc($errors) ?></li>
                    <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
            <?php endif; ?>
            <div class="card shadow-sm card-body">
                <h4 class="fw-bold mb-0"><span class="badge bg-primary fw-normal rounded-pill">TES</span> <?= $threads['title'] ?></h4><hr>
                <div class="d-flex align-items-center">
                    <img class="rounded-circle" style="width:60px;height:60px;" src="https://jogjagamers.org/uploads/monthly_2023_08/imported-photo-120993.thumb.png.18ad581eac57e069b6e5cfaef399e691.png" alt="">
                    <p class="mb-0 ms-2 fw-bold">By <?= $ownerThreads['username'] ?><br>
                    <font class="fw-normal text-muted" style="font-size:15px;"><?= $created_at ?> in <?= $subparents['title'] ?></font></p>
                </div>
            </div>
        </div>

        <div class="col-12">
            
            <div class="card card-body shadow-sm">
                <div class="row">

                    <div class="col-2 text-center">
                        <div>
                            <h5 class="fw-bold mb-1"><?= $ownerThreads['username'] ?></h5>
                            <img class="rounded-circle mb-2" style="width:100px;height:100px;" src="https://jogjagamers.org/uploads/monthly_2023_08/imported-photo-120993.thumb.png.18ad581eac57e069b6e5cfaef399e691.png" alt="">
                            <p class="mb-2"><?= $ownerThreads['role'] ?></p>
                            <i class="fa fa-comments text-muted mb-2" aria-hidden="true"></i> <span class="text-muted">3</span>
                            <p class="fw-lighter">Game: Dota</p>
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="col-10">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Posted <?= $created_at ?></span>
                            
                            <?php if(session()->get('is_logged_in') == true): ?>
                                <?php if($user['role'] == "administrator" || $threads['id_user'] == $user['id_user']): ?>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="menuThreads" data-bs-toggle="dropdown" aria-expanded="false">
                                    Menu
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="menuThreads">
                                    <li><a class="dropdown-item" href="#" type="button" data-bs-toggle="modal" data-bs-target="#<?= $threads['id_threads'] ?>modalEdit">Edit threads</a></li>
                                    <li><a class="dropdown-item" href="#" type="button" data-bs-toggle="modal" data-bs-target="#<?= $threads['id_threads'] ?>modalDelete">Delete threads</a></li>
                                </ul>
                            </div>
                            <?php endif;
                            endif; ?>
                        </div>

                        <h4 class="fw-bold text-center mb-0 mt-3"><?= $threads['title'] ?></h4>
                        <hr>
                        <?= $threads['content'] ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CREATE THREADS -->
    <div class="modal fade" id="<?= $threads['id_threads'] ?>modalEdit" tabindex="-1" aria-labelledby="<?= $threads['id_threads'] ?>labelEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $threads['id_threads'] ?>labelEdit">Edit Threads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= route_to('edit.threads', $threads['id_threads']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-body row gy-3">
                <div class="col-12">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= $threads['title'] ?>" placeholder="Masukkan judul parents">
                </div>
                <div class="col-12">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" placeholder="Masukkan content" class="form-control"><?= $threads['content'] ?></textarea>
                </div>
                <div class="col-12">
                    <label for="privacy" class="label-control">Icon</label>
                    <select name="privacy" id="privacy" class="form-control">
                        <option value="<?= $threads['privacy'] ?>" selected><?= $threads['privacy'] ?></option>
                        <option value="" disabled>-- Pilih --</option>
                        <option value="public">public</option>
                        <option value="private" disabled>private</option>
                    </select>
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
    <!-- END MODAL CREATE THREADS -->

    <!-- MODAL DELETE THREADS -->
    <div class="modal fade" id="<?= $threads['id_threads'] ?>modalDelete" tabindex="-1" aria-labelledby="<?= $threads['id_threads'] ?>label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $threads['id_threads'] ?>label">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Content pada threads ini akan dihapus secara permanen!</p>
                <p>Apakah anda yakin untuk menghapus threads <b><?= $threads['title'] ?></b>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="<?= route_to('delete.threads', $threads['id_threads']) ?>" method="post">
                <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <!-- END MODAL DELETE THREADS -->

</div>
<?= $this->include('partials/footer') ?>