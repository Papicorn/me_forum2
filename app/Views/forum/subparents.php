<?= $this->include('partials/header') ?>
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/home') ?>"><?= $category['category'] ?></a></li>
                <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none text-muted" href="<?= base_url('/forum/'.$parent['id_parents'].'/'.url_title($parent['title'], '-', true)) ?>"><?= $parent['title'] ?></a></li>
                <li class="breadcrumb-item active text-body-tertiary" aria-current="page"><?= $subparents['title'] ?></li>
            </ol>

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
                <h3><b><?= $subparents['title'] ?></b></h3>
            </div>

            <?php if(session()->has('is_logged_in')): ?>
            <div class="d-flex justify-content-end">
                <?php if($user['role'] == 'administrator'): ?>
                <div class="d-flex justify-content-end my-3 me-3">
                    <a href="" class="btn btn-danger py-3 px-5" type="button" data-bs-toggle="modal" data-bs-target="#<?= $subparents['id_subparents'] ?>modal">
                        Delete subparent
                    </a>
                </div>
                <?php endif; ?>
                <div class="d-flex justify-content-end my-3">
                    <a href="" class="btn btn-success py-3 px-5" type="button" data-bs-toggle="modal" data-bs-target="#createThreads">
                        Start new thread
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm <?php if(!session()->has('is_logged_in')): ?> mt-4 <?php endif; ?>">
                <div class="card-header">
                    thread
                </div>
                <div class="card-body py-0">
                    <table class="table mb-0">
                        <?php $cekThreads = false;
                        foreach ($threads as $thread) :
                            if($thread['id_subparents'] == $subparents['id_subparents']): 
                            $cekThreads = true;
                        ?>
                        <tr class="mb-5">
                            <td class="py-3 align-middle ps-3 col">
                                <i class="fa-solid fa-circle" style="color: #152d53;font-size:16px;"></i> 
                            </td>
                            <td class="py-3 align-middle col-8">
                            <a href="/thread/<?= $subparents['id_subparents'] .'/'. $thread['id_threads'] ?>/<?= url_title($thread['title'], '-', true) ?>" class="text-decoration-none">
                                <h5 class="m-0 text-dark"><b><?= $thread['title'] ?></b></h5>
                            </a>
                            <label class="text-start text-muted" style="font-size:14px;">By <?= $thread['username'] ?> 2 hours ago</label>
                            </td>

                            <td class="py-3 align-middle col-1 text-end">
                                <h6 class="m-0 text-muted">0</h6>
                                <label class="text-start text-muted" style="font-size:14px;">Replies</label>
                            </td>
                            
                            <td class="py-3 align-middle pe-3 col-3">
                                <div class="d-flex">
                                    <img style="width:50px; height:50px;" class="bg-info rounded-circle" src="https://jogjagamers.org/uploads/monthly_2023_08/imported-photo-120993.thumb.png.18ad581eac57e069b6e5cfaef399e691.png" alt="">
                                    <div class="ms-2 align-middle text-start">
                                        <div class="d-flex">
                                            <p class="text-start overflow-hidden m-0 col-10" style="height:25px;"><?= $thread['id_user'] ?></p>
                                        </div>
                                        <label class="text-start text-muted" style="font-size:14px;">2 hours ago</label>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?php endif;
                        endforeach; 
                        if($cekThreads == false): ?>
                            <div class="text-center my-3">
                                <label class="text-muted text-center">Threads not found here!</label>
                            </div>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            
            <?php if(session()->has('is_logged_in') && $user['role'] == "administrator"): ?>
            <!-- MODALS DELETE SUBPARENTS (ADMIN) -->
            <div class="modal fade" id="<?= $subparents['id_subparents'] ?>modal" tabindex="-1" aria-labelledby="<?= $subparents['id_subparents'] ?>Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?= $subparents['id_subparents'] ?>Label">Konfirmasi Penghapusan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Semua content yang ada di subparent tersebut akan terhapus!</p>
                        <p>Apakah anda yakin untuk menghapus subparent <b><?= $subparents['title'] ?></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="<?= route_to('delete.subparent', $subparents['id_subparents']) ?>" method="post">
                        <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- END MODALS DELETE SUBPARENTS (ADMIN) -->
            <?php endif; ?>
            <!-- MODALS CREATE THREADS -->
            <?php if(session()->get('is_logged_in') == true): ?>
            <div class="modal fade" id="createThreads" tabindex="-1" aria-labelledby="createThreadsLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createThreadsLabel">Create Threads</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= route_to('post.threads', $subparents['id_subparents'], $user['id_user']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body row gy-3">
                        <div class="col-12">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul parents">
                        </div>
                        <div class="col-12">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" placeholder="Masukkan content" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="privacy" class="label-control">Icon</label>
                            <select name="privacy" id="privacy" class="form-control">
                                <option value="" disabled selected>-- Pilih --</option>
                                <option value="public" selected>public</option>
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
            <?php endif; ?>
            <!-- END MODALS CREATE THREADS -->

    </div>
    <?= $this->include('partials/footer') ?>