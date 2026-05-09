<section id="content" class="seipkon-content-wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcromb Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-area">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="seipkon-breadcromb-left">
                                    <h3><?= $product_data->{$locale . '_name'} ?></h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="seipkon-breadcromb-right">
                                    <ul>
                                        <li>
                                            <a href="<?= base_url('/') ?>">
                                                <?= lang('App.home') ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('category/' . $product_data->cat_slug) ?>">
                                                <?= $product_data->cat_name ?>
                                            </a>
                                        </li>
                                        <li>
                                            <?= $product_data->{$locale . '_name'} ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcromb Row -->

            <!-- Add Product Area Start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-box">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="add-product-image-upload">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="product-upload-image">
                                                <img src="<?= base_url('assets/img/products/'.$product_data->image_url) ?>"
                                                     alt="image"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="add-product-form-group">
                                    <h3><?= $product_data->{$locale . '_name'} ?></h3>
                                    <div class="spacing-bottom-1"></div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-default btn-rounded">
                                                <i class="fas fa-shipping-fast"></i>
                                                <?= lang('App.free_delivery') ?>
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <p>
                                                SKU: <?= $product_data->sku ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="display: flex; gap: 10px;">
                                                <div id="product-rater" dir="ltr"></div> <?= number_format($product_rating, 1) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="spacing-bottom-3"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>
                                                <?= lang('App.by') ?>
                                                <strong>
                                                    <?= $product_data->brand ?>
                                                </strong>
                                            </h4>
                                        </div>
                                        <div class="col-md-3">
                                            <p>
                                                <?= $product_data->stock_quantity ?>
                                                <?= lang('App.left') ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="spacing-bottom-2"></div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h2 class="product-price">
                                                <strong>
                                                    <?= $product_data->price ?> $
                                                </strong>
                                            </h2>
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                    <div class="spacing-bottom-2"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="quantity-btns">
                                                <button id="decrease-qty-btn" type="submit" class="btn btn-bordered-success btn-rounded">
                                                    <i class="fa-solid fa-minus" style="color: rgb(28, 208, 199);
                                                    margin-left: 3px"></i>
                                                </button>
                                                <input class="qty-selector" name="qty" maxlength="3" type="text" value="1">
                                                <button id="increase-qty-btn" type="submit" class="btn btn-bordered-success btn-rounded">
                                                    <i class="fa-solid fa-plus" style="color: rgb(28, 208, 199);
                                                    margin-left: 3px"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p>
                                                <button type="submit" class="btn btn-success btn-rounded">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                    <?= lang('App.add_to_cart') ?>
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                    <div class="spacing-bottom-4"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="tabs-box-example horizontal-tab-example" bis_skin_checked="1">
                                                <ul class="nav nav-tabs" id="service_pro" role="tablist">
                                                    <li class="active" role="presentation"><a href="#description"
                                                                                              role="tab" data-toggle="tab"
                                                                                              aria-expanded="true">
                                                            <?= lang('App.description') ?>
                                                        </a>
                                                    </li>

                                                    <li role="presentation" class=""><a href="#features"
                                                                                        role="tab" data-toggle="tab"
                                                                                        aria-expanded="false">
                                                            <?= lang('App.features') ?>
                                                        </a>
                                                    </li>

                                                    <?php
                                                    foreach ($additional_data as $data) {
                                                        ?>
                                                        <li role="presentation" class=""><a href="#<?= $data->id ?>"
                                                                                            role="tab" data-toggle="tab"
                                                                                            aria-expanded="false">
                                                                <?= $data->{$locale . '_key'} ?>
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                                <div id="seipkkon_tab_content" class="tab-content" bis_skin_checked="1">
                                                    <div id="description" class="tab-pane fade active in" bis_skin_checked="1">
                                                        <?= $product_data->{$locale . '_description'}?>
                                                    </div>

                                                    <?php
                                                    foreach ($additional_data as $data) {
                                                        ?>
                                                        <div id="<?= $data->id ?>" class="tab-pane fade" bis_skin_checked="1">
                                                            <?= $data->{$locale . '_value'} ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <div id="features" class="tab-pane fade">
                                                        <div class="table-responsive">
                                                            <table class="table" style="width: 40%">
                                                                <thead>
                                                                    <tr>
                                                                    <?php
                                                                    foreach ($features_table ?? [] as $feature) {
                                                                            ?>
                                                                        <th>
                                                                            <?= $feature->{$locale . '_key'}  ?>
                                                                        </th>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($features_table ?? [] as $feature) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?= $feature->{$locale . '_value'}  ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add Product Area -->
        </div>
    </div>
</section>

<script>
    var basicRating;
    document.querySelector("#product-rater") && (basicRating = raterJs({
        starSize: 20,
        rating: <?= number_format($product_rating, 1) ?>,
        element: document.querySelector("#product-rater"),
        rateCallback: function(e, t) {
            this.setRating(e);

            Swal.fire({
                title: '<?= lang('App.rating_title')?>',
                text: '<?= lang('App.rating_text')?>',
                showCancelButton: true,
                confirmButtonText: "<?= lang('App.save') ?>",
                cancelButtonText: "<?= lang('App.cancel') ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('/rate/product') ?>',
                        data: {
                            'rate_value' : e,
                            'product_id' : <?= $product_data->id ?>,
                            'user_id' : '<?= $user_data->id ?? '' ?>'
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(response.message , "", "success");
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else if (response.already_rated) {
                                Swal.fire({
                                    icon: "info",
                                    title: response.message,
                                });
                            } else if (!response.success) {
                                Swal.fire({
                                    icon: "warning",
                                    title: response.message,
                                    footer: "<a href=\"" + "<?= base_url('/login') ?>" + "\"><?= lang('App.login_here') ?></a>"
                                });
                            }
                        }
                    });
                }
            });

            t();
        }
    }));
</script>

<script>
    let qty = 1;
    $('#decrease-qty-btn').on('click', function () {
        if (qty !== 1) {
            qty--;
        }
       $('input.qty-selector').val(qty);
    });

    $('#increase-qty-btn').on('click', function () {
        if (qty !== <?= $product_data->stock_quantity ?>) {
            qty++;
        }
        $('input.qty-selector').val(qty);
    });
</script>

<script>

</script>
