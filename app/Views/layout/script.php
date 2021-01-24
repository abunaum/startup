<script>
    function pilihitem() {
        const id = document.getElementById("item").value;
        var sub = document.getElementById('subdiv');
        if (id == '') {
            sub.style.display = 'none';
        } else {
            sub.style.display = '';
            const http = new XMLHttpRequest();
            http.addEventListener("load", () => {
                const subitem = JSON.parse(http.response);
                if (subitem < 1) {
                    var html = '';
                    sub.style.display = 'none';
                } else {
                    var html = '';
                    var i;
                    for (i = 0; i < subitem.length; i++) {
                        html += '<option value=' + subitem[i].id + '>' + subitem[i].nama + '</option>';
                    }
                }
                document.getElementById("sub").innerHTML = html;
            });
            http.open("POST", "<?= base_url('cariitem') ?>/" + id); // tentukan server tujuan
            http.send();
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