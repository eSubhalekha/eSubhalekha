<nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
    <div class="container px-0">
        <a class="navbar-brand font-heading ps-3 text-secondary" href="<?php echo home(); ?>">
            SoulPair
        </a>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarList"
            aria-controls="navbarList" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 fw-bold"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarList">
            <?php if (url() != route('login')) { ?>

                <ul class="navbar-nav ms-auto  mb-2 mb-lg-0 d-flex align-items-center">

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#coupleSection">Bride & Groom</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#eventsSection">Events</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#gallerySection">Gallery</a>
                    </li>

                </ul>

            <?php } ?>
        </div>
    </div>
</nav>