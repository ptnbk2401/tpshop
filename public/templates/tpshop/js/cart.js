var guidID;
jQuery(function () {
    guidID = jQuery('#hdguidID').val();
    //jQuery(".tr-prd-slider-seen").owlCarousel({
    //    navigation: true,
    //    slideSpeed: 300,
    //    lazyLoad: true,
    //    paginationSpeed: 300,
    //    pagination: false,
    //    itemsCustom: [
    //        [320, 5]
    //    ],
    //    navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    //    autoPlay: false
    //});

    UpdateNumCart();
    Mainreceivermember();
    checkHNHQ();
});

function checkHNHQ() {
    var banner = '<a href="https://www.yes24.vn/loi-ich-thanh-toan-tra-truoc"><img src="https://image.yes24.vn/Upload/Event/2018/hangnhap_tratruoc.jpg" alt="Thanh toán trả trước Hàng Nhập Hàn Quốc" /></a><br/><br/>';
    $.ajax({
        type: 'POST',
        url: '/CheckOut/CheckItemHQ',
        async: true,
        success: function (str) {
            if (str.result == 1) {
                jQuery("#spNotiHNHQ").html(banner);
            }
            else {
                jQuery("#spNotiHNHQ").html('');
            }
        }
    });
}

function UpdateNumCart(returnUrl) {
    $.post('/Basket/HowManyBasketItem', null, function (data) {
        //SetNumCartCookie("HowManyCartItems", data.howManyBasketItem, 1);

        $.cookie("HowManyCartItems", data.howManyBasketItem, { path: '/' });
        if (data.howManyBasketItem != 0) {
            jQuery('.tr-shopping-cart-count').html(data.howManyBasketItem);
            jQuery('.tr-shopping-cart-count').show();
        }

        if ((returnUrl != "" && typeof returnUrl !== "undefined") && returnUrl.length > 0) {
            window.location.href = returnUrl;
        }
    });
}

function Mainreceivermember() {
    if (jQuery('#hdPostalCode').val() != '') {
        cart.DeliveryCost(jQuery('#hdPostalCode').val());
    }
    jQuery("#hdfTotalPayment").val(jQuery("#hdfTotalPayment").val()).clone(true);
    jQuery("#hdfYesVi").val(jQuery("#hdfYesVi").val()).clone(true);
    jQuery("#hdfSerialDisCount").val(jQuery("#hdfSerialDisCount").val()).clone(true);
    jQuery("#hdfYesMoney").val(jQuery("#hdfYesMoney").val()).clone(true);
    jQuery("#hdDeliveryCost").val(jQuery("#hdDeliveryCost").val()).clone(true);

    var TotalPay = jQuery("#hdfTotalPayment").val();
    var yesVi = jQuery("#hdfYesVi").val();
    var serial = jQuery("#hdfSerialDisCount").val();
    var yesMoney = jQuery("#hdfYesMoney").val();
    var delivery = jQuery("#hdDeliveryCost").val();
    jQuery("#spPaymentTotal").html("<span>" + cart.formatDollar(TotalPay - yesVi - serial - yesMoney - -delivery) + "</span>đ");
}



var isClickFinishOrder = false;
var isClickCheckMoney = false;
var isClickCheckVi = false;
var isClickCheckSerial = false;

