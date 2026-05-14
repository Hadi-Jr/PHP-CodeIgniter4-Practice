<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->

<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Main Header Start -->
    <header class="main-header">
        <!-- Logo Start -->
        <div class="seipkon-logo">
            <a href="<?= base_url('/') ?>">
                <img class="img-responsive"
                     src="<?= base_url('assets/img/logo/random-logo3.jpg') ?>" alt="logo">
            </a>
        </div>
        <!-- Logo End -->

        <!-- Header Top Start -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="header-top-section">

                    <div class="pull-left">
                        <!-- Collapse Menu Btn Start -->
                        <button type="button" id="sidebarCollapse" class=" navbar-btn">
                            <i class="fa-solid fa-layer-group"></i>
                            <?= lang('App.categories') ?>
                        </button>

                        <a style="color: #f83a3a; cursor:pointer; margin-left: 50px; margin-right: 20px;">
                            <i class="fa-solid fa-tag"></i>
                            <?= lang('App.promotions') ?>
                        </a>
                        <a style="color: #3d3b3b; cursor:pointer; margin-right: 20px;">
                            <?= lang('App.new_products') ?>
                        </a>
                        <div class="header-top-search">
                            <form>
                                <input type="search" placeholder="Search...">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="header-top-right-section pull-right">
                        <div class="header-set">
                            <a style="cursor: pointer; font-size: 22px; margin-right: 10px;" href="<?= base_url('/cart/view-cart') ?>">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            <?php
                            if (!$user_data) {
                            ?>
                            <a style="cursor: pointer; font-size: 22px;" href="<?= base_url('/login') ?>">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <?php
                            } else {
                            ?>
                                <a style="cursor: pointer; font-size: 22px;" href="<?= base_url('/logout') ?>">
                                    <i class="fa-solid fa-sign-out"></i>
                                </a>
                            <?php
                            }
                            ?>

                            <form class="lang-dropdown-form">
                                <select name="language" class="lang-select">
                                    <option value="en" <?= session()->get('locale') === 'en' ? 'selected' : '' ?>>
                                        English
                                    </option>
                                    <option value="de" <?= session()->get('locale') === 'de' ? 'selected' : '' ?>>
                                        Deutsch
                                    </option>
                                    <option value="bg" <?= session()->get('locale') === 'bg' ? 'selected' : '' ?>>
                                        Български
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Header Top End -->
    </header>
    <!-- Main Header End -->

    <script>
        $(document).ready(function() {
            $('select[name="language"]').on('change', function () {
                var locale = $(this).val();

                $.ajax({
                    url: '<?= base_url('language/switch') ?>',
                    type: 'post',
                    data: {
                        'locale': locale
                    },
                    success: function() {
                        location.reload();
                    },
                });
            });
        });
    </script>

    <?= view('sidebar/sidebar') ?>
