<?= $this->include('partials/header'); ?>
        <?php if(session()->has('alert')):
            $alert = session('alert');
            ?>
            <div class="alert alert-<?= $alert['alert'] ?> alert-dismissible fade show"><?= $alert['pesan'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        <?php endif; ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
        <div class="row gy-2">

            <div class="col-8">
                
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
            <div class="d-flex justify-content-end mb-3 dropdown">
                <a href="#" class="btn btn-success dropdown-toggle py-3 px-5" role="button" id="dropdownCreateCategory" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-plus me-2" aria-hidden="true"></i>Create New
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownCreateCategory">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createCategory" type="button">Create Category</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createParents" type="button">Create Parents</a></li>
                </ul>
            </div>

            <?php endif; ?>

            <div class="row gy-4">
            
    <?php foreach ($category as $row): ?>
        <div class="col-12">
        <?php if(session()->has('is_logged_in') && $user['role'] == "administrator"): ?>
            <a href="#" class="btn btn-sm mb-2 btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#<?= $row['id_category'] ?>modal">Hapus Category</a>
            <a href="#" class="btn btn-sm mb-2 btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#<?= $row['id_category'] ?>modalEdit">Edit Category</a>
        <?php endif; ?>

        <!-- delete -->
            <div class="accordion shadow-sm" id="parent<?= $row['id_category'] ?>">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button bg-primary text-light" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $row['id_category'] ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?= $row['category'] ?>
                        </button>
                    </h2>
                    <?php $parentsFound = false; // Inisialisasi variabel untuk menentukan apakah ada parents yang terkait dengan kategori ?>
                    <?php foreach ($parent as $parents) :
                        if ($parents['id_category'] == $row['id_category']) {
                            $parentsFound = true; // Setel nilai menjadi true jika ada parents yang terkait dengan kategori ?>
                            <div id="<?= $row['id_category'] ?>" class="accordion-collapse collapse show" data-bs-parent="#parent<?= $row['id_category'] ?>">
                                <div class="accordion-body p-0">
                                    <table class="table mb-0">
                                        <tr class="mb-5">
                                        <td class="py-3 align-middle ps-3 col-1">
                                                    <img width="60" src="<?= base_url('/image/'. $parents['icon'] .'') ?>" alt="icon">
                                                </td>

                                                <td class="py-3 align-middle col-6">
                                                <div class="d-flex">
                                                    <a href="/forum/<?= $parents['id_parents'] ?>/<?= url_title($parents['title'], '-', true) ?>" class="text-decoration-none">
                                                        <h5 class="m-0 text-dark"><b><?= $parents['title'] ?></b></h5>
                                                    </a>
                                                    <?php if(session()->get('is_logged_in') == true && $user['role'] == "administrator"): ?>
                                                        <button href="" class="ms-2 btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#<?= $parents['id_parents'] ?>modaledit">Edit</button>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="">
                                                <?php foreach($subparents as $subparent): 
                                                    if($subparent['id_parents'] == $parents['id_parents']) :?>
                                                    <ul class="m-0">
                                                        <li><a href="/forum/<?= $parents['id_parents'] .'/'. $subparent['id_subparents'] ?>/<?= url_title($subparent['title'], '-', true) ?>" class="text-decoration-none">
                                                            <p class="m-0 text-dark" style="font-size:14px;"><?= $subparent['title']; ?></p>
                                                        </a></li>
                                                    </ul>
                                                <?php endif;
                                            endforeach; ?>
                                            </div> <?php if($parents['description'] != NULL): ?>
                                                    <label class="text-muted" style="font-size:14px;">
                                                <?= $parents['description']; ?>
                                                    </label><?php endif; ?>
                                                </td>

                                                <td class="py-3 align-middle col-1 text-end">
                                                    <h5 class="m-0 text-muted"><?= $parents['total_thread'] ?></h5>
                                                    <label class="text-muted">Threads</label>
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
                                    </table>
                                </div>
                            </div>

                            <div class="modal fade" id="<?= $parents['id_parents'] ?>modaledit" tabindex="-1" aria-labelledby="<?= $parents['id_parents'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?= $parents['id_parents'] ?>Label">Edit Parents</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="<?= route_to('edit.parents', $parents['id_parents']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="modal-body row gy-3">
                                        <div class="col-12">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul parents" value="<?= $parents['title'] ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" id="description" class="form-control" placeholder="Masukkan deskripsi parents" value="<?= $parents['description'] ?>">
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
                        <?php }
                    endforeach; ?>
                    <?php if (!$parentsFound) : // Tampilkan pesan jika tidak ada parents yang terkait dengan kategori ?>
                        <div id="<?= $row['id_category'] ?>" class="accordion-collapse collapse show" data-bs-parent="#parent<?= $row['id_category'] ?>">
                            <div class="accordion-body">
                                <div class="text-center my-3">
                                    <label class="text-muted text-center">Parents not found here!</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(session()->has('is_logged_in') && $user['role'] == "administrator"): ?>
            <div class="modal fade" id="<?= $row['id_category'] ?>modal" tabindex="-1" aria-labelledby="<?= $row['id_category'] ?>Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?= $row['id_category'] ?>Label">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Semua content yang ada di category tersebut akan terhapus!</p>
                    <p>Apakah anda yakin untuk menghapus category <b><?= $row['category'] ?></b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="<?= route_to('delete.category', $row['id_category']) ?>" method="post">
                    <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                </div>
            </div>
            </div>

            <div class="modal fade" id="<?= $row['id_category'] ?>modalEdit" tabindex="-1" aria-labelledby="<?= $row['id_category'] ?>label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?= $row['id_category'] ?>label">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= route_to('edit.category', $row['id_category']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div>
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= $row['category'] ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    </form>

                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- MODAL HAPUS CATEGORY -->
        
    <?php endforeach; ?>
</div>


            </div>
            
            <div class="col-4">

                <div class="accordion shadow-sm" id="right1">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-primary text-light" type="button" data-bs-toggle="collapse" data-bs-target="#right" aria-expanded="true" aria-controls="collapseOne">
                            User Online
                            </button>
                        </h2> 
                        <div id="right" class="accordion-collapse collapse show" data-bs-parent="#right1">
                            <div class="accordion-body">
                                <i class="text-muted center">Coming Soon</i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?= $this->include('partials/footer'); ?>
    