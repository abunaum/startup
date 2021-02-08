<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cekmutasi.co.id/component/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cekmutasi.co.id/component/jquery-ui/js/jquery.blockUI.js"></script>
<!-- <script type="text/javascript" src="https://gitcdn.xyz/repo/abunaum/naum-market-css-js/master/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://gitcdn.xyz/repo/abunaum/naum-market-css-js/master/jquery.blockUI.js"></script> -->

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {

        var numberref = document.getElementById("noReferensi").value;

        $(".fancybox").fancybox();
        setInterval(function() {
            var urlreq = "<?= base_url(); ?>";
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resarr = JSON.parse(this.responseText);
                    var status = resarr.status;
                    if (status == 'lunas') {
                        returnToMerchant();
                    }
                }
            }
            xhr.open('POST', urlreq+"/cekpembayaran/"+numberref, true);
            xhr.send(null);
        }, 10 * 1000);
    });

    function returnToMerchant() {
        var go = '<?= base_url('user/saldo/topup?status='); ?>';
        var numberref = document.getElementById("noReferensi").value;
        window.location.replace(go+numberref);
    }

    function copy(text) {
        var copyText = document.getElementById(text);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
        console.log(text)
    }
</script>