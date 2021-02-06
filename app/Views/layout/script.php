<script>
    function pilihitem() {
        var item = <?= json_encode($item); ?>;

        var item_val = document.getElementById("item").value;
        var sub = document.getElementById('subdiv');
        const id = document.getElementById("item").value;
        if (item_val != '') {
            sub.style.display = '';
            var html = '<option value = "">-- Pilih Sub --</option>';
            for (ji in item) {
                var sub = item[ji][item_val];
                for (si in sub) {
                    var nama = sub[si].nama;
                    var idsub = sub[si].id;
                    html += '<option value=' + idsub + '>' + nama + '</option>';
                }
            }
            document.getElementById("sub").innerHTML = html;
        } else {
            sub.style.display = 'none';
        }
    }
</script>
<script>
    function profilpreview() {
        const gambar = document.querySelector('#gambar');
        const previewimg = document.querySelector('.lihat-gambar');

        const filegambar = new FileReader();
        filegambar.readAsDataURL(gambar.files[0]);

        filegambar.onload = function(e) {
            previewimg.src = e.target.result;
        }
    }
</script>