<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="robots" content="noindex, nofollow">
<title>Pembayaran</title>
<meta name="author" content="TriPay">
<meta name="csrf-token" content="4nNMGM4jhg6byv8dJCApBuNrOkuNxtEkQaOiVvcK">
<link rel="shortcut icon" href="<?= base_url(); ?>/tokolancer.ico">
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css">
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css">

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
<style>
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .bg {
        /* The image used */
        background-image: url("image/grass.jpg");

    }

    #bg {
        position: fixed;
        top: 0;
        left: 0;

        /* Preserve aspet ratio */
        min-width: 100%;
        min-height: 100%;
        z-index: -1;
    }

    .logo img {
        height: 40px;
        width: auto;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

    .box-shape {
        background-color: #fff;
        border-radius: 8px;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .payment__logo img,
    .merchant__logo img {
        height: 30px;
        width: auto;
    }

    .payment__title {
        font-size: 16px;
        font-weight: 600;
        color: #707070;
        text-align: center;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .payment__infoTitle {
        font-size: 14px;
        color: #98A3B2;
    }

    .payment__infoSubtitle {
        font-size: 15px;
        color: #2C4656;
        font-weight: 600;
    }

    .payment__expired {
        font-size: 18px;
        color: #FF5A92;
        font-weight: 600;
    }

    .icon-copy {
        cursor: pointer;
    }


    /* Payment */

    .box-payment {
        box-shadow: 0px 8px 16px 0px rgba(132, 132, 132, 0.16);
        -webkit-box-shadow: 0px 8px 16px 0px rgba(132, 132, 132, 0.16);
        -moz-box-shadow: 0px 8px 16px 0px rgba(132, 132, 132, 0.16);
        border-radius: 25px;
        background-color: #fff;
    }

    .title-payment {
        color: #394654;
        font-size: 22px;
        font-weight: bold;
    }

    .sub-title-payment {
        color: #707070;
        font-size: 16px;
        font-weight: 400;
    }

    .title-detail {
        color: #394654;
        font-size: 14px;
        font-weight: bold;
    }

    .title-detail-2 {
        color: #394654;
        font-size: 16px;
        font-weight: 400;
        opacity: 0.8;
    }

    .icon-copy {
        cursor: pointer;
        color: #ced4da;
    }

    .button-green {
        background-color: #25D366;
        color: #fff;
        border: none;
    }

    .button-green:hover {
        background-color: rgb(31, 196, 91);
        color: #fff;
        border: none;
    }


    .list-petunjuk-pembayaran {
        max-width: 500px;
        counter-reset: my-awesome-counter;
        list-style: none;
    }

    .list-petunjuk-pembayaran li {
        margin: 0 0 0.5rem 0;
        counter-increment: my-awesome-counter;
        position: relative;
    }

    .list-petunjuk-pembayaran li::before {
        content: counter(my-awesome-counter);
        color: white;
        position: absolute;
        font-size: 12px;
        --size: 20px;
        left: calc(-1 * var(--size) - 10px);
        line-height: var(--size);
        width: var(--size);
        height: var(--size);

        top: 0;
        border-radius: 50%;
        text-align: center;
        background: #d6d6d6;
    }

    .custom-accordion .card,
    .custom-accordion .card:last-child .card-header {
        border: none;
    }

    .custom-accordion .card-header {
        border-bottom-color: #EDEFF0;
        background: transparent;
    }

    .custom-accordion .fa-stack {
        font-size: 18px;
    }

    .custom-accordion li+li {
        margin-top: 10px;
    }

    .title-pembayaran {
        font-size: 16px;
        color: #394654;
        font-weight: 600;
    }

    .panel-title {
        color: #394654;
        opacity: 0.8;
    }

    .panel-title:hover {
        color: #394654;
        opacity: 0.8;
    }

    .panel-title::after {
        content: "\f107";
        color: #fff !important;
        top: 13px;
        right: 20px;
        position: absolute;
        font-family: "Font Awesome 5 Free";
        font-weight: 800;
    }

    .panel-title[aria-expanded="true"]::after {
        content: "\f106";
    }

    .background-payment {
        background-color: red;
    }

    @media screen and (max-width: 768px) {
        .payment__title {
            font-size: 14px;
        }

        .payment__infoTitle {
            font-size: 12px;
        }

        .payment__infoSubtitle {
            font-size: 14px;
        }

        .payment__expired {
            font-size: 14px;
        }

        .padding-mobile {
            padding: 20px !important;
        }

        .box-payment {
            box-shadow: 0px 6px 24px 0px rgba(0, 0, 0, 0.16);
            -webkit-box-shadow: 0px 6px 24px 0px rgba(0, 0, 0, 0.16);
            -moz-box-shadow: 0px 6px 24px 0px rgba(0, 0, 0, 0.16);
            border-radius: 15px;
            background-color: #fff;
        }

        .title-payment {
            color: #394654;
            font-size: 18px;
            font-weight: bold;
        }

        .sub-title-payment {
            color: #707070;
            font-size: 14px;
            font-weight: 400;
        }

        .custom-img-bank-mobile>img {
            width: auto !important;
            height: 2px !important;
        }

        .title-pembayaran {
            font-size: 16px;
            color: #394654;
            font-weight: 600;
        }

        .padding-modal-body-mobile {
            padding-left: 0.5rem !important;
        }

        .custom-padding-accordion>.card-header {
            padding-left: 0 !important;
        }

        .custom-padding-accordion-2>.card-body {
            padding-left: 0 !important;
        }
    }

    @media screen and (min-width: 768px) {
        .payment-info {
            box-shadow: 0px 0px 3px 2px #ddd;
            padding: 15px !important;
        }
    }

    .payment-instruction-head {
        background: #17a2b8 !important;
        padding: 5px 1.25rem !important;
    }

    .payment-instruction-head>h5>span {
        font-size: 16px !important;
        font-weight: bold !important;
        color: #fff !important;
    }

    .section-icon {
        display: block;
        background: #1b5724;
        color: #fff;
        text-align: center;
        width: 4em;
        height: 4em;
        -webkit-border-radius: 30em;
        border-radius: 30em;
        position: absolute;
        top: -2.1em;
        left: 50%;
        margin-left: -2em;
        line-height: 4.8em;
    }

    .section-icon.danger {
        background: #ac3430;
    }

    .fz-14 {
        font-size: 14px !important;
    }
</style>