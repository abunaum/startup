<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cekmutasi.co.id/component/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cekmutasi.co.id/component/jquery-ui/js/jquery.blockUI.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".fancybox").fancybox();

    });

    function returnToMerchant() {
        window.open('<?= base_url('user/saldo') ?>');
    }

    function startLoader(element = null, text = null) {
        var msg = '<div class="lds-dual-ring"></div>';
        if (text != null) {
            msg += '<br/><br><span class="loader-text" style="font-size:[font_size]px;color:gainsboro;font-weight:500">' + text + '</span>';
        }

        var screenWidth = $(window).width();
        var screenHeight = $(window).height();

        if (element != null) {
            var elementWidth = $(element).width();
            var elementHeight = $(element).height();

            var fontSize = (elementWidth * 0.035).toFixed(1);
            fontSize = fontSize > 20 ? 20 : fontSize;
            var imgWidth = ((elementWidth * elementHeight) * 0.0003).toFixed(1);
            imgWidth = imgWidth > 100 ? 100 : imgWidth;

            msg = msg.replace('[max_image_width]', imgWidth);
            msg = msg.replace('[font_size]', fontSize);

            var loaderHeight = (elementHeight / 2) - 15;
            loaderHeight = loaderHeight.toFixed(1);
            if (text != null) {
                loaderHeight = loaderHeight - 20;
            }

            $(element).block({
                css: {
                    border: 'none',
                    top: loaderHeight + 'px',
                    backgroundColor: 'transparent',
                    'z-index': 10000
                },
                message: msg
            });
            $(".blockOverlay").css('z-index', 9999);
        } else {
            var fontSize = (screenWidth * 0.035).toFixed(1);
            fontSize = fontSize > 20 ? 20 : fontSize;
            var imgWidth = ((screenWidth * screenHeight) * 0.0003).toFixed(1);
            imgWidth = imgWidth > 100 ? 100 : imgWidth;

            msg = msg.replace('[max_image_width]', imgWidth);
            msg = msg.replace('[font_size]', fontSize);

            var loaderHeight = (screenHeight / 2) - 15;
            loaderHeight = loaderHeight.toFixed(1);
            if (text != null) {
                loaderHeight = loaderHeight - 20;
            }

            $.blockUI({
                css: {
                    border: 'none',
                    top: loaderHeight + 'px',
                    backgroundColor: 'transparent',
                    'z-index': 10000
                },
                message: msg
            });
            $(".blockOverlay").css('z-index', 9999);
        }
    }

    function stopLoader(element = null) {
        if (element != null) {
            $(element).unblock();
        } else {
            $.unblockUI();
        }
    }

    function loaderText(text, element = null) {
        if (element != null) {
            $(element).find('.loader-text').text(text);
        } else {
            $('.loader-text').text(text);
        }
    }

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "100",
        "hideDuration": "100",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function copy(text) {
        var copyText = document.getElementById(text);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
        console.log(text)
    }
</script>