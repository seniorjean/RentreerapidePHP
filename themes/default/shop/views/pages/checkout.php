<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$installment_settings = $this->db->get_where('installment_settings',['id'=>1])->row();

$condition = $installment_settings->terms;
?>
<style>
    .choose_installment{
        border: none;
        padding: 0px;
        background-color: transparent;
    }
    .dis-none{display:none}
    .select-address{
        border: solid thin orange;
        border-radius: 6px;
    }
</style>
<section class="page-contents">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">

                    <div class="<?=($mobile==FALSE)?'col-sm-8':null;?>">
                        <div class="panel panel-default margin-top-lg">
                            <div class="panel-heading text-bold">
                                <i class="fa fa-shopping-cart margin-right-sm"></i> <?= lang('checkout'); ?>
                                <a href="<?= site_url('cart'); ?>" class="pull-right">
                                    <i class="fa fa-share"></i>
                                    <?= lang('back_to_cart'); ?>
                                </a>
                            </div>
                            <div class="panel-body">

                                <div>
                                <?php
                                if (!$this->loggedIn) {
                                    ?>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#user" aria-controls="user" role="tab" data-toggle="tab"><?= lang('returning_user'); ?></a></li>
<!--                                        <li role="presentation"><a href="#guest" aria-controls="guest" role="tab" data-toggle="tab">--><?//= lang('guest_checkout'); ?><!--</a></li>-->
                                    </ul>
                                    <?php
                                }
                                ?>

                                    <div class="tab-content <?=($mobile==FALSE)?'padding-lg':null;?>">
                                        <div role="tabpanel" class="tab-pane fade in active" id="user">
                                            <?php
                                            if ($this->loggedIn) {
//                                                $regions = $this->db->get_where('shipping_regions',['parent_id'=>'0'])->result();
                                                $sts = [];
                                                foreach($regions as $region){
                                                    $sts[$region->id] = ucfirst($region->region_name);
                                                }
                                                $istates =$sts;
                                                if (!empty($addresses)) {
                                                    echo shop_form_open('order', 'class="validate"');
                                                    echo '<div class="row">';
                                                    echo '<div class="col-sm-12 text-bold">' . lang('select_address') . '</div>';
                                                    $r = 1;
                                                    foreach ($addresses as $address) {
                                                        $region_ship_fee = $shipping_fees['reg_'.$address->region_id];
                                                        ?>
                                                        <div class="col-sm-6">
                                                            <div class="checkbox bg">
                                                                <label for="addr_<?=$address->id;?>" class="select-address" data-value="<?=$region_ship_fee;?>">
                                                                    <input type="radio" name="address" id="addr_<?=$address->id;?>" value="<?= $address->id; ?>" <?= $r == 1 ? 'checked' : ''; ?>>
                                                                    <span>
                                                                        <?= $address->line1; ?><br>
                                                                        <?= $address->line2; ?><br>
                                                                        <?= $address->city; ?> <br>
                                                                        <?= lang('phone') . ': ' . $address->phone; ?><br>
                                                                        <b><?=lang('Montant Livraison');?></b> : <?= $this->sma->formatMoney($region_ship_fee, $selected_currency->symbol); ?>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $r++;
                                                    }
                                                    echo '</div>';
                                                    ?>
                                                        <input type="hidden" id="shipping_fee" name="shipping_fee" required value="<?=$shipping_fees['reg_'.$addresses[0]->region_id];?>">
                                                    <?php
                                                }

                                                if (count($addresses) < 6 && !$this->Staff) {
                                                    echo '<div class="row margin-bottom-lg">';
                                                    echo '<div class="col-sm-12"><a href="#" id="add-address" class="btn btn-primary btn-sm">' . lang('add_new_address') . '</a></div>';
                                                    echo '</div>';
                                                }
                                                if ((isset($istates))) {
                                                    ?>
                                                <script>
                                                    var istates = <?= json_encode($istates); ?>
                                                </script>
                                                <?php
                                                } else {
                                                    echo '<script>var istates = false; </script>';
                                                } ?>
                                                <hr>
                                                <h5><strong><?= lang('choose_payment_method'); ?></strong></h5>
                                                <div class="checkbox bg">

                                                    <label style="display: inline-block; width: auto;">
                                                        <input type="radio" name="payment_method" value="onetime" id="onetime" required="required" checked>
                                                        <span>
                                                            <i class="fa fa-money margin-right-md"></i> <?= lang('onetime') ?>
                                                        </span>
                                                    </label>

                                                    <button type="button" class="choose_installment" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$condition;?>" style="display: inline-block; width: auto;">
                                                        <input type="radio" name="payment_method" value="installment" id="installment" required="required" data-toggle="tooltip" data-placement="top" title="test">
                                                        <span>
                                                            <i class="fa fa-align-justify margin-right-md"></i> <?= lang('installment') ?>
                                                        </span>
                                                    </button>

                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <?= lang('comment_any', 'comment'); ?>
                                                    <?= form_textarea('comment', set_value('comment'), 'class="form-control" id="comment" style="height:100px;"'); ?>
                                                </div>
                                                <?php
                                                if (!empty($addresses) && !$this->Staff) {
                                                    echo form_submit('add_order', lang('submit_order'), 'class="btn btn-theme" onclick="show_loader()"');
                                                } elseif ($this->Staff) {
                                                    echo '<div class="alert alert-warning margin-bottom-no">' . lang('staff_not_allowed') . '</div>';
                                                } else {
                                                    echo '<div class="alert alert-warning margin-bottom-no">' . lang('please_add_address_first') . '</div>';
                                                }
                                                echo form_close();
                                            } else {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="well margin-bottom-no">
                                                            <?php  include FCPATH . 'themes' . DIRECTORY_SEPARATOR . $Settings->theme . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'login_form.php'; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4 class="title"><span><?= lang('register_new_account'); ?></span></h4>
                                                        <p>
                                                            <?= lang('register_account_info'); ?>
                                                        </p>
                                                        <a href="<?= site_url('login#register'); ?>" class="btn btn-theme"><?= lang('register'); ?></a>
                                                        <a href="#" class="btn btn-default pull-right guest-checkout dis-none"><?= lang('guest_checkout'); ?></a>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="guest">
                                            <?= shop_form_open('order', 'class="validate" id="guest-checkout"'); ?>
                                            <input type="hidden" value="1" name="guest_checkout">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?= lang('name', 'name'); ?> *
                                                                <?= form_input('name', set_value('name'), 'class="form-control" id="name" required="required"'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 dis-none">
                                                            <div class="form-group">
                                                                <?= lang('company', 'company'); ?>
                                                                <?= form_input('company', 'Abapatrading', 'class="form-control" id="company"'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= lang('email', 'email'); ?> *
                                                        <?= form_input('text', set_value('email'), 'class="form-control" id="email" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= lang('phone', 'phone'); ?> *
                                                        <?= form_input('phone', set_value('phone'), 'class="form-control" onkeyup="$(\'#shipping_phone\').val($(this).val())" id="phone" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h5 class="dis-none"><strong><?= lang('billing_address'); ?></strong></h5>
                                                    <input type="hidden" value="new" name="address">
                                                    <hr>
                                                    <div class="form-group dis-none">
                                                        <?= lang('line1', 'billing_line1'); ?> *
                                                        <?= form_input('billing_line1','0123456789', 'class="form-control" id="billing_line1" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 dis-none">
                                                    <div class="form-group">
                                                        <?= lang('line2', 'billing_line2'); ?>
                                                        <?= form_input('billing_line2', '0123456789', 'class="form-control" id="billing_line2" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 dis-none">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?= lang('city', 'billing_city'); ?> *
                                                                <?= form_input('billing_city', 'kumasi', 'class="form-control" id="billing_city" required="required"'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 dis-none">
                                                            <div class="form-group">
                                                                <?= lang('postal_code', 'billing_postal_code'); ?>
                                                                <?= form_input('billing_postal_code', '00233', 'class="form-control" id="billing_postal_code"'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 dis-none">
                                                    <div class="form-group">
                                                        <?= lang('state', 'billing_state'); ?>
                                                        <?php
                                                        if ($Settings->indian_gst) {
                                                            $states = $this->gst->getIndianStates();
                                                            echo form_dropdown('billing_state', $states, '', 'class="form-control selectpicker mobile-device" id="billing_state" title="Select" required="required"');
                                                        } else {
                                                            echo form_input('billing_state', 'Ashanti Region', 'class="form-control" id="billing_state"');
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 dis-none">
                                                    <div class="form-group">
                                                        <?= lang('country', 'billing_country'); ?> *
                                                        <?= form_input('billing_country', 'Côte d’Ivoire.', 'class="form-control" id="billing_country" required="required"'); ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="checkbox bg pull-right dis-none" style="margin-top: 0; margin-bottom: 0;">
                                                        <label>
                                                            <input type="checkbox" name="same" value="1" id="same_as_billing">
                                                            <span>
                                                                <?= lang('same_as_billing') ?>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <h5><strong><?= lang('shipping_address'); ?></strong></h5>
                                                    <input type="hidden" value="new" name="address">
                                                    <div class="form-group">
                                                        <?= lang('line1', 'shipping_line1'); ?> *
                                                        <?= form_input('shipping_line1', set_value('shipping_line1'), 'class="form-control" onkeyup="$(\'#shipping_line2\').val($(this).val())" id="shipping_line1" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 dis-none">
                                                    <div class="form-group">
                                                        <?= lang('line2', 'shipping_line2'); ?>
                                                        <?= form_input('shipping_line2', '', 'class="form-control" id="shipping_line2" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?= lang('city', 'shipping_city'); ?> *
                                                                <?= form_input('shipping_city', set_value('shipping_city'), 'class="form-control" id="shipping_city" required="required"'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?= lang('postal_code', 'shipping_postal_code'); ?>
                                                                <?= form_input('shipping_postal_code', set_value('shipping_postal_code'), 'class="form-control" id="shipping_postal_code"'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= lang('Region', 'shipping_state'); ?>
                                                        <?php
                                                        if ($Settings->indian_gst) {
                                                            $states = $this->gst->getIndianStates();
                                                            echo form_dropdown('shipping_state', $states, '', 'class="form-control selectpicker mobile-device" id="shipping_state" title="Select" required="required"');
                                                        } else {
                                                            echo form_input('shipping_state', '', 'class="form-control" id="shipping_state"');
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 dis-none">
                                                    <div class="form-group">
                                                        <?= lang('country', 'shipping_country'); ?> *
                                                        <?= form_input('shipping_country', 'Côte d’Ivoire.', 'class="form-control" id="shipping_country" required="required"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?= lang('phone', 'shipping_phone'); ?> *
                                                        <?= form_input('shipping_phone', set_value('shipping_phone'), 'class="form-control" id="shipping_phone" required="required"'); ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5><strong><?= lang('payment_method'); ?></strong></h5>
                                                    <hr>
                                                    <div class="checkbox bg">
                                                        <label style="display: inline-block; width: auto;">
                                                            <input type="radio" name="payment_method" value="onetime" id="onetime" required="required" checked>
                                                            <span>
                                                            <i class="fa fa-money margin-right-md"></i> <?= lang('onetime') ?>
                                                        </span>
                                                        </label>

                                                        <button type="button" class="choose_installment" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$condition;?>" style="display: none; width: auto;">
                                                            <input type="radio" name="payment_method" value="installment" id="installment" required="required" data-toggle="tooltip" data-placement="top" title="test">
                                                            <span>
                                                            <i class="fa fa-align-justify margin-right-md"></i> <?= lang('installment') ?>
                                                        </span>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <?= form_submit('guest_order', lang('submit'), 'class="btn btn-lg btn-primary"'); ?>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div id="sticky-con" class="margin-top-lg">
                            <div class="panel panel-default">
                                <div class="panel-heading text-bold">
                                    <i class="fa fa-shopping-cart margin-right-sm"></i> <?= lang('totals'); ?>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $total     = $this->sma->convertMoney($this->cart->total(), false, false);
                                    $shipping  = $this->sma->convertMoney((!empty($address))?$shipping_fees['reg_'.$addresses[0]->region_id]:'0', false, false);
                                    $order_tax = $this->sma->convertMoney($this->cart->order_tax(), false, false);
                                    ?>
                                    <table class="table table-striped table-borderless cart-totals margin-bottom-no">
                                        <tr>
                                            <td><?= lang('total_w_o_tax'); ?></td>
                                            <td class="text-right"><?= $this->sma->convertMoney($this->cart->total() - $this->cart->total_item_tax()); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('product_tax'); ?></td>
                                            <td class="text-right"><?= $this->sma->convertMoney($this->cart->total_item_tax()); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('total'); ?></td>
                                            <td class="text-right"><?= $this->sma->formatMoney($total, $selected_currency->symbol); ?></td>
                                        </tr>
                                        <?php
                                        if ($Settings->tax2 !== false) {
                                        echo '<tr><td>' . lang('order_tax') . '</td><td class="text-right">' . $this->sma->formatMoney($order_tax, $selected_currency->symbol) . '</td></tr>';
                                    } ?>
                                        <tr>
                                            <td><?= lang('shipping'); ?> *</td>
                                            <td class="text-right" id="total_shipping"><?= $this->sma->formatMoney($shipping, $selected_currency->symbol); ?></td>
                                        </tr>
                                        <tr><td colspan="2"></td></tr>
                                        <tr class="active text-bold">
                                            <td><?= lang('grand_total'); ?></td>
                                            <?php
                                                $grand_total = $this->sma->formatDecimal($total) + $this->sma->formatDecimal($order_tax);
                                            ?>
                                            <td class="text-right" id="grand_total"><?= $this->sma->formatMoney($grand_total + $this->sma->formatDecimal($shipping), $selected_currency->symbol); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <code class="text-muted">* <?= lang('shipping_rate_info'); ?></code>
            </div>
        </div>
    </div>
</section>

<script>
    var reg_viless = false;
    var default_region_id = '<?=$default_region_id;?>';
    <?php if(!empty($reg_villes)):;?>
        reg_viless =<?=$reg_villes;?>;
    <?php endif;?>
    $(document).on('click','.choose_installment',{passive:true},function () {
        const installment_tag = '#installment';
        $(installment_tag).prop('checked',true);

        const html = $('.popover-content').text();
        $('.popover-content').html(html);


    });

    $(document).on('click','#onetime',{passive:true},function () {
            $('.popover.fade.top.in').remove();
    });

    $(document).on('click','#add-address',{passive:true},function () {
        setTimeout(function(){
            $('.filter-option').text('Region');
            $('#address-country').val('Côte d’Ivoire.');
            $('#address-country').parent().hide();
            $('#address-phone').parent().attr('class','form-group col-sm-6');

            $('#address-postal-code').val('+225');
            $('#address-postal-code').addClass('dis-none');
            $('#address-phone').parent().removeClass('col-sm-6');
            $('#address-phone').parent().addClass('col-sm-12');

        },300);
    });

    const grand_total = '<?=$grand_total;?>';
    $(document).on('click','.select-address',{passive:true},function () {
        const fee = parseFloat($(this).attr('data-value'));
        $('#shipping_fee').val(fee);
        $('#total_shipping').text('GHC '+fee+'.00');

        var total = parseFloat(grand_total);
        new_total = total+fee;

        $('#grand_total').text('GHC '+new_total+'.00');
    });
</script>