var cart = {
    //CreateModal(id, title, content, type, buttons, width, action) {
    //    var modal = jQuery(id).SModalCreate({
    //        Title: title,
    //        Content: content,
    //        Type: type,
    //        buttons: buttons,
    //        Width: width
    //    });
    //    modal.SModalShow(action, type);
    //},
    ConfirmDelete: function (e) {
        CreateModal("#notificationModal", "Thông báo", "Bạn có chắc xóa sản phẩm này ra khỏi giỏ hàng", 1, { 'Yes': 'Xóa', 'No': 'Đóng' }, 500, function () {
            cart.DeleteBasket(jQuery(e));
        });
        //var confirms = confirm('Bạn có chắc xóa sản phẩm này ra khỏi giỏ hàng?');
        //if (confirms)
        //    cart.DeleteBasket(jQuery(e));
    },
    CheckNumber: function (e) {

        var flag = true;
        var firstVal = jQuery(e).attr("data-Qty");
        if (jQuery(e).val() != "") {
            var value = jQuery(e).val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            var intRegex = /^\d+$/;
            if (!intRegex.test(value) || value == 0) {
                CreateModal("#notificationModal", "Thông báo", "Số lượng phải là số lớn hơn 0", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                flag = false;
                jQuery(e).addClass("validate-error").focus().val(firstVal);
                return false;
            }
            else {
                jQuery(e).removeClass("validate-error");
                jQuery(e).attr("data-Qty", jQuery(e).val());
                //cap nhat lai so luong tai day

                var GUID = jQuery(e).attr("data-GUID");
                var productNo = jQuery(e).attr("data-ProductNo");
                var skuCode = jQuery(e).attr("data-SKUCode");
                var qty = jQuery(e).attr("data-Qty");
                var basketItemNo = jQuery(e).attr("data-BasketItemNo");

                var URL = "/Basket/UpdateBasket" + "?GUID=" + GUID + "&productNo=" + productNo + "&skuCode=" + skuCode + "&qty=" + qty + "&basketItemNo=" + basketItemNo;
                $.ajax({
                    type: 'GET',
                    cache: false,
                    url: URL,
                    data: {
                        GUID: GUID,
                        productNo: productNo,
                        skuCode: skuCode,
                        qty: qty,
                        basketItemNo: basketItemNo
                    },
                    success: function (result) {
                        if (!result.success) {
                            flag = false;
                            CreateModal("#notificationModal", "Thông báo", result.message, 1, { 'Yes': 'Đóng' }, 500, function () { });
                            //phải trả về số lượng trước đó
                            jQuery(e).val(firstVal);
                            jQuery(e).attr("data-Qty", jQuery(e).val());
                            return flag;
                        }
                        else {
                            CreateModal("#notificationModal", "Thông báo", result.message, 1, { 'Yes': 'Đóng' }, 500, function () { });
                            cart.UpdateControl();
                            cart.UpdateTotal();
                            //cart.UpdateNavigation();
                            UpdateNumCart("");
                        }
                    },
                    error: function () {

                        CreateModal("#notificationModal", "Thông báo", result.message, 1, { 'Yes': 'Đóng' }, 500, function () { });
                        flag = false;
                        //phải trả về số lượng trước đó
                        jQuery(e).addClass("validate-error").focus().val(firstVal);
                        return flag;
                    }
                });
            }
        }
    },
    ChangeNumberCart: function (e, num) {
        var inputQty = jQuery(e).parent().children('.inputQty').val();
        if (num == '0')
            inputQty = parseInt(inputQty) - 1;
        else
            inputQty = parseInt(inputQty) + 1;

        jQuery(e).parent().children('.inputQty').val(inputQty)
        cart.CheckNumber(jQuery(e).parent().children('.inputQty'));
    },
    UpdateControl: function () {
        var URL = "/Basket/BasketList" + "?GUID=" + guidID;
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: { GUID: guidID },
            success: function (result) {
                //jQuery("div.BasketList").hide().html(result).fadeIn(100);
                jQuery("div.BasketList").html(result);
                jQuery(".inputQty").change(function () {
                    cart.CheckNumber(jQuery(this));
                });
                jQuery(".btdelete").click(function () {
                    cart.ConfirmDelete(this);
                });
            },
            error: function () {
            }
        });
    },
    UpdateTotal: function () {
        var URL = "/Basket/BasketTotal" + "?GUID=" + guidID;
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: { GUID: guidID },
            success: function (result) {
                //jQuery(".BasketTotal").hide().html(result).fadeIn(100);
                jQuery(".BasketTotal").html(result);
                cart.UpdateControlGift();
            },
            error: function () { }
        });
    },
    UpdateControlGift: function () {
        var URL = "/Basket/BasketGift" + "?GUID=" + guidID;
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: { GUID: guidID },
            success: function (result) {
                jQuery(".BasketGiftList").html(result);
            },
            error: function () {
            }
        });
    },
    DeleteBasket: function (e) {
        //var confirms = confirm('Bạn có chắc xóa toàn bộ sản phẩm trong giỏ hàng?');
        //if (confirms) {
        var GUID = jQuery(e).attr("data-GUID");
        var productNo = jQuery(e).attr("data-ProductNo");
        var skuCode = jQuery(e).attr("data-SKUCode");
        var basketItemNo = jQuery(e).attr("data-BasketItemNo");
        var URL = "/Basket/DeleteItem" + "?GUID=" + GUID + "&productNo=" + productNo + "&skuCode=" + skuCode + "&basketItemNo=" + basketItemNo;
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: {
                GUID: GUID,
                productNo: productNo,
                skuCode: skuCode,
                basketItemNo: basketItemNo
            },
            success: function (result) {
                cart.UpdateControl();
                cart.UpdateTotal();
                //cart.UpdateNavigation();
                UpdateNumCart("");
            },
            error: function () {
                CreateModal("#notificationModal", "Thông báo", "Không thể xóa sản phẩm, vui lòng thử lại!", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;
                //alert('Không thể xóa sản phẩm, vui lòng thử lại!');
                //return false;
            }
        });
        // }
    },
    DeleteBasketAll: function (e) {
        var GUID = guidID; // jQuery(e).attr("data-GUID");
        var productNo = jQuery(e).attr("data-ProductNo");
        var skuCode = jQuery(e).attr("data-SKUCode");
        var basketItemNo = jQuery(e).attr("data-BasketItemNo");
        var URL = "/Basket/DeleteItemAll" + "?GUID=" + GUID;
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: {
                GUID: GUID,
                productNo: productNo,
                skuCode: skuCode,
                basketItemNo: basketItemNo
            },
            success: function (result) {
                cart.UpdateControl();
                cart.UpdateTotal();
                //cart.UpdateNavigation();
                UpdateNumCart("");
                jQuery("#cart-empty").show();
            },
            error: function () {
                CreateModal("#notificationModal", "Thông báo", "Không thể xóa sản phẩm, vui lòng thử lại!", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;

                //alert('Không thể xóa giỏ hàng, vui lòng thử lại!');
                //return false;
            }
        });
    },
    AddToWishList: function () {
        var URL = "/Basket/AddWishList" + "?GUID=" + guidID;
        //console.log(guidID);
        $.ajax({
            type: 'GET',
            cache: false,
            url: URL,
            data: { GUID: guidID },
            success: function (result) {
                alert('Thêm vào danh sách yêu thích thành công.');
            },
            error: function () {
            }
        });
    },
    GetReceiverAddress: function (para1, para2, para3) {
        $.ajax({
            type: 'GET',
            url: '/CheckOut/Address',
            data: {
                city: para1,
                country: para2,
                street: para3
            },
            success: function (result) {
                jQuery('.receiver-address').html(result);
                cart.DeliveryCost(para3);
            },
        });
    },
    ShowInvoiceInput: function (e) {
        if (document.getElementById("chkInvoice").checked) {
            jQuery("#itemsInvoice").show();
        } else {
            jQuery("#itemsInvoice").hide();
        }
    },
    ChangeTab: function (e) {
        if (e == 'cod') {
            jQuery("#pmCOD").addClass("clicked");
            jQuery("#pmBank").removeClass("clicked");
            jQuery("#pmMomo").removeClass("clicked");
            jQuery("#pmCard").removeClass("clicked");

            jQuery("#ctCod").show();
            jQuery("#ctBank").hide();
            jQuery("#ctMomo").hide();
            jQuery("#ctCard").hide();

            jQuery("#chkCod").prop("checked", true);
            jQuery("#chkBank").prop("checked", false);
            jQuery("#chkMomo").prop("checked", false);
            jQuery("#chkCard").prop("checked", false);

            jQuery("#hdPaymentType").val('1');
        }
        else if (e == 'bank') {
            jQuery("#pmCOD").removeClass("clicked");
            jQuery("#pmBank").addClass("clicked");
            jQuery("#pmMomo").removeClass("clicked");
            jQuery("#pmCard").removeClass("clicked");

            jQuery("#ctCod").hide();
            jQuery("#ctBank").show();
            jQuery("#ctMomo").hide();
            jQuery("#ctCard").hide();

            jQuery("#chkCod").prop("checked", false);
            jQuery("#chkBank").prop("checked", true);
            jQuery("#chkMomo").prop("checked", false);
            jQuery("#chkCard").prop("checked", false);

            jQuery("#hdPaymentType").val('2');
        }
        else if (e == 'momo') {
            jQuery("#pmCOD").removeClass("clicked");
            jQuery("#pmBank").removeClass("clicked");
            jQuery("#pmMomo").addClass("clicked");
            jQuery("#pmCard").removeClass("clicked");

            jQuery("#ctCod").hide();
            jQuery("#ctBank").hide();
            jQuery("#ctMomo").show();
            jQuery("#ctCard").hide();

            jQuery("#chkCod").prop("checked", false);
            jQuery("#chkBank").prop("checked", false);
            jQuery("#chkMomo").prop("checked", true);
            jQuery("#chkCard").prop("checked", false);

            jQuery("#hdPaymentType").val('9');
        }
        else {
            jQuery("#pmCOD").removeClass("clicked");
            jQuery("#pmBank").removeClass("clicked");
            jQuery("#pmMomo").removeClass("clicked");
            jQuery("#pmCard").addClass("clicked");

            jQuery("#ctCod").hide();
            jQuery("#ctBank").hide();
            jQuery("#ctMomo").hide();
            jQuery("#ctCard").show();

            jQuery("#chkCod").prop("checked", false);
            jQuery("#chkBank").prop("checked", false);
            jQuery("#chkMomo").prop("checked", false);
            jQuery("#chkCard").prop("checked", true);

            jQuery("#hdPaymentType").val(jQuery("#slCardChoose option:selected").val());
        }
    },
    DeliveryCost: function (postcode) {
        if (postcode != "" && postcode != null) {
            $.ajax({
                type: 'GET',
                url: '/CheckOut/DeliveryCost' + "?postcode=" + postcode, // CheckOut/DeliveryCostNew
                async: false,
                cache: false,
                data: { postcode: postcode, OrderType: jQuery('#hdOrderType').val() },
                success: function (result) {
                    jQuery("#hdDeliveryCost").val(parseFloat(result.message));

                    jQuery("#shipcost").html("<span id='spanshipcost'>+" + cart.formatDollar(parseInt(result.message)) + "</span>đ");
                    jQuery('#spPaymentTotalGuest').html("<span id='spanspPaymentTotalGuest'>" + cart.formatDollar(jQuery("#hdfTotalPayment").val() - -jQuery("#hdDeliveryCost").val()) + "</span>đ");
                },
                error: function () { }
            });
        }
    },
    GetReceiverAddress: function (para1, para2, para3) {
        $.ajax({
            type: 'GET',
            url: '/CheckOut/Address',
            data: {
                city: para1,
                country: para2,
                street: para3
            },
            success: function (result) {
                jQuery('.receiver-address').html(result);
                cart.DeliveryCost(para3);
            },
        });
    },
    formatDollar: function (num) {
        num = parseInt(num);
        var p = num.toFixed(0).split(".");
        return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
            return num + (i && !(i % 3) ? "," : "") + acc;
        }, "");
    },
    ResetGuestSerialNumber: function () {
        jQuery('#spPaymentTotalGuest').html("<span id='spanspPaymentTotalGuest'>" + cart.formatDollar(jQuery("#hdfTotalPayment").val() - -jQuery("#hdDeliveryCost").val()) + "</span>đ");
        jQuery('#totalserial').html('<span id="spantotalserial">0</span>đ');
        jQuery("#hdfSerialNum").val("");
        jQuery("#hdfSerialDisCount").val(0)
    },
    ResetSerialNumber: function () {
        jQuery("#hdfSerialDisCount").val(0);
        jQuery('#spPaymentTotal').html("<span id='spanspPaymentTotal'>" + cart.formatDollar(jQuery("#hdfTotalPayment").val() - jQuery("#hdfYesMoney").val() - jQuery("#hdfYesVi").val() - -jQuery("#hdDeliveryCost").val() - jQuery("#hdfSerialDisCount").val()) + "</span>đ");
        jQuery('#totalserial').html('<span id="spantotalserial">0</span>đ');
        jQuery("#hdfSerialNum").val("");
        jQuery('#txtSerialNumber').val("");
        jQuery('#checkSerialNumber').text('Sử dụng').css({ "background-color": "#007daf" });
        isClickCheckSerial = false;
    },
    CheckSerialNumber: function () {
        if (isClickCheckSerial) {
            jQuery('#checkSerialNumber').text('Sử dụng').css({ "background-color": "#007daf" });
            isClickCheckSerial = false;
            cart.ResetSerialNumber();

            var currentTotal = jQuery("#hdfTotalPayment").val();
            var mobileCatItem = jQuery("#hdmobileCatItem").val();
            var yesMoneyMax = (currentTotal - mobileCatItem) * 0.1;
            var yesMoneyIMoney = parseInt(jQuery("#hdfYesMoneyIMoney").val()) <= yesMoneyMax ? parseInt(jQuery("#hdfYesMoneyIMoney").val()) : yesMoneyMax;
            jQuery("#hdfYesMoneyMax").val(yesMoneyIMoney);
            jQuery("#AvailableYesMoney").html(cart.formatDollar(yesMoneyIMoney < 0 ? 0 : yesMoneyIMoney));

            return false;
        }
        var serialNumber = jQuery('#txtSerialNumber').val();
        if (serialNumber == null || serialNumber == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập mã giảm giá", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#txtSerialNumber').focus();
            return false;
        }

        $.ajax({
            type: 'GET',
            url: '/CheckOut/GetSerialForOrder' + "?SerialNumber=" + serialNumber,
            async: false,
            cache: false,
            data: { SerialNumber: serialNumber, OrderType: jQuery('#hdOrderType').val() },
            success: function (result) {
                if (result.success == true) {
                    //reset lại yesmoney
                    cart.ResetYesMoney();
                    //tinh lai tien hoa don
                    var currentTotal = jQuery("#hdfTotalPayment").val();
                    var SerialDiscount = parseInt(result.message);
                    var delivery = jQuery("#hdDeliveryCost").val();
                    var yesMoney = jQuery("#hdfYesMoney").val();
                    var yesVi = jQuery("#hdfYesVi").val();
                    var mobileCatItem = jQuery("#hdmobileCatItem").val();
                    var emartItem = jQuery("#hdEmartItem").val();

                    var Total = parseInt(currentTotal) - SerialDiscount - parseInt(yesMoney) - parseInt(yesVi) + parseInt(delivery);
                    var yesMoneyMax = (currentTotal - SerialDiscount - mobileCatItem - emartItem) * 0.1;
                    if (yesMoneyMax < 0)
                        yesMoneyMax = 0;
                    yesMoneyMax = yesMoneyMax + (mobileCatItem * 0.01);

                    var yesMoneyIMoney = parseInt(jQuery("#hdfYesMoneyIMoney").val()) <= yesMoneyMax ? parseInt(jQuery("#hdfYesMoneyIMoney").val()) : yesMoneyMax;
                    jQuery("#hdfSerialDisCount").val(SerialDiscount);
                    jQuery("#hdfSerialNum").val(serialNumber);
                    //reset yesmoneyMax
                    jQuery("#hdfYesMoneyMax").val(yesMoneyIMoney);
                    jQuery("#AvailableYesMoney").html(cart.formatDollar(yesMoneyIMoney < 0 ? 0 : yesMoneyIMoney));

                    jQuery('#spPaymentTotal').html("<span id='spanspPaymentTotal'>" + cart.formatDollar(Total) + "</span>đ");
                    jQuery('#totalserial').html("<span id='spantotalserial'>- " + cart.formatDollar(parseInt(SerialDiscount)) + "</span>đ");

                    // jQuery('#check-coupon').val("coupon");
                    isClickCheckSerial = true;
                    if (isClickCheckSerial) {
                        jQuery('#checkSerialNumber').text('Hủy').css({ "background-color": "#b0b0b0" });
                        jQuery('#checkYesMoney').text('Sử dụng');
                    }
                }
                else {
                    CreateModal("#notificationModal", "Thông báo", result.message, 1, { 'Yes': 'Đóng' }, 500, function () {
                    });
                    return false;
                    return;
                }
            },
            error: function () { }
        });

    },

    CheckGuestSerialNumber: function () {
        if (isClickCheckSerial) {
            jQuery('#checkSerialNumber').text('Sử dụng').css({ "background-color": "#007daf" });
            isClickCheckSerial = false;
            cart.ResetGuestSerialNumber();
            return false;
        }
        var serialNumber = jQuery('#txtSerialNumber').val();
        if (serialNumber == null || serialNumber == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập mã giảm giá", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#txtSerialNumber').focus();
            return false;
        }
        $.ajax({
            url: '/CheckOut/GetSerialForOrder' + "?SerialNumber=" + serialNumber,
            async: false,
            cache: false,
            data: { SerialNumber: serialNumber, OrderType: jQuery('#hdOrderType').val() },
            success: function (result) {
                if (result.success == true) {
                    //tinh lai tien hoa don
                    var currentTotal = jQuery("#hdfTotalPayment").val();
                    var SerialDiscount = parseInt(result.message);
                    var delivery = jQuery("#hdDeliveryCost").val();

                    var Total = parseInt(currentTotal) - SerialDiscount + parseInt(delivery);

                    //jQuery("#hdfSerialDisCount").val(SerialDiscount);
                    jQuery('#spPaymentTotalGuest').html("<span id='spanspPaymentTotalGuest'>" + cart.formatDollar(Total) + "</span>đ");
                    jQuery("#hdfSerialNum").val(serialNumber);

                    jQuery('#totalserial').html("<span id='spantotalserial'>- " + cart.formatDollar(parseInt(SerialDiscount)) + '</span>đ');

                    isClickCheckSerial = true;
                    if (isClickCheckSerial) {
                        jQuery('#checkSerialNumber').text('Hủy').css({ "background-color": "#b0b0b0" });
                    }
                }
                else {
                    CreateModal("#notificationModal", "Thông báo", result.message, 1, { 'Yes': 'Đóng' }, 500, function () {
                        jQuery("#txtSerialNumber").val('');
                        jQuery("#txtSerialNumber").focus();
                        return false;
                    });
                    return;
                }
            },
            error: function () { }
        });

    },
    CheckPhoneNumber: function (e) {
        if (jQuery(e).val() != "") {
            var value = jQuery(e).val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            //if (!value.match("^(0[1-9]{1}\d{8,9})$")) {
            //    CreateModal("Thông báo", "Số điện thoại không đúng định dạng", 1, { 'Yes': 'Đóng' }, function () {
            //        flag = false;
            //        jQuery(e).addClass("validate-error").focus().val("");
            //    });
            //    return false;
            //}
            if (value.length < 10 || value.length > 11) {
                CreateModal("#notificationModal", "Thông báo", "Số điện thoại không đúng định dạng.", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                flag = false;
                jQuery(e).addClass("validate-error").focus().val("");
                return false;

                //alert('Số điện thoại không đúng định dạng.');
                //flag = false;
                //jQuery(e).addClass("validate-error").focus().val("");
                //return false;
            }
            else {
                jQuery(e).removeClass("validate-error");
                return true;
            }
        }
    },
    SetPaymentOnline: function () {
        jQuery('#hdPaymentType').val(jQuery("#slCardChoose option:selected").val());
    },
    GetTypeNamePayment: function () {
        var paymentType = 0;
        paymentType = jQuery("#hdPaymentType").val();

        if (paymentType == 1) {
            return "COD";
        }
        else if (paymentType == 2) {
            return "BANKACCOUNT";
        }
        else if (paymentType == 3) {
            return "INSTANTTRANSFER";
        }
        else if (paymentType == 8) {
            return "VNPAY";
        }
        else if (paymentType == 9) {
            return "MOMO";
        }
        else {
            return "NONE";
        }
    },
    GetTypePayment: function () {
        var paymentType = 0;
        paymentType = jQuery("#hdPaymentType").val();
        return paymentType;
    },
    GetStreetReceiver: function () {
        var street = "";
        jQuery("select#street").find("option").each(function () {
            if (jQuery(this).attr("value") == jQuery("select#street").val()) {
                street = jQuery(this).html();
                return street;
            }
        });
        return street;
    },
    PaymentAlert: function () {
        var paymentType = 0;
        paymentType = jQuery("#hdPaymentType").val();
        if (paymentType == 1) {
            cart.PaymentConfirm();
        }
        else if (paymentType == 2) {
            cart.PaymentConfirm();
        }
        else {
            cart.PaymentConfirm();
        }
    },
    PaymentConfirm: function () {
        $.ajax({
            type: "POST",
            url: '/CheckOut/PaymentConfirm',
            data: { OrderType: jQuery('#hdOrderType').val() },
            async: true,
            cache: false,
            beforeSend: function (e) {
            },
            success: function (result) {
                if (result.success) {
                    window.location.href = result.message;
                }
                else {
                    isClickFinishOrder = false;
                    HideLoading();
                    CreateModal("#notificationModal", "Thông báo", result.message, 2, { 'Yes': 'Đóng' }, 500, function () {
                        window.location.href = '/Basket/MemberBasket';
                    });
                }
            },
            error: function () {
                isClickFinishOrder = false;
                HideLoading();
                CreateModal("#notificationModal", "Thông báo", "Không thể thanh toán vui lòng thử lại", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
            },
            complete: function (e) {
            }
        });
    },
    SaveOrderData: function () {
        var flag = true;
        var yesVi = parseFloat(jQuery("#hdfYesVi").val());
        var mobile = parseFloat(jQuery("#hdfMobileCatMember").val());
        var Invoice = jQuery('#txtInvoice').val();

        if (mobile > yesVi) {
            CreateModal("#notificationModal", "Thông báo", "Quý khách phải nhập YesVí để thanh toán thẻ cào điện thoại.", 1, { 'Yes': 'Đóng' }, 600, function () {
            });
            return false;
        }

        if (flag == true) {
            if (jQuery('#hdTypeReceive').val() == "1")
                city = jQuery('#hdAddress1').val();
            else
                city = jQuery('#city').val();
            //kiem tra don hang co E-mart không
            //var iemart = checkemart(city);
            //if (iemart == 0) {
            //    //CreateModal("Thông báo", "Sản phẩm Emart chỉ giao hàng tại Tp.Hồ Chí Minh. Bạn vui lòng xem lại giỏ hàng.", 1, { 'Yes': 'Đóng' }, function () { });
            //    alert('Sản phẩm Emart chỉ giao hàng tại Tp.Hồ Chí Minh. Bạn vui lòng xem lại giỏ hàng.');
            //    flag = false;
            //}
            var ischecknote = checknotdeliverycart(city);
            if (ischecknote == -3) {
                CreateModal("#notificationModal", "Thông báo", "Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Tp.Hồ Chí Minh. Vui lòng xem lại giỏ hàng.", 1, {
                    'Yes': 'Đóng'
                }, 500, function () { });
                flag = false;

            } else if (ischecknote == -4) {
                CreateModal("#notificationModal", "Thông báo", "Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Hà Nội. Vui lòng xem lại giỏ hàng.", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                flag = false;
            }
        }

        var paymentType = 0;
        paymentType = jQuery("#hdPaymentType").val();

        if (paymentType == 2) {
            var paymentname = jQuery('#payment-bankname');
            if (paymentname.val() == "" || paymentname.val() == undefined) {
                CreateModal("#notificationModal", "Thông báo", "Vui lòng nhập số tài khoản", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                paymentname.addClass("validate-error").focus();
                return false;
            }
        }

        var paymentTypeName = cart.GetTypeNamePayment();
        var paymentTypeCd = cart.GetTypePayment();
        var receiverStreet = jQuery('#hdPostalCode').val(); //cart.GetStreetReceiver();
        if (receiverStreet == null || receiverStreet == '') {
            CreateModal("#notificationModal", "Thông báo", "Thông tin giao hàng không chính xác.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            paymentname.addClass("validate-error").focus();
            return false;
        }

        if (isClickFinishOrder)
            return;
        isClickFinishOrder = true;

        var shipcost = jQuery('#hdDeliveryCost').val();
        var totalmoney = parseInt(jQuery('#hdfTotalPayment').val()) + parseInt(shipcost);
        var plus = '';
        if (shipcost > 0) {
            plus = "+";
        }

        ShowLoading();
        $.ajax({
            type: 'POST',
            url: '/CheckOut/SaveMemberOrderData' + "?paymentTypeName=" + paymentTypeName + "&paymentTypeCd=" + paymentTypeCd + "&receiverStreet=" + receiverStreet + "&invoice=" + Invoice,
            data: jQuery('#member-checkout').serialize(),
            async: true,
            cache: false,
            beforeSend: function (e) {
            },
            success: function (result) {
                cart.PaymentAlert();
            },
            error: function () {
                console.log("không thể đặt hàng");
                setTimeout(function () { 
                    HideLoading();
                    isClickFinishOrder = false;
                }, 2000);
            },
            complete: function (e) {
                
            }
        });
    },
    SaveGuestOrderData: function () {
        var flag = true;
        var Name = jQuery('#txtName').val();
        var Phone = jQuery('#txtPhone').val();
        var Email = jQuery('#txtEmail').val();
        var Gender = '';
        var male = jQuery("#chkMale input[type='radio']:checked");
        if (male.length > 0)
            Gender = 'MALE';
        else
            Gender = 'FEMALE';

        var city = jQuery("#city option:selected").val();
        var country = jQuery("#country option:selected").val();
        var street = jQuery("#street option:selected").val();
        var Address = jQuery('#txtAddress').val();
        var Note = jQuery('#txtNote').val();
        var Invoice = jQuery('#txtInvoice').val();

        if (Name == null || Name == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập Họ và tên.", 1, { 'Yes': 'Đóng' }, 500, function () {
                //jQuery('#txtName').focus();
            });
            jQuery('#txtName').addClass('validate-error');
            return false;
        }
        if (Phone == null || Phone == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập Số điện thoại.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#txtPhone').addClass('validate-error');
            jQuery('#txtPhone').focus();
            return false;
        }
        if (Email == null || Email == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập Email.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#txtEmail').addClass('validate-error');
            jQuery('#txtEmail').focus();
            return false;
        }
        if (city == null || city == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa chọn Tỉnh/ Thành phố.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#city').addClass('validate-error');
            jQuery('#city').focus();
            return false;
        }
        if (country == null || country == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa chọn Quận/ Huyện.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#country').addClass('validate-error');
            jQuery('#country').focus();
            return false;
        }
        if (street == null || street == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa chọn Phường/ Xã.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#street').addClass('validate-error');
            jQuery('#street').focus();
            return false;
        }
        if (Address == null || Address == "") {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa nhập địa chỉ - Số nhà, đường.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            jQuery('#txtAddress').addClass('validate-error');
            jQuery('#txtAddress').focus();
            return false;
        }

        var ischecknote = checknotdeliverycart(jQuery('#city').val());
        if (ischecknote == -3) {
            CreateModal("#notificationModal", "Thông báo", "Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Tp.Hồ Chí Minh. Vui lòng xem lại giỏ hàng.", 1, {
                'Yes': 'Đóng'
            }, 500, function () { });
            flag = false;
            //alert('Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Tp.Hồ Chí Minh. Vui lòng xem lại giỏ hàng.');
            //flag = false;
        } else if (ischecknote == -4) {
            CreateModal("#notificationModal", "Thông báo", "Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Hà Nội. Vui lòng xem lại giỏ hàng.", 1, { 'Yes': 'Đóng' }, 500, function () {
            });
            flag = false;
            //alert('Một số sản phẩm trong giỏ hàng của Bạn chỉ giao tại Tp.Hồ Chí Minh. Vui lòng xem lại giỏ hàng.');
            //flag = false;
        }

        if (flag == true) {
            var paymentType = 0;
            paymentType = jQuery("#hdPaymentType").val();

            if (paymentType == 2) {
                var paymentname = jQuery('#payment-bankname');
                if (paymentname.val() == "" || paymentname.val() == undefined) {
                    CreateModal("#notificationModal", "Thông báo", "Vui lòng nhập số tài khoản", 1, { 'Yes': 'Đóng' }, 500, function () {
                    });
                    paymentname.addClass("validate-error").focus();
                    return false;
                }
            }

            var paymentTypeName = cart.GetTypeNamePayment();
            var paymentTypeCd = cart.GetTypePayment();
            var receiverStreet = cart.GetStreetReceiver();

            if (isClickFinishOrder)
                return;
            isClickFinishOrder = true;

            ShowLoading();
            $.ajax({
                type: 'POST',
                url: '/CheckOut/SaveOrderData' + "?paymentTypeName=" + paymentTypeName + "&paymentTypeCd=" + paymentTypeCd + "&customerStreet=&receiverStreet=" + receiverStreet + "&invoice=" + Invoice,
                data: jQuery('#guest-checkout').serialize(),
                async: true,
                cache: false,
                beforeSend: function (e) {
                },
                success: function (result) {
                    cart.PaymentAlert();
                },
                error: function () {
                    console.log("không thể đặt hàng");
                    setTimeout(function () {
                        HideLoading();
                        isClickFinishOrder = false;
                    }, 2000);
                },
                complete: function (e) {
                }
            });
        }
    },
    CheckYesMoney: function () {
        if (isClickCheckMoney) {
            jQuery('#checkYesMoney').text('Sử dụng');
            isClickCheckMoney = false;
            cart.ResetYesMoney();
            return false;
        }
        jQuery('#check-yes-money').val("yesmoney");
        var yesMoney = jQuery("#text-yes-money").val() * 1.0;
        var serial = jQuery("#hdfSerialDisCount").val();
        var TotalPay = jQuery("#hdfTotalPayment").val();
        var yesVi = jQuery("#hdfYesVi").val();
        var delivery = jQuery("#hdDeliveryCost").val();

        if (!isNaN(parseFloat(yesMoney)) && isFinite(yesMoney)) {
            if (yesMoney <= 0) {
                cart.ResetYesMoney();
                CreateModal("#notificationModal", "Thông báo", "Mời kiểm tra YES MONEY.", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;
                //alert('Mời kiểm tra YES MONEY.');
                //return false;
            }

            if (yesMoney > jQuery("#hdfYesMoneyMax").val()) {
                cart.ResetYesMoney();
                CreateModal("#notificationModal", "Thông báo", "YES MONEY vừa nhập lớn hơn YES MONEY có thể sử dụng", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;
                //alert('YES MONEY vừa nhập lớn hơn YES MONEY có thể sử dụng.');
                //return false;
            }

            if ((TotalPay - yesVi - serial - -delivery) < yesMoney) {
                jQuery("#text-yes-money").val(TotalPay - yesVi - serial - -delivery);
                jQuery("#hdfYesMoney").val(TotalPay - yesVi - serial - -delivery);
                jQuery("#yesmoney").html("<span id='spanyesmoney'>-" + cart.formatDollar(TotalPay - yesVi - serial - -delivery) + "</span>đ");
                jQuery("#spPaymentTotal").html("<span id='spanspPaymentTotal'>0</span>đ");
                return;
            }
            else {
                jQuery("#text-yes-money").val(yesMoney);
                jQuery("#hdfYesMoney").val(yesMoney);
                jQuery("#yesmoney").html("<span id='spanyesmoney'>-" + cart.formatDollar(yesMoney) + "</span>đ");
                jQuery("#spPaymentTotal").html("<span id='spanspPaymentTotal'>" + cart.formatDollar(TotalPay - yesVi - serial - yesMoney - -delivery) + "</span>đ");
                jQuery('#checkYesMoney').text('Hủy');

                isClickCheckMoney = true;
                return;
            }
            //hien thi lai nut huy

        }
        else {
            cart.ResetYesMoney();
        }
    },
    ResetYesMoney: function () {
        jQuery('#spPaymentTotal').html("<span id='spanspPaymentTotal'>" + cart.formatDollar(jQuery("#hdfTotalPayment").val() - jQuery("#hdfYesVi").val() - -jQuery("#hdDeliveryCost").val() - jQuery("#hdfSerialDisCount").val()) + "</span>đ");
        jQuery("#text-yes-money").val(null);
        jQuery("#hdfYesMoney").val(0);
        jQuery('#yesmoney').html("<span id='spanyesmoney'>0</span>đ");
        jQuery('#check-yes-money').val("");
        isClickCheckMoney = false;
    },
    CheckYesVi: function () {
        if (isClickCheckVi) {
            jQuery('#checkYesVi').text('Sử dụng');
            isClickCheckVi = false;
            cart.ResetYesVi();
            return false;
        }
        jQuery('#check-yes-vi').val("yesvi");
        var yesMoney = jQuery("#hdfYesMoney").val();
        var serial = jQuery("#hdfSerialDisCount").val();
        var TotalPay = jQuery("#hdfTotalPayment").val();
        var yesVi = jQuery("#text-yes-vi").val() * 1.0;
        var delivery = jQuery("#hdDeliveryCost").val();

        if (!isNaN(parseFloat(yesVi)) && isFinite(yesVi)) {
            if (yesVi <= 0) {
                cart.ResetYesVi();
                CreateModal("#notificationModal", "Thông báo", "Mời kiểm tra YES Ví.", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;

                //alert('Mời kiểm tra YES Ví.');
                //return false;
            }

            if (yesVi > jQuery("#hdfYesViMax").val()) {
                cart.ResetYesVi();
                CreateModal("#notificationModal", "Thông báo", "YES Ví vừa nhập lớn hơn YES Ví có thể sử dụng", 1, { 'Yes': 'Đóng' }, 500, function () {
                });
                return false;

                //alert('YES Ví vừa nhập lớn hơn YES Ví có thể sử dụng.');
                //return false;
            }

            if ((TotalPay - yesMoney - serial - -delivery) < yesVi) {
                jQuery("#text-yes-vi").val(TotalPay - yesMoney - serial - -delivery);
                jQuery("#hdfYesVi").val(TotalPay - yesMoney - serial - -delivery);
                jQuery("#yesvi").html("<span id='spanyesvi'>-" + cart.formatDollar(TotalPay - yesMoney - serial - -delivery) + "</span>đ");
                jQuery("#spPaymentTotal").html("<span id='spanspPaymentTotal'>0</span>đ");
                return;
            }
            else {
                jQuery("#text-yes-vi").val(yesVi);
                jQuery("#hdfYesVi").val(yesVi);
                jQuery("#yesvi").html("<span id='spanyesvi'>-" + cart.formatDollar(yesVi) + "</span>đ")
                jQuery("#spPaymentTotal").html("<span id='spanspPaymentTotal'>" + cart.formatDollar(TotalPay - yesVi - serial - yesMoney - -delivery) + "</span>đ");

                isClickCheckVi = true;
                jQuery('#checkYesVi').text('Hủy');
                return;
            }
        }
        else {
            cart.ResetYesVi();
        }
    },
    ResetYesVi: function () {
        jQuery('#spPaymentTotal').html("<span id='spanspPaymentTotal'>" + cart.formatDollar(jQuery("#hdfTotalPayment").val() - jQuery("#hdfYesMoney").val() - -jQuery("#hdDeliveryCost").val() - jQuery("#hdfSerialDisCount").val()) + "</span>đ")
        jQuery("#text-yes-vi").val(null);
        jQuery("#hdfYesVi").val(0);
        jQuery('#yesvi').html("<span id='spanyesvi'>0</span>đ");
        jQuery('#check-yes-vi').val("");
    },
    ChangeReceiveMember: function (obj) {
        jQuery('ul.receiver li i').attr('class', 'fa fa-lg fa-circle-o');
        jQuery(obj).attr('class', 'fa fa-lg fa-dot-circle-o');
        jQuery('#hdAddressNo').val(jQuery(obj).attr('data-addressno'));
        jQuery('#hdPostalCode').val(jQuery(obj).attr('data-postalcode'));
        jQuery('#hdAddress1').val(jQuery(obj).attr('data-address'));

        if (jQuery('#hdPostalCode').val() != '') {
            cart.DeliveryCost(jQuery('#hdPostalCode').val());
        }

        var TotalPay = jQuery("#hdfTotalPayment").val();
        var yesVi = jQuery("#hdfYesVi").val();
        var serial = jQuery("#hdfSerialDisCount").val();
        var yesMoney = jQuery("#hdfYesMoney").val();
        var delivery = jQuery("#hdDeliveryCost").val();
        jQuery("#spPaymentTotal").html("<span id='spanspPaymentTotal'>" + cart.formatDollar(TotalPay - yesVi - serial - yesMoney - -delivery) + "</span>đ");
    },
    CheckQtyBasket: function () {
        var totalItemPrice = 0;
        totalItemPrice = jQuery("#spItemTotal").html();
        if (totalItemPrice == '0') {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa chọn Sản phẩm để Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
        }
        else {
            ShowLoading();
            $.ajax({
                type: 'POST',
                url: '/Basket/CheckBasketEmpty',
                async: false,
                cache: false,
                success: function (result) {
                    if (result.howManyBasketItem == '999') {
                        CreateModal("#notificationModal", "Thông báo", "Có sản phẩm đã hết hàng. Vui lòng Xóa sản phẩm hết hàng để Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
                        HideLoading();
                    }
                    else if (result.howManyBasketItem < 1) {
                        CreateModal("#notificationModal", "Thông báo", "Giỏ hàng trống không thể Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
                        HideLoading();
                    }
                    else {
                        window.location = '/CheckOut/MemberOrderPayment';
                    }
                }
            });
        }
    },
    CheckQtyBasketGuest: function () {
        var totalItemPrice = 0;
        totalItemPrice = jQuery("#spItemTotal").html();
        if (totalItemPrice == '0') {
            CreateModal("#notificationModal", "Thông báo", "Bạn chưa chọn Sản phẩm để Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
        }
        else {
            ShowLoading();
            $.ajax({
                type: 'POST',
                url: '/Basket/CheckBasketEmpty',
                async: false,
                cache: false,
                success: function (result) {
                    if (result.howManyBasketItem == '999') {
                        CreateModal("#notificationModal", "Thông báo", "Có sản phẩm đã hết hàng. Vui lòng Xóa sản phẩm hết hàng để Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
                    }
                    else if (result.howManyBasketItem < 1) {
                        CreateModal("#notificationModal", "Thông báo", "Giỏ hàng trống không thể Đặt hàng.", 1, { 'Yes': 'Đóng' }, 500, function () { });
                    }
                    else {
                        LoginCart();
                    }
                    HideLoading();
                }
            });
        }
    }
}

var isdeletereceivermember = false;
function deletereceivermember(obj, no, evt) {
    if (isdeletereceivermember)
        return;
    isdeletereceivermember = true;
    evt.preventDefault();
    evt.stopPropagation();
    $.ajax({
        type: 'POST',
        url: '/CheckOut/DeleteReceiverMember',
        data: { addressno: no },
        async: false,
        beforeSend: function (e) {
            //ShowLoading();
        },
        success: function (d) {
            isdeletereceivermember = false;
            if (d.result == 1) {
                if (jQuery(obj).attr('class') == 'fa fa-lg fa-dot-circle-o') {
                    cart.ChangeReceiveMember('#idaddress-' + d.addressno);
                }
                jQuery(obj).parent().remove();
                jQuery('#toggleReceiver').show();
                if (d.count == 0) {
                    jQuery('#toggleReceiver').find('i').attr('class', 'fa fa-angle-up');
                    jQuery('#hdTypeReceive').val(0);
                    jQuery('#new-user-content').slideToggle(300);
                    jQuery('#toggleReceiver').attr('onclick', '');
                    jQuery('#toggleReceiver i').hide();
                }
            }
        },
        error: function () {
            isdeletereceivermember = false;
            console.log("error");
        },
        complete: function (e) {

        }
    });
}

function showdeletebutton(addressno, i) {
    if (i == 1)
        jQuery("#icon-close-" + addressno).show();
    else
        jQuery("#icon-close-" + addressno).hide();
}

var isupdatereceivermember = false;
function updatereceivermember(obj, no) {
    if (isupdatereceivermember)
        return;
    isupdatereceivermember = true;
    $.ajax({
        type: 'POST',
        url: '/CheckOut/UpdateReceiverMember',
        data: { addressno: no },
        async: false,
        beforeSend: function (e) {
            //ShowLoading();
        },
        success: function (result) {
            isupdatereceivermember = false;
            cart.ChangeReceiveMember(jQuery(obj).children('i'));
        },
        error: function () {
            isupdatereceivermember = false;
            console.log("error");
        },
        complete: function (e) {

        }
    });
}

function requireNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    var num = String.fromCharCode(key);
    if (isNumeric(num)) {
        return true;
    }
    return false;
};

function isNumeric(e) { return !isNaN(parseFloat(e)) && isFinite(e) }

function LoginCart() {
    //fbq('track', 'InitiateCheckout');
    $.ajax({
        type: "GET",
        url: "/Account/PopupLoginCart",
        data: {
            returnUrl: location.pathname,
            login: 0,
            orderType: ''
        },
        dataType: 'html',
        success: function (data) {
            CreateModal("#LoginCartModal",
                "",
                data,
                1,
                "",
                780,
                function () { });
            hideLoading();
        }
    });
}

function showpayment() {
    //if (jQuery("label[for='IsStockOut']").length > 0) {
    //    CreateModal("Thông báo", "Có sản phẩm hết hàng trong giỏ hàng, vui lòng xóa sản phẩm và thử lại!", 1, { 'Yes': 'Đóng' }, function () {
    //        return false;
    //    });
    //}
    LoginCart();
}

//Kiểm tra đơn hàng chỉ giao ở TP HCM hoặc Hà Nội
function checknotdeliverycart(c) {
    var result = 0;
    $.ajax({
        type: 'POST',
        url: '/CheckOut/checkNotDeliveryCart',
        data: {
            address01: c, OrderType: jQuery('#hdOrderType').val()
        },
        async: false,
        beforeSend: function (e) {
            //ShowLoading();
        },
        success: function (d) {
            result = d.result;
        },
        error: function () {
        },
        complete: function (e) {
        }
    });
    return result;
}

var isupdatereceivermember = false;
function updatereceivermember(obj, no) {
    if (isupdatereceivermember)
        return;
    isupdatereceivermember = true;
    $.ajax({
        type: 'POST',
        url: '/CheckOut/UpdateReceiverMember',
        data: { addressno: no },
        async: false,
        cache: false,
        beforeSend: function (e) {
            //ShowLoading();
        },
        success: function (result) {
            isupdatereceivermember = false;
            cart.ChangeReceiveMember(jQuery(obj).children('i'));
        },
        error: function () {
            isupdatereceivermember = false;
            console.log("error");
        },
        complete: function (e) {

        }
    });
}

function outValidate(e) {
    jQuery(e).removeClass("validate-error");
}

function AddressListShow() {
    $.ajax({
        type: "GET",
        url: "/CheckOut/AddressListCart",
        data: {},
        dataType: 'html',
        success: function (data) {
            CreateModal("#notificationModal",
                "",
                data,
                1,
                "",
                560,
                function () { });
        }
    });
}

function AddNewAddress() {
    var name = jQuery('#txtName').val();
    var phone = jQuery('#txtPhone').val();
    var Gender = '';
    var male = jQuery("#chkMale input[type='radio']:checked");
    if (male.length > 0)
        Gender = 'MALE';
    else
        Gender = 'FEMALE';

    var city = jQuery("#city option:selected").val();
    var country = jQuery("#country option:selected").val();
    var street = jQuery("#street option:selected").val();

    var streetName = jQuery("#street option:selected").text();
    var Address = jQuery('#txtAddress').val();

    if (name == null || name == "") {
        jQuery("#alert").html('<div class="alert-danger alert">Bạn chưa nhập Họ và tên.</div>');
        jQuery('#txtName').addClass('validate-error');
        return false;
    }

    if (phone == null || phone == "") {
        jQuery("#alert").html('<div class="alert-danger alert">Bạn chưa nhập Số điện thoại.</div>');
        jQuery('#txtPhone').addClass('validate-error');
        return false;
    }

    if (street == null || street == "") {
        jQuery("#alert").html('<div class="alert-danger alert">Bạn chưa chọn Phường/xã.</div>');
        jQuery('#street').addClass('validate-error');
        return false;
    }

    if (Address == null || Address == "") {
        jQuery("#alert").html('<div class="alert-danger alert">Bạn chưa nhập địa chỉ - Số nhà, đường.</div>');
        jQuery('#txtAddress').addClass('validate-error');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "/CheckOut/AddAddressCart",
        data: { Name: name, Phone: phone, Gender: Gender, City: city, District: country, Ward: streetName, Address: Address, DefaultPostCode: street },
        async: true,
        success: function (data) {
            if (data.Result > 0) {
                jQuery("#notificationModal").modal("hide");
                window.location = window.location;
            }
        }
    });
}

function outValidate_address(e) {
    jQuery(e).removeClass("validate-error");
    jQuery("#alert").html('');
}

var timmerSt;
var glb_dstd_lstSgg = new Date().getTime();
function SuggestSearchHead(event, e) {
    var currentTime = new Date().getTime();
    if (currentTime - glb_dstd_lstSgg < 3000) {
        clearTimeout(timmerSt);
        timmerSt = setTimeout(function () {
            SuggestSearchHead(event);
        }, 310);
        return;
    }

    cart.CheckNumber(e);
    glb_dstd_lstSgg = new Date().getTime();
}

/*---------------------------------------------------------------- Check Item Cart ---------------------------------------------------------------*/
if (typeof itemTotal === 'undefined') {
    var itemTotal = 0;
}

var checkItem = 1;
jQuery(function () {
    if (action_more.toLowerCase() == "memberbasket" || action_more.toLowerCase() == "guestbasket") {
        DisplayButtonCheckAll();
    }
});

function DisplayButtonCheckAll() {
    var itemnum;
    for (var i = 1; i < itemTotal; i++) {
        itemnum = jQuery("#chk-" + i).attr("data-chk");
        if (itemnum == '0') {
            checkItem = 0;
            jQuery("#chk-all").removeClass("check-border");
            jQuery("#chk-all").addClass("uncheck-border");
            break;
        }
    }
}


function checkAllItem() {
    var statusCd = '';
    if (checkItem == 1) {
        statusCd = 'STANDBY';
        $.ajax({
            type: "POST",
            url: "/Basket/UpdateBasketStatusAll?GUID=" + guidID + "&StatusCd=" + statusCd,
            async: false,
            cache: false,
            success: function (data) {
                if (data.success > 0) {
                    jQuery("#chk-all").removeClass("check-border");
                    jQuery("#chk-all").addClass("uncheck-border");
                    for (var i = 1; i < itemTotal; i++) {
                        jQuery("#chk-" + i).removeClass("check-border");
                        jQuery("#chk-" + i).addClass("uncheck-border");
                    }
                    checkItem = 0;
                    cart.UpdateTotal();
                }
            }
        });
    }
    else {
        statusCd = 'NORMAL';
        $.ajax({
            type: "POST",
            url: "/Basket/UpdateBasketStatusAll?GUID=" + guidID + "&StatusCd=" + statusCd,
            async: false,
            cache: false,
            success: function (data) {
                if (data.success > 0) {
                    jQuery("#chk-all").removeClass("uncheck-border");
                    jQuery("#chk-all").addClass("check-border");
                    for (var i = 1; i < itemTotal; i++) {
                        jQuery("#chk-" + i).removeClass("uncheck-border");
                        jQuery("#chk-" + i).addClass("check-border");
                    }
                    checkItem = 1;
                    cart.UpdateTotal();
                }
            }
        });
    }
}

function checkItemCart(chk) {
    var statusCd = '';
    var chkValue = jQuery("#chk-" + chk).attr("data-chk");
    var basketItemNo = jQuery("#chk-" + chk).attr("data-BasketItemNo");
    if (chkValue == 1) {
        statusCd = 'STANDBY';
        $.ajax({
            type: "POST",
            url: "/Basket/UpdateBasketStatus?GUID=" + guidID + "&basketItemNo=" + basketItemNo + "&StatusCd=" + statusCd,
            async: false,
            cache: false,
            success: function (data) {
                if (data.success > 0) {
                    jQuery("#chk-" + chk).removeClass("check-border");
                    jQuery("#chk-" + chk).addClass("uncheck-border");
                    jQuery("#chk-" + chk).attr("data-chk", "0");
                    cart.UpdateTotal();
                    checkBackAll();
                }
            }
        });
    }
    else {
        statusCd = 'NORMAL';
        $.ajax({
            type: "POST",
            url: "/Basket/UpdateBasketStatus?GUID=" + guidID + "&basketItemNo=" + basketItemNo + "&StatusCd=" + statusCd,
            async: false,
            cache: false,
            success: function (data) {
                if (data.success > 0) {
                    jQuery("#chk-" + chk).removeClass("uncheck-border");
                    jQuery("#chk-" + chk).addClass("check-border");
                    jQuery("#chk-" + chk).attr("data-chk", "1");
                    cart.UpdateTotal();
                    checkBackAll();
                }
            }
        });
    }
}

var chkCheck = true;
function checkBackAll() {
    var chkValue;
    for (var i = 1; i < itemTotal; i++) {
        chkValue = jQuery("#chk-" + i).attr("data-chk");
        if (chkValue == '0') {
            chkCheck = false;
            break;
        }
        else
            chkCheck = true;
    }

    if (chkCheck) {
        jQuery("#chk-all").removeClass("uncheck-border");
        jQuery("#chk-all").addClass("check-border");
        chkCheck = true;
    }
    else {
        jQuery("#chk-all").removeClass("check-border");
        jQuery("#chk-all").addClass("uncheck-border");
        chkCheck = false;
    }
}

/*---------------------------------------------------------------- End Check Item Cart ---------------------------------------------------------------*/

function ShowLoading() {
    jQuery('#ajaxloading').show();
}

function hideLoading() {
    jQuery('.body-mark').removeClass("active");
    jQuery(document.body).removeClass("modal-open");
}

function HideLoading() {
    jQuery('#ajaxloading').hide();
}

function showLoading() {
    jQuery('.body-mark').addClass("active");
    jQuery(document.body).addClass("modal-open");
}

/********************************************************************
* QueryString Function
* ===================================================================
* var qry = new QueryString();
* qry.GetValue("pid"); ==> read
* qry.SetValue("seq", "1234"); => Save
* qry.Load() ==> required
* qry.ToString();
********************************************************************/
var QueryString = function () {
    this.Data = [];
    this.Load();
}

QueryString.prototype.Load = function () {
    var aPairs, aTmp;
    var queryString = new String(window.location.search);
    queryString = queryString.substr(1, queryString.length); //remove "?"
    aPairs = queryString.split("&");

    for (var i = 0 ; i < aPairs.length; i++) {
        aTmp = aPairs[i].split("=");
        this.Data[aTmp[0]] = aTmp[1];
    }
}

QueryString.prototype.GetValue = function (key) {
    return this.Data[key];
}

QueryString.prototype.SetValue = function (key, value) {
    if (value == null)
        delete this.Data[key];
    else
        this.Data[key] = value;
}

QueryString.prototype.Clear = function () {
    delete this.Data;
    this.Data = [];
}

QueryString.prototype.ToString = function () {
    var queryString = new String("");

    for (var key in this.Data) {
        if (queryString != "")
            queryString += "&"
        if (this.Data[key])
            queryString += key + "=" + this.Data[key];
    }
    if (queryString.length > 0)
        return "?" + queryString;
    else
        return queryString;
}