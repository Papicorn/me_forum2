<?= $this->include('partials/header') ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>"><?= $category['category'] ?></a></li>
                <li class="breadcrumb-item active text-body-tertiary" aria-current="page"><?= $parent['title'] ?></li>
            </ol>
        </nav>

        <div class="row">
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

            <?php if(session()->has('is_logged_in') && $user['role'] == "administrator"): ?>
            <div class="d-flex justify-content-end">
                <div class="d-flex justify-content-end my-3 me-3">
                    <a href="" class="btn btn-danger py-3 px-5" type="button" data-bs-toggle="modal" data-bs-target="#<?= $parent['id_parents'] ?>modal">
                        Delete parent
                    </a>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <a href="" class="btn btn-success py-3 px-5" type="button" data-bs-toggle="modal" data-bs-target="#createSubparents">
                        Create new subparent
                    </a>
                </div>
            </div>
            <?php endif; ?>

                <div class="accordion shadow-sm" id="parent<?= $parent['id_parents'] ?>">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-primary text-light" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $parent['id_parents'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?= $parent['title'] ?>
                            </button>
                        </h2>
                        <div id="<?= $parent['id_parents'] ?>" class="accordion-collapse collapse show" data-bs-parent="#parent<?= $parent['id_parents'] ?>">
                            <div class="accordion-body p-0">
                                <?php if($row_subparents != 0): ?>
                                <table class="table mb-0">
                                    <?php foreach ($subparents as $subparent) :
                                        if($subparent['id_parents'] == $parent['id_parents']): ?>
                                    <tr class="mb-5">
                                        <td class="py-3 align-middle ps-3 col-1">
                                            <img width="60" src="<?= base_url('/image/'. $subparent['icon'] .'') ?>" alt="icon">
                                        </td>

                                        <td class="py-3 align-middle col-6">
                                            <div class="d-flex">
                                                <a href="/forum/<?= $parent['id_parents'] .'/'. $subparent['id_subparents'] ?>/<?= url_title($subparent['title'], '-', true) ?>" class="text-decoration-none">
                                                    <h5 class="m-0 text-dark"><b><?= $subparent['title'] ?></b></h5>
                                                </a>
                                                <?php if(session()->get('is_logged_in') == true && $user['role'] == "administrator"): ?>
                                                    <button href="" class="ms-2 btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#<?= $subparent['id_subparents'] ?>modal">Edit</button>
                                                <?php endif; ?>
                                            </div>

                                        <?php if($subparent['description'] != NULL): ?>
                                            <label class="text-muted" style="font-size:14px;">
                                        <?= $subparent['description']; ?>
                                            </label><?php endif; ?>
                                        </td>

                                        <td class="py-3 align-middle col-1 text-end">
                                            <h5 class="m-0 text-muted"><?= $subparent['thread_count'] ?></h5>
                                            <label class="text-start text-muted" style="font-size:14px;">Threads</label>
                                        </td>
                                        
                                        <td class="py-3 align-middle pe-3 col-4">
                                            <div class="d-flex">
                                                <img style="width:50px; height:50px;" class="bg-info rounded-circle" src="https://jogjagamers.org/uploads/monthly_2023_08/imported-photo-120993.thumb.png.18ad581eac57e069b6e5cfaef399e691.png" alt="">
                                                <div class="ms-2 align-middle text-start">
                                                    <div class="d-flex">
                                                        <p class="text-start overflow-hidden m-0 col-10" style="height:25px;">Bagaimana caranya menggunakan alkohol</p>
                                                        <p class="m-0">...</p>
                                                    </div>
                                                    <label class="text-start text-muted" style="font-size:14px;">By Sudibyo Raharjo, 2 hours ago</label>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>

                                    <!-- MODALS EDIT SUBPARENTS -->
                                    <div class="modal fade" id="<?= $subparent['id_subparents'] ?>modal" tabindex="-1" aria-labelledby="<?= $subparent['id_subparents'] ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="<?= $subparent['id_subparents'] ?>Label">Edit Subparent</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="<?= route_to('edit.subparents', $subparent['id_subparents']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <div class="modal-body row gy-3">
                                                    <div class="col-12">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul subparents" value="<?= $subparent['title'] ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="description">Description</label>
                                                        <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan deskripsi subparents" value="<?= $subparent['description'] ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="icon" class="label-control">Icon</label>
                                                        <select name="icon" id="icon" class="form-control">
                                                            <option value="" disabled>-- Pilih --</option>
                                                            <option value="general.png" selected>General</option>
                                                            <option value="announce.png">Announcement</option>
                                                            <option value="chat.png">Chat</option>
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
                                    <!-- END MODALS EDIT SUBPARENTS -->

                                    <?php endif;
                                    endforeach; ?>
                                </table>
                                <?php elseif($row_subparents == 0): ?>
                                    <div class="text-center my-3">
                                        <label class="text-muted text-center">Subparents not found here!</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php if(session()->has('is_logged_in') && $user['role'] == "administrator"): ?>
        <!-- MODALS DELETE PARENTS (ADMIN) -->
        <div class="modal fade" id="<?= $parent['id_parents'] ?>modal" tabindex="-1" aria-labelledby="<?= $parent['id_parents'] ?>Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?= $parent['id_parents'] ?>Label">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Semua content yang ada di parent tersebut akan terhapus!</p>
                    <p>Apakah anda yakin untuk menghapus parent <b><?= $parent['title'] ?></b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="<?= route_to('delete.parent', $parent['id_parents']) ?>" method="post">
                    <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- END MODALS DELETE PARENTS (ADMIN) -->

        <!-- MODAL CREATE SUBPARENT (ADMIN) -->
        <div class="modal fade" id="createSubparents" tabindex="-1" aria-labelledby="createSubparentsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubparentsLabel">Create Subparents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?= route_to('post.subparents', $parent['id_parents']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body row gy-3">
                    <div class="col-12">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul subparents">
                    </div>
                    <div class="col-12">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan deskripsi subparents">
                    </div>
                    <div class="col-12">
                        <label for="icon" class="label-control">Icon</label>
                        <select name="icon" id="icon" class="form-control">
                            <option value="" disabled selected>-- Pilih --</option>
                            <option value="general.png" selected>General</option>
                            <option value="announce.png">Announcement</option>
                            <option value="chat.png">Chat</option>
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
        <?php endif; ?>
        <!-- END MODAL CREATE SUBPARENT (ADMIN) -->

        </div>

<?= $this->include('partials/footer') ?>