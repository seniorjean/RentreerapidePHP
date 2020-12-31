<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<?php $assets_url = base_url('themes/default/shop/assets/');
$show_symbol = false;
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('invoice') . ' ' . $inv->reference_no; ?></title>
    <link href="<?= base_url('themes/' . $Settings->theme . '/admin/assets/styles/pdf/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('themes/' . $Settings->theme . '/admin/assets/styles/pdf/pdf.css'); ?>" rel="stylesheet">
</head>

<body>
<?php

if (!empty($installment_orders)) {
    $pay_progress = 0;
    $total_paid = 0;
    $paid_count = 0;
    foreach ($installment_orders as $io) {
        $sale_id = $io['order_id'];

        for ($i = 1; $i <= 12; $i++) {
            $paid = (!empty($io['w' . $i])) ? $io['w' . $i] : 0;

            if ($paid > 0) {
                $paid_count++;
            }

            $total_paid += $paid;
        }


        $percentage_paid = round(($total_paid * 100) / (float)$io['total'], 2);
        $percentage_paid = ($percentage_paid > 100) ? 100 : $percentage_paid;
//            echo '<br>'.$total_paid.' : '.$percentage_paid.' % ';

        $pay_progress = $percentage_paid;
    }
}


?>
    <div id="wrap">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $path   = base_url() . 'assets/uploads/logos/' . $Settings->logo2;
                $type   = pathinfo($path, PATHINFO_EXTENSION);
                $data   = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
                <div class="text-center">
                    <img src="<?= $base64; ?>" alt="<?=$customer->name; ?>" class="bcimg">
                    <h2 style="margin: 0;"><?=$customer->name; ?></h2>
                    <?=$biller->name ?>
                    <?php
                    echo $biller->address . ' ' . $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state . ' ' . $biller->country;
                    if ($biller->vat_no != '-' && $biller->vat_no != '') {
                        echo '<br>' . lang('vat_no') . ': ' . $biller->vat_no;
                    }
                    if ($biller->cf1 != '-' && $biller->cf1 != '') {
                        echo '<br>' . lang('bcf1') . ': ' . $biller->cf1;
                    }
                    if ($biller->cf2 != '-' && $biller->cf2 != '') {
                        echo '<br>' . lang('bcf2') . ': ' . $biller->cf2;
                    }
                    if ($biller->cf3 != '-' && $biller->cf3 != '') {
                        echo '<br>' . lang('bcf3') . ': ' . $biller->cf3;
                    }
                    if ($biller->cf4 != '-' && $biller->cf4 != '') {
                        echo '<br>' . lang('bcf4') . ': ' . $biller->cf4;
                    }
                    if ($biller->cf5 != '-' && $biller->cf5 != '') {
                        echo '<br>' . lang('bcf5') . ': ' . $biller->cf5;
                    }
                    if ($biller->cf6 != '-' && $biller->cf6 != '') {
                        echo '<br>' . lang('bcf6') . ': ' . $biller->cf6;
                    }
                    echo '<br>' . lang('tel') . ': ' . $biller->phone . ' ' . lang('email') . ': ' . $biller->email;
                    ?>
                    <hr>
                </div>
                <div class="clearfix"></div>

                <div class="padding10">

                    <div class="col-xs-5">
                        <?php echo $this->lang->line('to'); ?>:<br/>
                        <h2 class=""><?=$customer->name;?></h2>
                        <?= $customer->company ? '' : 'Attn: ' . $customer->name ?>
                        <?php
                        echo $customer->address . '<br />' . $customer->city . ' ' . $customer->postal_code . ' ' . $customer->state . '<br />' . $customer->country;
                        if ($customer->vat_no != '-' && $customer->vat_no != '') {
                            echo '<br>' . lang('vat_no') . ': ' . $customer->vat_no;
                        }
                        if ($customer->cf1 != '-' && $customer->cf1 != '') {
                            echo '<br>' . lang('ccf1') . ': ' . $customer->cf1;
                        }
                        if ($customer->cf2 != '-' && $customer->cf2 != '') {
                            echo '<br>' . lang('ccf2') . ': ' . $customer->cf2;
                        }
                        if ($customer->cf3 != '-' && $customer->cf3 != '') {
                            echo '<br>' . lang('ccf3') . ': ' . $customer->cf3;
                        }
                        if ($customer->cf4 != '-' && $customer->cf4 != '') {
                            echo '<br>' . lang('ccf4') . ': ' . $customer->cf4;
                        }
                        if ($customer->cf5 != '-' && $customer->cf5 != '') {
                            echo '<br>' . lang('ccf5') . ': ' . $customer->cf5;
                        }
                        if ($customer->cf6 != '-' && $customer->cf6 != '') {
                            echo '<br>' . lang('scf6') . ': ' . $customer->cf6;
                        }
                        echo '<br>' . lang('tel') . ': ' . $customer->phone . '<br />' . lang('email') . ': ' . $customer->email;
                        ?>

                    </div>

                    <div class="col-xs-5 pull-right">
                        <div class="well well-sm">
                            <h1 class="text-center title" style="margin: 0;"><?= lang('invoice'); ?></h1>
                            <table style="margin-bottom: 10px;">
                                <tr>
                                    <td><?= lang('ref'); ?> </td>
                                    <td>: <strong><?= $inv->reference_no; ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?= lang('date'); ?></td>
                                    <td>: <strong><?= $this->sma->hrld($inv->date); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?= lang('sale_status'); ?></td>
                                    <td>: <strong><?= lang($inv->sale_status); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><?= lang('payment_status'); ?></td>
                                    <td>: <strong><?= lang($inv->payment_status); ?></strong></td>
                                </tr>
                            </table>
                            <div class="text-center order_barcodes">
                                <?php
                                $path   = admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1');
                                $type   = $Settings->barcode_img ? 'png' : 'svg+xml';
                                $data   = file_get_contents($path);
                                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                ?>
                                <img src="<?= $base64; ?>" alt="<?= $inv->reference_no; ?>" class="bcimg" />
                                <?php /*echo $this->sma->qrcode('link', urlencode(admin_url('transfers/view/' . $inv->id)), 2);*/ ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <div class="clearfix" style="margin-bottom:5px;"></div>

                <div class="col-xs-12">
                    <div class="table-responsive">
                        <?php
                        $col = $Settings->indian_gst ? 5 : 4;
                        if ($Settings->product_discount && $inv->product_discount != 0) {
                            $col++;
                        }
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            $col++;
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                            $tcol = $col - 2;
                        } elseif ($Settings->product_discount && $inv->product_discount != 0) {
                            $tcol = $col - 1;
                        } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                            $tcol = $col - 1;
                        } else {
                            $tcol = $col;
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped print-table order-table">

                                <thead>

                                <tr>
                                    <th><?= lang('no'); ?></th>
                                    <th><?=lang('image')?></th>
                                    <th><?= lang('description'); ?></th>
                                    <?php if ($Settings->indian_gst) {
                                        ?>
                                        <th><?= lang('hsn_code'); ?></th>
                                        <?php
                                    } ?>
                                    <th><?= lang('quantity'); ?></th>
                                    <th><?= lang('unit_price'); ?></th>
                                    <?php
                                    if ($Settings->tax1 && $inv->product_tax > 0) {
                                        echo '<th>' . lang('tax') . '</th>';
                                    }
                                    if ($Settings->product_discount && $inv->product_discount != 0) {
                                        echo '<th>' . lang('discount') . '</th>';
                                    }
                                    ?>
                                    <th><?= lang('subtotal'); ?></th>
                                </tr>

                                </thead>

                                <tbody>

                                <?php $r = 1;
                                $tax_summary = [];
                                foreach ($rows as $row):
                                    ?>
                                    <tr>
                                        <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                        <td style="text-align:center; width:40px; vertical-align:middle;">

                                            <?php
                                            $path   = productImage($row->image) ;
                                            $type   = pathinfo($path, PATHINFO_EXTENSION);
                                            $data   = file_get_contents($path);
                                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            ?>

                                            <img class="img-thumbnail preview" width="40px" height="40px" style="width: 40px; height: 40px" alt="<?=$row->image;?>" src="<?=$base64?>">
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                            <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                                            <?= $row->details ? '<br>' . $row->details : ''; ?>
                                            <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                                        </td>
                                        <?php if ($Settings->indian_gst) {
                                            ?>
                                            <td style="width: 85px; text-align:center; vertical-align:middle;"><?= $row->hsn_code; ?></td>
                                            <?php
                                        } ?>
                                        <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity); ?></td>
                                        <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price); ?></td>
                                        <?php
                                        if ($Settings->tax1 && $inv->product_tax > 0) {
                                            echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                        }
                                        if ($Settings->product_discount && $inv->product_discount != 0) {
                                            echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                        }
                                        ?>
                                        <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                                    </tr>
                                    <?php
                                    $r++;
                                endforeach;
                                if ($return_rows) {
                                    echo '<tr class="warning"><td colspan="100%" class="no-border"><strong>' . lang('returned_items') . '</strong></td></tr>';
                                    foreach ($return_rows as $row):
                                        ?>
                                        <tr class="warning">
                                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                            <td style="vertical-align:middle;">
                                                <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                                                <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                                            </td>
                                            <?php if ($Settings->indian_gst) {
                                                ?>
                                                <td style="width: 85px; text-align:center; vertical-align:middle;"><?= $row->hsn_code; ?></td>
                                                <?php
                                            } ?>
                                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->quantity) . ' ' . $row->product_unit_code; ?></td>
                                            <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price); ?></td>
                                            <?php
                                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                            }
                                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                            } ?>
                                            <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                                        </tr>
                                        <?php
                                        $r++;
                                    endforeach;
                                }
                                ?>
                                </tbody>

                                <tfoot>
                                <?php
                                $col = $Settings->indian_gst ? 6 : 5;
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    $col++;
                                }
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    $col++;
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                                    $tcol = $col - 2;
                                } elseif ($Settings->product_discount && $inv->product_discount != 0) {
                                    $tcol = $col - 1;
                                } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                                    $tcol = $col - 1;
                                } else {
                                    $tcol = $col;
                                }
                                ?>
                                <?php if ($inv->grand_total != $inv->total) {
                                    ?>
                                    <tr>
                                        <td colspan="<?= $tcol; ?>"
                                            style="text-align:right; padding-right:10px;"><?= lang('Total_item_Cost'); ?>
                                            <?=($show_symbol)?'('.$this->Settings->symbol.')':null?>
                                        </td>
                                        <?php
                                        if ($Settings->tax1 && $inv->product_tax > 0) {
                                            echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_tax + $return_sale->product_tax) : $inv->product_tax) . '</td>';
                                        }
                                        if ($Settings->product_discount && $inv->product_discount != 0) {
                                            echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_discount + $return_sale->product_discount) : $inv->product_discount) . '</td>';
                                        } ?>
                                        <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                                    </tr>
                                    <?php
                                } ?>
                                <?php if ($Settings->indian_gst) {
                                    if ($inv->cgst > 0) {
                                        $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst;
                                        echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px; font-weight:bold;">' . lang('cgst'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px; font-weight:bold;">' . ($Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst) . '</td></tr>';
                                    }
                                    if ($inv->sgst > 0) {
                                        $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst;
                                        echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px; font-weight:bold;">' . lang('sgst'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px; font-weight:bold;">' . ($Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst) . '</td></tr>';
                                    }
                                    if ($inv->igst > 0) {
                                        $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst;
                                        echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px; font-weight:bold;">' . lang('igst'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px; font-weight:bold;">' . ($Settings->format_gst ? $this->sma->formatMoney($igst) : $igst) . '</td></tr>';
                                    }
                                } ?>
                                <?php
                                if ($return_sale) {
                                    echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang('return_total'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_sale->grand_total) . '</td></tr>';
                                }
                                if ($inv->surcharge != 0) {
                                    echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang('return_surcharge'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
                                }
                                ?>
                                <?php if ($inv->order_discount != 0) {
                                    echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang('order_discount'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . ($inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</td></tr>';
                                }
                                ?>
                                <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                                    echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;">' . lang('order_tax'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</td></tr>';
                                }
                                ?>
                                <?php if ($inv->shipping != 0) {
                                    echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang('Delivery_fee'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';

                                    if($payment_method =='installment'){
                                        echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang('Installment_fee'). (($show_symbol)?'('.$this->Settings->symbol:null).'</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($grand_total - ($total_item_cost+$inv->shipping)) . '</td></tr>';
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="<?= $col; ?>"
                                        style="text-align:right; font-weight:bold;"><?= lang('total'); ?>
                                        <?=($show_symbol)?'('.$this->Settings->symbol.')':null?>
                                    </td>
                                    <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="<?= $col; ?>"
                                        style="text-align:right; font-weight:bold;"><?= lang('paid'); ?>
                                        <?php if ($payment_method == 'installment'):; ?>
                                            (<?= $pay_progress ?> %) <span class="margin-left-sm"><?= $paid_count ?> /<?= $installment_orders[0]['num_of_week']; ?></span>
                                        <?php else : ; ?>
                                            <?=($show_symbol)?'('.$this->Settings->symbol.')':null?>
                                        <?php endif; ?>

                                    </td>
                                    <td style="text-align:right; font-weight:bold;">
                                        <?=$this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="<?= $col; ?>"
                                        style="text-align:right; font-weight:bold;"><?= lang('balance'); ?>
                                        <?=($show_symbol)?'('.$this->Settings->symbol.')':null?>
                                    </td>
                                    <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney(($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></td>
                                </tr>

                                <tr>
                                    <td colspan="<?=$col;?>"  style="text-align:right; font-weight:bold;"><?=lang('payment_method');?></td>
                                    <td style="text-align:right; font-weight:bold; color: black !important;">
                                        <?=lang($payment_method);?>
                                    </td>
                                </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>


                <div class="col-xs-12">
                    <?php if ($inv->note || $inv->note != '') {
                                    ?>
                    <div class="well well-sm">
                        <p class="bold"><?= lang('note'); ?>:</p>

                        <div><?= $this->sma->decode_html($inv->note); ?></div>
                    </div>
                    <?php
                                } ?>
                    <?php
                    if (!empty($shop_settings->bank_details)) {
                        echo '<div class="well well-sm">' . str_replace('link', '<a href="' . shop_url('orders/' . $inv->id . '/' . $inv->hash) . '">link</a>', $shop_settings->bank_details) . '</div>';
                    }
                    ?>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</body>
</html>
