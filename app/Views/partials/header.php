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

    <title>Me Forum</title>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }
</style>
</head>
<body class="bg-darks" style="background-color:#EDF0F4;">
    <nav class="bg-primary py-2">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="<?= base_url() ?>" class="text-decoration-none"><p class="text-light m-0 fs-3 fw-bold">Me Forum</p></a>
                <div class="d-flex ms-5">
                    <a href=""><p class="btn m-0 text-light">Community</p></a>
                    <a href=""><p class="btn m-0 text-light">Forms</p></a>
                    <a href=""><p class="btn m-0 text-light">Staff</p></a>
                    <?php if(session()->get('is_logged_in') == true): ?>
                        <div class="dropdown">
                            <a class="btn btn-outline-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $user['username']; ?>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?= route_to('logout') ?>">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                    <a class="" href="<?= base_url('/login') ?>"><p class="btn btn-success rounded m-0 text-light">Login</p></a>
                    <a class="ms-2" href="<?= base_url('/register') ?>"><p class="btn btn-info rounded m-0 text-light">Register</p></a>
                    <?php endif; ?>
                </div>
                <form class="d-flex align-items-center" role="search">
                    <input class="me-2 rounded-3 ps-2" type="search" style="height:35px;" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success py-1" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pt-3">