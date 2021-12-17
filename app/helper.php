<?php
/* generate invoice number */
function generate_estimatecode(){
    $code_prefix='EST-';
    $estimatenumber = App\Estimate::Orderby('id', 'desc')->first();
    if($estimatenumber && $estimatenumber->estimate_number!=""){
        /* if estimate not empty */
        $code=explode("-", $estimatenumber->estimate_number);
        $new_code = $code[1] + 1;
        $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
        return $code_prefix.$new_code;
    }else{
        /* if estimate code is empty set start */
        return $code_prefix.'0001';
    }
}

/* generate invoice number */
function generate_invoicenumber(){
$code_prefix='INV-';
$invoicenumber = App\Invoice::Orderby('id', 'desc')->first();
if($invoicenumber && $invoicenumber->invoice_number!=""){
/* if invoice code not empty */
$code=explode("-", $invoicenumber->invoice_number);
$new_code = $code[1] + 1;
$new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
return $code_prefix.$new_code;
}else{
/* if invoice code is empty set start */
return $code_prefix.'0001';
}
}

/* generate payment number */
function generate_paymentnumber(){
    $code_prefix='PAY-';
    $paymentnumber = App\Payment::Orderby('id', 'desc')->first();
    if($paymentnumber && $paymentnumber->payment_number!=""){
        /* if invoice code not empty */
        $code=explode("-", $paymentnumber->payment_number);
        $new_code = $code[1] + 1;
        $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
        return $code_prefix.$new_code;
    }else{
        /* if payment code is empty set start */
        return $code_prefix.'0001';
    }
}

/*Version Info */
function version_display()
{
    $versionFile = File::get(base_path('version.txt'));
    if ($versionFile) {
        $versionMsg = 'v' . $versionFile;
    } else {
        $versionMsg = null;
    }
    return $versionMsg;
}


/* date format */
function dateFormat($date)
{
    $settings = new App\MasterSetting();
    $site = $settings->siteData();
    $date_format = (isset($site['default_dateformat']) && !empty($site['default_dateformat']) ) ? $site['default_dateformat'] : 'd-M-Y';
    $date_format_new = date($date_format, strtotime($date));
    return $date_format_new;

}

/* generate invoice number */
function generate_customerinvoicenumber(){
    $code_prefix='CUINV-';
    $invoicenumber = App\CustomerPaymentHistory::Orderby('id', 'desc')->first();
    if($invoicenumber && $invoicenumber->invoice_number!=""){
    /* if invoice code not empty */
    $code=explode("-", $invoicenumber->invoice_number);
    $new_code = $code[1] + 1;
    $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
    return $code_prefix.$new_code;
    }else{
    /* if invoice code is empty set start */
    return $code_prefix.'0001';
    }
    }


    /* currency */

function getCurrency() {

        $settings = new App\MasterSetting();
        $site = $settings->siteData();
        $currency = ($site['default_currency'] && $site['default_currency']) !=""? $site['default_currency'] : '₹';
        return $currency;
    }


/* generate order number */
function generate_ordernumber(){
    $code_prefix='ORD-';
    $ordernumber = App\Order::Orderby('id', 'desc')->first();
    if($ordernumber && $ordernumber->order_number!=""){
        /* if order code not empty */
        $code=explode("-", $ordernumber->order_number);
        $new_code = $code[1] + 1;
        $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
        return $code_prefix.$new_code;
    }else{
        /* if order code is empty set start */
        return $code_prefix.'0001';
    }
}

/* get Razorpay status */
function getRazorpayStatus() {
    $settings = new App\MasterSetting();
    $site = $settings->siteData();
    if(isset($site['razorpay_status']) && !empty($site['razorpay_status'])  && ($site['razorpay_status']==1)) {
        return '1';
    } else {
        return '0';
    }
}

/* get stripe status */
function getStripeStatus() {
    $settings = new App\MasterSetting();
    $site = $settings->siteData();
    if(isset($site['stripe_status']) && !empty($site['stripe_status'])  && ($site['stripe_status']==1)) {
        return '1';
    } else {
        return '0';
    }
}

/* get Paypal status */
function getPaypalStatus() {
    $settings = new App\MasterSetting();
    $site = $settings->siteData();
    if(isset($site['paypal_status']) && !empty($site['paypal_status'])  && ($site['paypal_status']==1)) {
        return '1';
    } else {
        return '0';
    }
}
?>
