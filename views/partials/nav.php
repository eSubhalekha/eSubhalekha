<nav class="my-2 mx-2 navbar navbar-expand-lg bg-transparent navbar-sticky fixed-top">
    <div class="container px-0 py-2 navbar-light bg-primary shadow">
        <a class="navbar-brand font-heading fw-bold ps-3" href="<?php echo home(); ?>">
            <?= $config['APP_NAME'] ?>
        </a>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarList"
            aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 fw-bold"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarList">
            <?php if (url() != route('login')) { ?>

                <ul class="navbar-nav ms-auto me-md-3 mb-2 mb-lg-0 d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Themes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-heading" aria-current="page" href="#">Contact</a>
                    </li>

                    <?php if (App::getSession()) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link font-heading dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?php echo App::getUser()['name']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo route('dashboard'); ?>">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" aria-current="page"
                                        href="<?php echo route('logout'); ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <?php if (!App::getSession()) { ?>
                            <a class="nav-link font-heading btn btn-secondary rounded-pill" aria-current="page"
                                href="<?php echo route('register') . "?back=" . url(); ?>">Login/Signup</a>
                        <?php } ?>
                    </li>
                </ul>

            <?php } ?>
        </div>
    </div>
</nav>