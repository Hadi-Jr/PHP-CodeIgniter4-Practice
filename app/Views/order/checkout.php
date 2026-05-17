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
                                    <h3><?= lang('App.checkout') ?></h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="seipkon-breadcromb-right">
                                    <ul>
                                        <li><a href="<?= base_url('/') ?>">
                                                <?= lang('App.home')?></a>
                                        </li>
                                        <li><?= lang('App.checkout') ?></li>
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
                    <div class="page-box" style="border-radius: 10px">
                        <div class="row">
                            <div class="col-md-7 col-sm-7">
                                <div class="add-product-form-group">
                                    <h3><?= lang('App.personal_data') ?></h3>
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <label><?= lang('App.full_name') ?></label>
                                                    <input name="full_name" type="text"
                                                           placeholder="<?= lang('App.enter_full_name') ?>">
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <label><?= lang('App.email_username_placeholder') ?></label>
                                                    <input name="email" type="text"
                                                           placeholder="<?= lang('App.enter_email') ?>">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>
                                                    <label><?= lang('App.phone_number') ?></label>
                                                    <input name="phone_number" type="text"
                                                           placeholder="<?= lang('App.enter_phone_number') ?>">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <label><?= lang('App.shipping_address') ?></label>
                                                    <textarea placeholder="<?= lang('App.shipping_address_placeholder') ?>" >
                                                    </textarea>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <label><?= lang('App.notes') ?></label>
                                                    <textarea placeholder="<?= lang('App.notes') ?>" >
                                                    </textarea>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <p>
                                                    <label><?= lang('App.name_on_cart') ?></label>
                                                    <input name="cart_full_name" type="text" placeholder="<?= lang('App.enter_full_name') ?>">
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <label>CVV</label>
                                                    <input name="cvv" type="text" placeholder="<?= lang('App.enter_cvv') ?>">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <label><?= lang('App.validity') ?></label>
                                                    <input name="" type="text" placeholder="Date">
                                                </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p>
                                                    <label><?= lang('App.card_number') ?></label>
                                                    <input name="card_number" type="text" placeholder="<?= lang('App.enter_card_number') ?>">
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="add-product-image-upload">
                                    <h3><?= lang('App.summary') ?></h3>
                                    <div class="row">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3" style="margin-top: 5px;">
                                            <strong class="total-amount" style="font-size: 14px;"><?= lang('App.total') ?>: $<?= $total ?> </strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="product-order" class="table table-hover dataTable
                                                no-footer" role="grid" aria-describedby="product-order_info">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($cart_items ?? [] as $ci) {
                                                            ?>
                                                            <tr role="row" class="odd">
                                                                <td class="sorting_1">
                                                                    <img src="<?=
                                                                    base_url('assets/img/products/' . $ci->image_url) ?>">
                                                                </td>
                                                                <td><?= $ci->{session()->get('locale') . '_name'} ?></td>
                                                                <td>x<?= $ci->quantity ?></td>
                                                                <td>$<?= $ci->price ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display: flex; justify-content: center; margin-top: 20px">
                                            <a href=""
                                               class="btn btn-success btn-lg btn-rounded">
                                                Proceed to checkout
                                            </a>
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
