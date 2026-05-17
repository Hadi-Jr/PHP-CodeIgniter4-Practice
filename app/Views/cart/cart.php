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
                                    <h3><?= lang('App.cart') ?></h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="seipkon-breadcromb-right">
                                    <ul>
                                        <li><a href="<?= base_url('/') ?>"><?= lang('App.home')?></a></li>
                                        <li><?= lang('App.cart') ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcromb Row -->

            <!-- Product Table Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-box" style="border-radius: 10px">
                        <div class="table-responsive" style="border-radius: 5px">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th><?= lang('App.product_name') ?></th>
                                    <th><?= lang('App.price') ?></th>
                                    <th><?= lang('App.quantity') ?></th>
                                    <th><?= lang('App.subtotal') ?></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($cart_items ?? [] as $ci) {
                                    ?>
                                    <tr>
                                        <td>
                                            <img style="width: 150px" src="<?= base_url('assets/img/products/' . $ci->image_url)?>">
                                        </td>
                                        <td><?= $ci->{session()->get('locale') . '_name'} ?></td>
                                        <td>$<?= $ci->price ?></td>
                                        <td><?= $ci->quantity ?></td>
                                        <td class="sub_total_amount_<?= $ci->id ?>">$<?= $ci->subtotal ?></td>
                                        <td>
                                            <div class="quantity-btns" style="width: 50%" data-id="<?= $ci->id ?>">
                                                <button id="decrease-qty-btn" type="submit" class="btn btn-bordered-success btn-rounded decrease">
                                                    <i class="fa-solid fa-minus" style="color: rgb(28, 208, 199); margin-left: 3px"></i>
                                                </button>

                                                <input data-id="<?= $ci->id ?>" class="qty-selector" name="qty" maxlength="3" type="text" value="<?= $ci->quantity ?>">

                                                <button id="increase-qty-btn" type="submit" class="btn btn-bordered-success btn-rounded increase">
                                                    <i class="fa-solid fa-plus" style="color: rgb(28, 208, 199); margin-left: 3px"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <a style="font-size: 22px;" data-id="<?= $ci->id ?>" href="#" class="product-table-danger delete-btn" data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="5"></td>
                                    <td colspan="2">
                                        <div style="display: flex; align-items: center; justify-content: space-evenly" class="table-footer single-button-item" bis_skin_checked="1">
                                            <strong class="total-amount" style="font-size: 18px">Total: $<?= $total ?></strong>
                                            <a href="<?= base_url('/order/checkout/' . $ci->cart_id) ?>"
                                               class="btn btn-success btn-lg btn-rounded">
                                                Proceed to checkout
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Table Row End -->
        </div>
    </div>
</section>

<script>
    $('button.decrease').on('click', function () {
        var productId = $(this).closest('.quantity-btns').data('id');
        var qtyInput = $(`input[data-id="${productId}"]`);
        var count = qtyInput.val();
        count--;

        if (count === 0) {
            Swal.fire({
                title: '<?= lang('App.sure_to_delete')?>',
                showCancelButton: true,
                confirmButtonText: "<?= lang('App.save') ?>",
                cancelButtonText: "<?= lang('App.cancel') ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('/cart/remove-cart-item') ?>',
                        type: 'post',
                        data: {
                            cart_item_id: productId
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(response.message , "", "success");
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }
                    });
                } else {
                    qtyInput.val(1);
                }
            });
        } else {
            $.ajax({
                url: '<?= base_url('/decrease-quantity') ?>',
                type: 'post',
                data: {
                    cart_item_id: productId
                },
                success: function (response) {
                    if (response.success) {
                        $('.sub_total_amount_' + productId).html('$' + response.subtotal.toFixed(2));
                        $('.total-amount').html('Total: $' + response.total.toFixed(2));
                        Swal.fire({
                            icon: 'info',
                            text: 'Quantity decreased',
                            position: 'bottom-left',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                }
            });
        }

        qtyInput.val(count);
    });

    $('button.increase').on('click', function () {
        var productId = $(this).closest('.quantity-btns').data('id');
        var qtyInput = $(`input[data-id="${productId}"]`);
        var count = qtyInput.val();
        count++;
        qtyInput.val(count);

        $.ajax({
            url: '<?= base_url('/increase-quantity') ?>',
            type: 'post',
            data: {
                cart_item_id: productId
            },
            success: function (response) {
                if (response.success) {
                    $('.sub_total_amount_' + productId).html('$' + response.subtotal.toFixed(2));
                    $('.total-amount').html('Total: $' + response.total.toFixed(2));
                    Swal.fire({
                        icon: 'info',
                        text: 'Quantity increased',
                        position: 'bottom-left',
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            }
        });
    });
</script>

<script>
    $('.delete-btn').on('click', function (e){
        e.preventDefault();
        var productId = $(this).data('id');

        Swal.fire({
            title: '<?= lang('App.sure_to_delete')?>',
            showCancelButton: true,
            confirmButtonText: "<?= lang('App.save') ?>",
            cancelButtonText: "<?= lang('App.cancel') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/cart/remove-cart-item') ?>',
                    type: 'post',
                    data: {
                        cart_item_id: productId
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(response.message , "", "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            } else {
                qtyInput.val(1);
            }
        });
    })
</script>