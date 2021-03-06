<script>
    "use strict";
    const pagination_next_button = '#pagination a[rel="next"]';
    var can_add_content = 0;
    var empty_result = true;
    var current_position = null;
    function sa_img(t, e) {
        swal({title: t, html: e, type: "success", confirmButtonText: "Ok"}).catch(swal.noop)
    }

    function prepare_result_area(){
        if(empty_result){$("#results").empty()};
    }

    function update_cart_item(t, e, s, a, i) {
        $.ajax({
            url: t, type: "POST", data: e, success: function (t) {
                t.error ? ("text" == i ? a.val(s) : a.selectpicker("val", $po), sa_alert("Error!", t.message, "error", !0)) : (t.cart && (cart = t.cart, update_mini_cart(cart), update_cart(cart)), sa_alert(t.status, t.message))
            }, error: function () {
                sa_alert("Error!", "Ajax call failed, please try again or contact site owner.", "error", !0)
            }
        })
    }
    function sticky_con() {
        get_width() > 767 ? ($("#sticky-con").stick_in_parent({parent: $(".container")}), $("#sticky-con").on("sticky_kit:bottom", function (t) {
            $(this).parent().css("position", "static")
        }).on("sticky_kit:unbottom", function (t) {
            $(this).parent().css("position", "relative")
        })) : $("#sticky-con").trigger("sticky_kit:detach")
    }
    function sticky_footer() {
        $("body").css("padding-bottom", $(".footer").height())
    }
    function get_width() {
        return $(window).width()
    }
    function loading(t) {
        $("#loading").show(), setTimeout(function () {
            $("#loading").hide()
        }, t)
    }
    function get(t) {
        return "undefined" != typeof Storage ? localStorage.getItem(t) : void alert("Please use a modern browser as this site needs localstroage!")
    }
    function store(t, e) {
        "undefined" != typeof Storage ? localStorage.setItem(t, e) : alert("Please use a modern browser as this site needs localstroage!")
    }
    function remove(t) {
        "undefined" != typeof Storage ? localStorage.removeItem(t) : alert("Please use a modern browser as this site needs localstroage!")
    }
    function gen_html(t) {
        var e = "";
        if (get_width() > 992)var s = get("shop_grid"), a = ".three-col" == s ? 3 : 2; else var s = ".three-col", a = 2;
        var i = s && ".three-col" == s ? "col-sm-6 col-md-4" : "col-md-6", o = s && ".three-col" == s ? "alt" : "";
        if (t || (e += '<div class="col-sm-12"><div class="alert alert-warning text-center padding-xl margin-top-lg"><h4 class="margin-bottom-no">' + lang.x_product + "</h4></div></div>"), 1 == site.settings.products_page && (prepare_result_area(), $(".grid").isotope("destroy").isotope()), $.each(t, function (s, r) {
                var n = r.special_price ? r.special_price : r.price,
                    l = r.special_price ? r.formated_special_price : r.formated_price,
                    c = (r.promotion && r.promo_price && 0 != r.promo_price ? r.promo_price : n, r.promotion && r.promo_price && 0 != r.promo_price ? r.formated_promo_price : l);
                1 != site.settings.products_page && (0 === s ? e += '<div class="row">' : s % a === 0 && (e += '</div><div class="row">')), e += '<div class="product-container ' + i + " " + (1 == site.settings.products_page ? "grid-item" : "") + '">\n        <div class="product ' + o + " " + (1 == site.settings.products_page ? "grid-sizer" : "") + '">\n    <span class="badge badge-left blue '+libName(r.warehouse_name)+'">'+r.warehouse_name+'</span>    ' + (r.promo_price ? '<span class="badge badge-right green">'+discount(r.price , r.promo_price)+' %</span>' : "") + '\n        <div class="product-top">\n        <div class="product-image">\n        <a href="' + site.site_url + "product/" + r.slug + '">\n        <img class="img-responsive lazy" data-src="' + productImage(r.image) + '" alt=""/>\n        </a>\n        </div>\n        <div class="product-desc">\n        <a href="' + site.site_url + "product/" + r.slug + '">\n        <h2 class="product-name">' + r.name + "</h2>\n        </a>\n        <p>" + limit_string(r.details,30) + '</p>\n        </div>\n        </div>\n        <div class="clearfix"></div>\n        ' + (1 == site.shop_settings.hide_price ? "" : '\n        <div class="product-bottom">\n        <div class="product-price">\n        ' + (r.promo_price ? '<del class="text-danger text-size-sm">' + l + "</del>" : "") + "\n        " + c + '\n        </div>\n        <div class="product-rating '+((!dis_qty_ajuster)?'dis-none':'')+'">\n        <div class="form-group" style="margin-bottom:0;">\n        <div class="input-group">\n        <span class="input-group-addon pointer btn-minus"><span class="fa fa-minus"></span></span>\n        <input type="text" name="quantity" class="form-control text-center quantity-input" value="1" required="required">\n        <span class="input-group-addon pointer btn-plus"><span class="fa fa-plus"></span></span>\n        </div>\n        </div>\n        </div>\n        <div class="clearfix"></div>\n        <div class="product-cart-button">\n        <div class="btn-group" role="group" aria-label="...">\n        ' +
                        '<div class="row">' +
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Ajouter au panier" class="col-sm-3 btn btn-link text-warning add-to-cart" data-id="' + r.id + '"><i class="fa fa-shopping-basket padding-right-md"></i></a>' +
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Comparer" class="col-sm-3 btn btn-link text-warning compare-product" data-id="' + r.id + '"><i class="fas fa-exchange-alt"></i></a>' +
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Ajouter aux shouhaits" class="col-sm-3 btn btn-link text-warning add-to-wishlist" data-id="' + r.id + '"><i class="fa fa-heart"></i></a>\n        ' +
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Aperçu rapide" class="col-sm-3 btn btn-link text-warning quick-preview" data-id="' + r.id + '"><i class="fas fa-eye"></i></a>\n        ' +
                        '</div>' +
                        '\n        </div>\n        </div>\n        <div class="clearfix"></div>\n        </div>') + '\n        </div>\n        <div class="clearfix"></div>\n        </div>', 1 != site.settings.products_page && s + 1 === t.length && (e += "</div>")
            }), 1 != site.settings.products_page) prepare_result_area(), $(e).appendTo($("#results"));
        else {
            var r = $(e);
            $(".grid").isotope("insert", r).isotope("layout"), setTimeout(function () {
                $(".grid").isotope({itemSelector: ".grid-item"})
            }, 200);
        }

        init_lazy_load();
        if(current_position !== null){
            can_add_content = false;
            $('body,html').animate({scrollTop:current_position},0);
            current_position = null;
            setTimeout(function(){
                can_add_content = true;
            },1000);
            if($(pagination_next_button).length === 0){
                $('.footer').show('slow');
            }
        }
        if(can_add_content === 0){
            can_add_content = true;
        }

        enable_tooltip();
    }
    function searchProducts() {
        if(current_position === null){
            empty_result = true;
            filters.page = 1;
        }
        $("#loading").show();
        var t = {};
        t[site.csrf_token] = site.csrf_token_value, t.filters = get_filters(), t.format = "json", $.ajax({
            url: site.shop_url + "search?page=" + filters.page,
            type: "POST",
            data: t,
            dataType: "json"
        }).done(function (t) {
            products = t.products, $(".page-info").empty(), $("#pagination").empty(), t.products && (t.pagination && $("#pagination").html(t.pagination), t.info && $(".page-info").text(lang.page_info.replace("_page_", t.info.page).replace("_total_", t.info.total))), gen_html(products)
        }).always(function () {
            $("#loading").hide()
        })
    }
    function get_filters() {
        return filters.category = $("#product-category").val() ? $("#product-category").val() : filters.category, filters.min_price = $("#min-price").val(), filters.max_price = $("#max-price").val(), filters.in_stock = $("#in-stock").is(":checked") ? 1 : 0, filters.promo = $("#promotions").is(":checked") ? "yes" : 0, filters.featured = $("#featured").is(":checked") ? "yes" : 0, filters.sorting = get("sorting"), filters
    }
    function update_mini_cart(t) {
        if (t.total_items && t.total_items > 0) {
            $(".cart-total-items").text(t.total_items + " " + (t.total_items > 1 ? lang.items : lang.item)), $("#cart-items").empty(), $.each(t.contents, function () {
                var t = '<td><a href="' + site.site_url + "/product/" + this.slug + '"><span class="cart-item-image"><img src="' + productImage(this.image) + '" alt=""></span></a></td><td><a href="' + site.site_url + "/product/" + this.slug + '">' + this.name + "</a><br>" + this.qty + " x " + this.price + '</td><td class="text-right text-bold">' + this.subtotal + "</td>";
                $("<tr>" + t + "</tr>").appendTo("#cart-items")
            });
            var e = '\n        <tr class="text-bold"><td colspan="2">' + lang.total_items + '</td><td class="text-right">' + t.total_items + '</td></tr>\n        <tr class="text-bold"><td colspan="2">' + lang.total + '</td><td class="text-right">' + t.total + "</td></tr>\n        ";
            $("<tfoot>" + e + "</tfoot>").appendTo("#cart-items"), $("#cart-empty").hide(), $("#cart-contents").show()
        } else $(".cart-total-items").text(lang.cart_empty), $("#cart-contents").hide(), $("#cart-empty").show()
    }
    function update_cart(t) {
        if (t.total_items && t.total_items > 0) {
            $("#cart-table tbody").empty();
            var e = 1;
            $.each(t.contents, function () {
                var t = this,
                    s = '\n            <td class="text-center">\n            <a href="#" class="text-red remove-item" data-rowid="' + this.rowid + '"><i class="fa fa-trash"></i><a>\n            </td>\n            <td><input type="hidden" name="' + e + '[rowid]" value="' + this.rowid + '">' + e + '</td>\n            <td>\n            <a href="' + site.site_url + "/product/" + this.slug + '"><span class="cart-item-image pull-right"><img src="' + productImage(this.image) + '" alt=""></span></a>\n            </td>\n            <td><a href="' + site.site_url + "/product/" + this.slug + '">' + this.name + "</a></td>\n            <td>";
                this.options && (s += '<select name="' + e + '[option]" class="selectpicker cart-item-option" data-width="100%" data-style="btn-default">', $.each(this.options, function () {
                    s += '<option value="' + this.id + '" ' + (this.id == t.option ? "selected" : "") + ">" + this.name + " " + (0 != parseFloat(this.price) ? "(+" + this.price + ")" : "") + "</option>"
                }), s += "</select>"), s += '</td>\n            <td><input type="text" name="' + e + '[qty]" class="form-control text-center input-qty cart-item-qty" value="' + this.qty + '"></td>\n            <td class="text-right">' + this.price + '</td>\n            <td class="text-right">' + this.subtotal + "</td>\n            ", e++, $('<tr id="' + this.rowid + '">' + s + "</tr>").appendTo("#cart-table tbody")
            }), $("#cart-totals").empty();
            var s = "<tr><td>" + lang.total_w_o_tax + '</td><td class="text-right">' + t.subtotal + "</td></tr>";
            s += "<tr><td>" + lang.product_tax + '</td><td class="text-right">' + t.total_item_tax + "</td></tr>", s += "<tr><td>" + lang.total + '</td><td class="text-right">' + t.total + "</td></tr>", site.settings.tax2 !== !1 && (s += "<tr><td>" + lang.order_tax + '</td><td class="text-right">' + t.order_tax + "</td></tr>"), s += "<tr><td>" + lang.shipping + ' *</td><td class="text-right">' + t.shipping + "</td></tr>", s += '<tr><td colspan="2"></td></tr>', s += '<tr class="active text-bold"><td>' + lang.grand_total + '</td><td class="text-right">' + t.grand_total + "</td></tr>", $("<tbody>" + s + "</tbody>").appendTo("#cart-totals"), $("#total-items").text(t.total_items + "(" + t.total_unique_items + ")"), $(".cart-item-option").selectpicker("refresh"), $(".cart-empty-msg").hide(), $(".cart-contents").show()
        } else $("#total-items").text(t.total_items), $(".cart-contents").hide(), $(".cart-empty-msg").show()
    }
    function formatMoney(t, e) {
        if (e || (e = site.settings.symbol), 1 == site.settings.sac)return (1 == site.settings.display_symbol ? e : "") + "" + formatSA(parseFloat(t).toFixed(site.settings.decimals)) + (2 == site.settings.display_symbol ? e : "");
        var s = accounting.formatMoney(t, e, site.settings.decimals, 0 == site.settings.thousands_sep ? " " : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
        return (1 == site.settings.display_symbol ? e : "") + s + (2 == site.settings.display_symbol ? e : "")
    }
    function formatSA(t) {
        t = t.toString();
        var e = "";
        t.indexOf(".") > 0 && (e = t.substring(t.indexOf("."), t.length)), t = Math.floor(t), t = t.toString();
        var s = t.substring(t.length - 3), a = t.substring(0, t.length - 3);
        "" != a && (s = "," + s);
        var i = a.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + s + e;
        return i
    }
    function sa_alert(title, html, icon, time) {
        icon = icon || "success", time = time || 2000, swal.fire({
            title: title,
            html: html,
            icon: icon,
            timer: time,
            confirmButtonText: "Ok"
        });
    }
    function saa_alert(t, e, s, a) {
        s = s || "delete", e = e || "Cette action est irréversible.", a = a || {}, a._method = s, a[site.csrf_token] = site.csrf_token_value;

       const callback = function () {
            return new Promise(function () {
                $.ajax({
                    url: t, type: "POST", data: a, success: function (t) {
                        return t.redirect ? (window.location.href = t.redirect, !1) : (t.cart && (cart = t.cart, update_mini_cart(cart), update_cart(cart)), void sa_alert(t.status, t.message))
                    }, error: function () {
                        sa_alert("Error!", "Ajax call failed, please try again or contact site owner.", "error", !0)
                    }
                })
            })
        };

        swal_confirm("Etre vous sûre?" , e, {yes:callback});
    }
    function prompt(t, e, s) {
        t = t || "Reset Password", e = e || "Please type your email address", s = s || {}, s[site.csrf_token] = site.csrf_token_value, swal({
            title: t,
            html: e,
            input: "email",
            showCancelButton: !0,
            allowOutsideClick: !1,
            showLoaderOnConfirm: !0,
            confirmButtonText: lang.submit,
            preConfirm: function (t) {
                return s.email = t, new Promise(function (t, e) {
                    $.ajax({
                        url: site.base_url + "forgot_password", type: "POST", data: s, success: function (s) {
                            s.status ? t(s) : e(s)
                        }, error: function () {
                            sa_alert("Error!", "Ajax call failed, please try again or contact site owner.", "error", !0)
                        }
                    })
                })
            }
        }).then(function (t) {
            sa_alert(t.status, t.message)
        })
    }

    $(document).on('change','.selectpickerstate',{passive:true},function () {
        const value     =  $(this).val();
        const e = getRegionCity(value);
        $('#region_ville').html(e);
        $('.select').selectpicker({size:5});
    });

    function getRegionCity(region_id , t){
        var t = t || {};
        var e = '<input name="city" value="' + (t.city ? t.city : "") + '" id="address-city" class="form-control" placeholder="Ville">';
        if(reg_viless){
            const villes    = reg_viless[region_id];
            console.log(villes);
            if (typeof villes.length !== 'number') {
                var s = document.createElement("select");
                s.id = "address-city", s.name = "city", s.className = "select form-control mobile-device", s.setAttribute("data-live-search", !0);
                var a = Object.keys(villes);
                var cc = 1;
                a.map(function (x) {
                    if (0 != x) {
                        var e = document.createElement("option");
                        e.value = x, e.text = villes[x], s.appendChild(e);
                        if(t.region_id){
                            if(x === t.region_id){
                                e.setAttribute("selected","selected");
                            }
                        }
                        else{
                            if(cc === 1){
                                e.setAttribute("selected","selected");
                            }
                        }
                        cc++;
                    }
                }), e = s.outerHTML
            };
        }
        return e;
    }

    function add_address(t){

        t = t || {};
        var x = t;
        var e = "";
        if (istates) {
            var s = document.createElement("select");
            s.id = "address-state", s.name = "state", s.className = "selectpickerstate mobile-device", s.setAttribute("data-live-search", !0), s.setAttribute("title", "Région");
            var a = Object.keys(istates);
            a.map(function (t) {
                if (0 != t) {
                    var e = document.createElement("option");
                    e.value = t, e.text = istates[t], s.appendChild(e);
                    if(x.state === t){
                            e.setAttribute("selected","selected");
                    }
                }
            }), e = s.outerHTML
        } else e = '<input name="state" value="' + (t.state ? t.state : "") + '" id="address-state" class="form-control" placeholder="Région">';
        var v = getRegionCity((t.state?t.state : default_region_id) , t);
        const html = '<span class="text-bold padding-bottom-md">' + lang.fill_form + '</span>' +
            '<hr class="swal2-spacer padding-bottom-xs" style="display: block;">' +
            '<form action="' + site.shop_url + 'address" id="address-form" class="padding-bottom-md">' +
            '<input type="hidden" name="' + site.csrf_token + '" value="' + site.csrf_token_value + '">' +
            '<div class="row">' +
                '<div class="form-group col-sm-12">' +
                '   <input name="line1" id="address-line-1" value="' + (t.line1 ? t.line1 : "") + '" class="form-control" placeholder="Ligne 1">' +
                '</div>' +
            '</div>' +

            '<div class="row">' +
                '<div class="form-group col-sm-12">' +
                    '<input name="line2" id="address-line-2" value="' + (t.line2 ? t.line2 : "") + '" class="form-control" placeholder="Ligne 2">' +
                '</div>' +
            '</div>' +

            '<div class="row">' +
                '<div class="form-group col-sm-6" id="istates">' + e + '' + '</div>' +
                '<div class="form-group col-sm-6" id="region_ville">' +
                ''+v+'' +
                '</div>' +
                '<div class="form-group col-sm-6">' +
                '<input name="postal_code" value="' + (t.postal_code ? t.postal_code : "") + '" id="address-postal-code" class="form-control" placeholder="Postal Code">' +
                '</div>' +
                '<div class="form-group col-sm-6">' +
                    '<input name="country" value="Cote d’Ivoire " id="address-country" class="form-control" placeholder="Country">' +
                '</div>' +
                '<div class="form-group col-sm-12 margin-bottom-no">' +
                    '<input name="phone" value="' + (t.phone ? t.phone : "") + '" id="address-phone" class="form-control" placeholder="Phone">' +
                '</div>' +
            '</div>'+
        '</form>';

        Swal.fire({
            title: t.id ? lang.update_address : lang.add_address,
            html: html,
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: lang.submit,
            cancelButtonText: lang.cancel,
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            onOpen: function () {
                if ($("#address-line-1").val(t.line1 ? t.line1 : "").focus(), /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) $(".selectpickerstate").selectpicker({modile: !0}), $(".selectpickerstate").selectpicker("val", t.state ? t.state : ""); else {
                    for (var e = document.querySelectorAll(".mobile-device"), s = 0; s < e.length; s++)e[s].classList.remove("mobile-device");
                    setTimeout(function(){
                        $(".selectpickerstate").selectpicker({size: 5}),
                        $(".selectpickerstate").selectpicker("val", t.state ? t.state : "");
                    },300);
                }
            },
            preConfirm: (ee) => {
                function e(message){
                    Swal.showValidationMessage(message);
                }

                return new Promise(function (t, e) {
                    $("#address-line-1").val() || e("ligne 1 est obligatoire"),
                    $("#address-city").val() || e("Ville est obligatoire"),
                    $("#address-state").val() || e("Region est obligatoire"),
                    $("#address-country").val() || e("Pays est obligatoire"),
                    $("#address-phone").val() || e("Téléphone est obligatoire"),
                    t();
                }).then(t, e);
            },

        }).then((result) => {
           if(result.value){
               var s = $("#address-form");
               $.ajax({
                   url: s.attr("action") + (t.id ? "/" + t.id : ""),
                   type: "POST",
                   data: s.serialize(),
                   success: function (t) {
                       return t.redirect ? (window.location.href = t.redirect, !1) : void sa_alert(t.status, t.message, t.level)
                   },
                   error: function () {
                       sa_alert("Error!", "Ajax call failed, please try again or contact site owner.", "error", !0)
                   }
               })
           }
        }).catch()
    }
    function email_form() {
        swal({
            title: lang.send_email_title,
            html: '<div><span class="text-bold padding-bottom-md">' + lang.fill_form + '</span><hr class="swal2-spacer padding-bottom-xs" style="display: block;"><form action="' + site.shop_url + 'send_message" id="message-form" class="padding-bottom-md"><input type="hidden" name="' + site.csrf_token + '" value="' + site.csrf_token_value + '"><div class="row"><div class="form-group col-sm-12"><input type="text" name="name" id="form-name" value="" class="form-control" placeholder="Full Name"></div></div><div class="row"><div class="form-group col-sm-12"><input type="email" name="email" id="form-email" value="" class="form-control" placeholder="Email"></div></div><div class="row"><div class="form-group col-sm-12"><input type="text" name="subject" id="form-subject" value="" class="form-control" placeholder="Subject"></div></div><div class="row"><div class="col-sm-12"><textarea name="message" id="form-message" class="form-control" placeholder="Message" style="height:100px;"></textarea></div></div></form></div>',
            showCancelButton: !0,
            allowOutsideClick: !1,
            confirmButtonText: lang.submit,
            preConfirm: function () {
                return new Promise(function (t, e) {
                    $("#form-name").val() || e("Name is required"), $("#form-email").val() || e("Email is required"), $("#form-subject").val() || e("Subject is required"), $("#form-message").val() || e("Message is required"), validateEmail($("#form-email").val()) || e("Email is invalid"), t()
                })
            },
            onOpen: function () {
                $("#form-name").focus()
            }
        }).then(function (t) {
            var e = $("#message-form");
            $.ajax({
                url: e.attr("action"), type: "POST", data: e.serialize(), success: function (t) {
                    return t.redirect ? (window.location.href = t.redirect, !1) : void sa_alert(t.status, t.message, t.level, !0)
                }, error: function () {
                    sa_alert("Error!", "Ajax call failed, please try again or contact site owner.", "error", !0)
                }
            })
        }).catch(swal.noop)
    }
    function validateEmail(t) {
        var e = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return e.test(t)
    }
    $(function () {
        if ($(document).on("click", ".add-to-cart", function (t) {
                t.preventDefault();
                var e = $(this).attr("data-id"), s = $(".shopping-cart:visible"),
                    a = $(this).parents(".product-bottom").find(".quantity-input"),
                    i = $(this).parents(".product").find("img").eq(0);
                if (i) {
                    var o = i.clone().offset({top: i.offset().top, left: i.offset().left}).css({
                        opacity: "0.5",
                        position: "absolute",
                        height: "150px",
                        width: "150px",
                        "z-index": "1000"
                    }).appendTo($("body")).animate({
                        top: s.offset().top + 10,
                        left: s.offset().left + 10,
                        width: "50px",
                        height: "50px"
                    }, 400);
                    o.animate({width: 0, height: 0}, function () {
                        $(this).detach()
                    })
                }
                $.ajax({
                    url: site.site_url + "cart/add/" + e,
                    type: "GET",
                    dataType: "json",
                    data: {qty: a.val()}
                }).done(function (t) {
                    console.log(t);
                    if( t.error){
                        show_message('error', t.message,)
                    }
                    else{
                        show_message('success','le Produit a été ajouter au panier ');
                        (s = t, update_mini_cart(t));
                    }
                })
            }), $(document).on("click", ".btn-minus", function (t) {
                var e = $(this).parent().find("input");
                parseInt(e.val()) > 1 && e.val(parseInt(e.val()) - 1)
            }), $(document).on("click", ".guest-checkout", function (t) {
                return console.log(this), $(".nav-tabs a:last").tab("show"), !1
            }), $(document).on("click", ".btn-plus", function (t) {
                var e = $(this).parent().find("input");
                e.val(parseInt(e.val()) + 1)
            }), $(document).on("click", ".add-to-wishlist", function (t) {
                t.preventDefault();
                var e = $(this).attr("data-id");
                $.ajax({
                    url: site.site_url + "cart/add_wishlist/" + e,
                    type: "GET",
                    dataType: "json"
                }).done(function (t) {
                    if (t.total) $("#total-wishlist").text(t.total); else if (t.redirect)return window.location.href = t.redirect, !1;
                    sa_alert(t.status, t.message, t.level)
                })
            }), $(document).on("click", ".remove-wishlist", function (t) {
                t.preventDefault();
                var e = $(this), s = $(this).attr("data-id");
                $.ajax({
                    url: site.site_url + "cart/remove_wishlist/" + s,
                    type: "GET",
                    dataType: "json"
                }).done(function (t) {
                    if (0 == t.total) setTimeout(function () {
                        location.reload()
                    }, 1e3); else if (t.redirect)return window.location.href = t.redirect, !1;
                    t.status != lang.error && e.closest("tr").remove(), $("#total-wishlist").text(t.total), sa_alert(t.status, t.message, t.level)
                })
            }), update_mini_cart(cart), $("#dropdown-cart").click(function () {
                $(this).next(".dropdown-menu").animate({scrollTop: $(this).next(".dropdown-menu").height() + 400}, 100)
            }), $("#add-address").click(function (t) {
                t.preventDefault(), add_address()
            }), $(".edit-address").click(function (t) {
                t.preventDefault();
                var e = $(this).attr("data-id");
                addresses && $.each(addresses, function () {
                    this.id == e && add_address(this)
                })
            }), $(document).on("click", ".forgot-password", function (t) {
                t.preventDefault(), prompt(lang.reset_pw, lang.type_email)
            }), $("ul.nav li.dropdown").hover(function () {
                get_width() >= 767 && $(this).addClass("open")
            }, function () {
                get_width() >= 767 && $(this).removeClass("open")
            }), $("ul.dropdown-menu [data-toggle=dropdown]").on("click", function (t) {
                t.preventDefault(), t.stopPropagation(), $(this).parent().siblings().removeClass("open"), $(this).parent().toggleClass("open")
            }), $(".tip").tooltip({container: "body"}), $(".validate").formValidation({
                framework: "bootstrap",
                message: "This value is required or not valid"
            }), $(window).scroll(function () {
                $(this).scrollTop() > 70 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
            }), sticky_footer(), $(window).resize(sticky_footer), sticky_con(), $(window).resize(sticky_con), /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) $(".selectpicker").selectpicker({modile: !0}); else {
            for (var t = document.querySelectorAll(".mobile-device"), e = 0; e < t.length; e++)t[e].classList.remove("mobile-device");
            $(".selectpicker").selectpicker()
        }
        if ($(".theme-color").click(function (t) {
                return store("shop_color", $(this).attr("data-color")), $("#wrapper").removeAttr("class").addClass($(this).attr("data-color")), !1
            }), (shop_color = get("shop_color")) && $("#wrapper").removeAttr("class").addClass(shop_color), "products" == v && ($(window).resize(function () {
                gen_html(products)
            }), 1 == site.settings.products_page && $(".grid").isotope({itemSelector: ".grid-item"}), $("#sorting").on("changed.bs.select", function (t) {
                return console.log($(this).val()), store("sorting", $(this).val()), searchProducts(), !1
            }), $(".two-col").click(function () {
                return store("shop_grid", ".two-col"), $(this).addClass("active"), $(".three-col").removeClass("active"), gen_html(products), !1
            }), $(".three-col").click(function () {
                return store("shop_grid", ".three-col"), $(this).addClass("active"), $(".two-col").removeClass("active"), gen_html(products), !1
            }), $("#product-search-form").submit(function (t) {
                return t.preventDefault(), filters.query = $("#product-search").val(), searchProducts(), !1
            }), $("#product-search").blur(function (t) {
                return t.preventDefault(), filters.query = $(this).val(), searchProducts(), !1
            }), $(".reset_filters_brand").click(function (t) {
                filters.brand = null, searchProducts(), $(this).closest("li").remove()
            }), $(".reset_filters_category").click(function (t) {
                filters.category = null, searchProducts(), $(this).closest("li").remove()
            }), $("#min-price, #max-price, #in-stock, #promotions, #featured").change(function () {
                searchProducts()
            }), $(document).on("click", "#pagination a", function (t) {
                t.preventDefault();
                var e = $(this).attr("href"), s = e.split("page=");
                if (s[1]) {
                    var a = s[1].split("&");
                    filters.page = a[0]
                } else filters.page = 1;
                return searchProducts(), !1
            }), (shop_grid = get("shop_grid")) && $(shop_grid).click(), (sorting = get("sorting")) ? $("#sorting").selectpicker("val", sorting) : store("sorting", "name-asc"), filters.query && $("#product-search").val(filters.query), searchProducts()), $(".product").each(function (t, e) {
                $(e).find(".details").hover(function () {
                    $(this).parent().css("z-index", "20"), $(this).addClass("animate")
                }, function () {
                    $(this).removeClass("animate"), $(this).parent().css("z-index", "1")
                })
            }), "cart_ajax" == m && "index" == v) update_mini_cart(cart), update_cart(cart), $(document).on("click", ".remove-item", function (t) {
            t.preventDefault();
            var e = {};
            e.rowid = $(this).attr("data-rowid");
            var s = site.site_url + "cart/remove";
            saa_alert(s, !1, "post", e)
        }), $(document).on("change", ".cart-item-option, .cart-item-qty", function (t) {
            t.preventDefault();
            var e = this.defaultValue, s = $(this).closest("tr"), a = s.attr("id"), i = site.site_url + "cart/update",
                o = {};
            o[site.csrf_token] = site.csrf_token_value, o.rowid = a, o.qty = s.find(".cart-item-qty").val(), o.option = s.find(".cart-item-option").children("option:selected").val(), update_cart_item(i, o, e, $(this), t.target.type)
        }), $(".cart-item-option").on("shown.bs.select", function (t) {
            $(this).children("option:selected").val() && ($po = $(this).children("option:selected").val())
        }), $("#empty-cart").click(function (t) {
            t.preventDefault();
            var e = $(this).attr("href");
            saa_alert(e)
        }); else if ("shop" == m && "product" == v) {
            var s = $("#lightbox");
            $('[data-target="#lightbox"]').on("click", function (t) {
                var e = $(this).find("img"), a = e.attr("src"), i = e.attr("alt"),
                    o = {maxWidth: $(window).width() - 10, maxHeight: $(window).height() - 10};
                s.find(".close").addClass("hidden"), s.find("img").attr("src", a), s.find("img").attr("alt", i), s.find("img").css(o), s.find(".modal-content").removeClass("swal2-hide").addClass("swal2-show")
            }), s.on("shown.bs.modal", function (t) {
                var e = s.find("img");
                s.find(".modal-dialog").css({width: e.width()}), s.find(".close").removeClass("hidden"), s.addClass("fade"), $(".modal-backdrop").addClass("fade")
            }), s.on("hide.bs.modal", function () {
                s.find(".modal-content").removeClass("swal2-show").addClass("swal2-hide")
            }), s.on("hidden.bs.modal", function () {
                s.removeClass("fade"), $(".modal-backdrop").removeClass("fade")
            })
        }
        var a = document.location.toString();
        a.match("#") && $('.nav-tabs a[href="#' + a.split("#")[1] + '"]').tab("show"), $(document).on("click", ".show-tab", function (t) {
            t.preventDefault(), $('.nav-tabs a[href="#' + $(this).attr("href") + '"]').tab("show")
        }), $(".history-tabs a").on("shown.bs.tab", function (t) {
            history.pushState ? history.pushState(null, null, t.target.hash) : window.location.hash = t.target.hash
        }), $(".email-modal").click(function (t) {
            t.preventDefault(), email_form()
        }), $("#same_as_billing").change(function (t) {
            $(this).is(":checked") && ($("#shipping_line1").val($("#billing_line1").val()).change(), $("#shipping_line2").val($("#billing_line2").val()).change(), $("#shipping_city").val($("#billing_city").val()).change(), $("#shipping_state").val($("#billing_state").val()).change(), $("#shipping_postal_code").val($("#billing_postal_code").val()).change(), $("#shipping_country").val($("#billing_country").val()).change(), $("#shipping_phone").val($("#phone").val()).change(), $("#guest-checkout").data("formValidation").resetForm())
        })
    });
    var $po, inputs = document.querySelectorAll(".file"), submit_btn = document.querySelector("#submit-container");
    submit_btn && (submit_btn.style.display = "none"), Array.prototype.forEach.call(inputs, function (t) {
        var e = t.nextElementSibling, s = e.innerHTML;
        t.addEventListener("change", function (t) {
            var a = "";
            this.files && this.files.length > 1 ? (a = (this.getAttribute("data-multiple-caption") || "").replace("{count}", this.files.length), submit_btn && (submit_btn.style.display = "inline-block")) : (a = t.target.value.split("\\").pop(), submit_btn && (submit_btn.style.display = "none")), a ? (e.querySelector("span").innerHTML = a, submit_btn && (submit_btn.style.display = "inline-block")) : (e.innerHTML = s, submit_btn && (submit_btn.style.display = "none"))
        })
    });

    $(document).ready(function () {
       setTimeout(function(){
           $(window).scroll(function(){
               const position  = $(window).scrollTop();
               const bottom    = ($(document).height()) - ($(window).height());

//        console.log(`
//            position : ${position}\n
//            bottom : ${bottom}\n
//            bottom : ${bottom}\n
//            current: can add : ${can_add_content}
//        `);

               if(position === bottom && can_add_content){
                   current_position = position;
                   empty_result = false;
                   $(pagination_next_button).click();
               }
           });
       },1000);
    });

</script>