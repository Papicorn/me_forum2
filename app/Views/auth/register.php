<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS/BOOTSTRAP TAG -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Register</title>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }
</style>
</head>
<body style="background-color:#EDF0F4;">

    <div class="container mt-3">
        <div>
            <a href="<?= base_url() ?>" class="btn btn-primary"><i class="fa me-2 fa-arrow-left" aria-hidden="true"></i>Back</a>
        </div>
        <div class="row d-flex justify-content-center mt-5">
        <div class="col-md-5">    
            <?php if(session()->has('alert')):
                $alert = session('alert'); ?>
                <div class="alert alert-<?= $alert['alert'] ?> alert-dismissible fade show"><?= $alert['pesan'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            <?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                    <?php foreach(session('error') as $errors): ?>
                        <li><?= esc($errors) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border">
                <div class="card-body">
                    <h3 class="text-center m-0 fw-bold">Register</h3><hr>
                    <form action="<?= route_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mt-3">
                            <label class="form-label" for="fullname">Full name</label>
                            <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Masukkan nama lengkap" autocomplete="off">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" autocomplete="off">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" autocomplete="off">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" autocomplete="off">
                        </div>
                        <input type="submit" value="Register" name="register" class="btn btn-primary mt-3">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>

</body>
</html>