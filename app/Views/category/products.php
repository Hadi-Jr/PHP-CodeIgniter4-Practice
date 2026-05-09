<section id="content" class="seipkon-content-wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcromb Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-area">
                        <div class="row">
                            <div class="col-md-6  col-sm-6">
                                <div class="seipkon-breadcromb-left">
                                    <h3><?= $category_name ?></h3>
                                </div>
                            </div>
                            <div class="col-md-6  col-sm-6">
                                <div class="seipkon-breadcromb-right">
                                    <ul>
                                        <li><a href="<?= base_url('/') ?>">
                                                <?= lang('App.home') ?>
                                            </a></li>
                                        <li>
                                            <?= lang('App.categories') ?>
                                        </li>
                                        <li><?= strtolower($category_name) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcromb Row -->

            <!-- Product Row Start -->
            <div class="row">
                <?php
                foreach ($products ?? [] as $product) {
                    ?>
                    <div class="col-md-3 col-sm-3">
                        <!-- Single Product Start -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="<?= base_url('assets/img/products/' . $product->image_url) ?>" alt="product"/>
                                <div class="pro-image-overlay"></div>
                            </div>
                            <div class="product-info">
                                <h3><?= $product->{session()->get('locale') . '_name'}?></h3>
                                <h4 class="price">$ <?= $product->price ?></h4>
                            </div>

                            <div class="action-buttons">
                                <div class="seipkon-btn single-button-item" bis_skin_checked="1">
                                    <button data-id="<?= $product->id ?>" class="btn btn-success btn-rounded add_btn">
                                        <i style="font-size: 13px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        Add To Cart</button>
                                </div>

                                <div class="seipkon-btn single-button-item" bis_skin_checked="1">
                                    <button data-id="<?= $product->id ?>" class="btn btn-info btn-rounded view_btn">
                                        <i style="font-size: 13px;" class="fa fa-eye" aria-hidden="true"></i>
                                        View Product</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                <?php
                }
                ?>
            </div>
            <!-- End Product Row -->

        </div>
    </div>
</section>

<script>
    $(document).ready(function () {

        $('.view_btn').on('click', function (e) {
            var productId = $(this).data('id');

            window.location.href = '<?= base_url('/products/view_product/') ?>' + productId;
        });

        $('.add_btn').on('click', function () {
            var productId = $(this).attr('data-id').trim();
        });
    });
</script>