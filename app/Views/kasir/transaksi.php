<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <div class="dashboard-header">
        <h2>Transaksi</h2>
    </div>

    <div class="transaksi-card">

        <!-- ================= ALERT ================= -->
        <?php if(session()->getFlashdata('error')): ?>
            <div id="alertBox" class="custom-alert error">
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div id="alertBox" class="custom-alert success">
                <div>
                    <?= session()->getFlashdata('success') ?>
                </div>

                <div class="alert-actions">
                    <a href="<?= base_url('kasir/cetakStruk/'.session()->getFlashdata('id_transaksi')) ?>" target="_blank">
                        <button class="btn-cetak">🧾 Cetak Struk</button>
                    </a>
                </div>
            </div>
        <?php endif; ?>


        <form action="<?= base_url('kasir/save-transaksi') ?>" method="post">

            <!-- ================= DATA SISWA ================= -->
            <h5 class="section-title">Data Siswa</h5>

            <input name="nama_siswa" class="custom-input" placeholder="Nama Siswa" required>
            <input name="no_hp" class="custom-input" placeholder="No. HP" required>
            <textarea name="alamat" class="custom-input" placeholder="Alamat"></textarea>


            <!-- ================= TANGGAL ================= -->
            <h5 class="section-title mt-20">Tanggal Kursus</h5>

            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="custom-input" required>

            <input type="text" id="tanggal_selesai_preview" class="custom-input"
                placeholder="Tanggal Selesai" readonly>


            <!-- ================= KATEGORI ================= -->
            <h5 class="section-title mt-20">Pilih Kategori</h5>

            <select id="kategori" class="custom-input">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"
                        data-deskripsi="<?= esc($c['deskripsi']) ?>">
                        <?= esc($c['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- 🔥 DESKRIPSI KATEGORI -->
            <div id="kategoriDeskripsi" class="kategori-box" style="display:none;"></div>


            <!-- ================= MAPEL ================= -->
            <h5 class="section-title mt-20">Pilih Mapel</h5>

            <div class="produk-container" id="produkContainer">
                <p style="text-align:center; color:#888;">Pilih kategori dulu</p>
            </div>


            <!-- ================= DURASI ================= -->
            <h5 class="section-title mt-20">Durasi (bulan)</h5>

            <input type="number" id="durasi" name="durasi"
                class="custom-input" placeholder="Masukan durasi" min="1" required>


            <!-- ================= TOTAL ================= -->
            <input id="total" type="text" class="custom-input"
                placeholder="Total Harga" readonly>


            <!-- ================= PEMBAYARAN ================= -->
            <input name="uang_bayar" id="uang_bayar" type="number"
                class="custom-input" placeholder="Uang Bayar" required>

            <input id="kembalian" type="text"
                class="custom-input" placeholder="Kembalian" readonly>


            <!-- ================= BUTTON ================= -->
            <div class="btn-area">
                <button type="submit" class="btn-daftar">
                    Simpan Transaksi
                </button>
            </div>

        </form>

    </div>
</div>


<script>
// ================= DESKRIPSI KATEGORI =================
document.getElementById('kategori').addEventListener('change', function(){

    let selected = this.options[this.selectedIndex];
    let deskripsi = selected.getAttribute('data-deskripsi');
    let box = document.getElementById('kategoriDeskripsi');

    if(deskripsi){
        box.style.display = 'block';
        box.innerHTML = `
            <div class="kategori-card">
                <div class="kategori-icon">📚</div>
                <h6>${selected.text}</h6>
                <p>${deskripsi}</p>
            </div>
        `;
    } else {
        box.style.display = 'none';
    }
});


// ================= FORMAT RUPIAH =================
function rupiah(angka){
    return angka.toLocaleString('id-ID');
}

// ================= HITUNG TOTAL =================
function hitungTotal(){

    let durasi = parseInt(document.getElementById('durasi').value) || 0;
    let total = 0;

    document.querySelectorAll('.pilihProduk:checked').forEach(item=>{
        total += parseInt(item.dataset.harga) * durasi;
    });

    document.getElementById('total').value =
        total > 0 ? 'Rp ' + rupiah(total) : '';

    let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
    let kembali = bayar - total;

    document.getElementById('kembalian').value =
        kembali >= 0 ? 'Rp ' + rupiah(kembali) : '';

    hitungTanggalSelesai();
}

// ================= HITUNG TANGGAL =================
function hitungTanggalSelesai(){

    let mulai = document.getElementById('tanggal_mulai').value;
    let durasi = parseInt(document.getElementById('durasi').value) || 0;

    if(mulai && durasi){
        let t = new Date(mulai);
        t.setMonth(t.getMonth() + durasi);
        let selesai = t.toISOString().split('T')[0];
        document.getElementById('tanggal_selesai_preview').value = selesai;
    }
}

// ================= LOAD PRODUK =================
document.getElementById('kategori').addEventListener('change', function(){

    let id = this.value;
    let container = document.getElementById('produkContainer');

    if(!id){
        container.innerHTML = "<p style='text-align:center;'>Pilih kategori dulu</p>";
        return;
    }

    container.innerHTML = "Loading...";

    fetch("<?= base_url('kasir/get-produk') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id_kategori=" + id
    })
    .then(res => res.json())
    .then(data => {

        if(data.length === 0){
            container.innerHTML = "<p style='text-align:center;'>Tidak ada mapel</p>";
            return;
        }

        let html = "";

        data.forEach(p => {

            let status = p.kuota > 0 ? 'Tersedia' : 'Penuh';
            let statusClass = p.kuota > 0 ? 'badge-ready' : 'badge-full';
            let disabled = p.kuota > 0 ? '' : 'disabled';

            html += `
            <label class="produk-card ${disabled ? 'disabled' : ''}">

                <input type="checkbox"
                    name="id_produk[]"
                    value="${p.id}"
                    data-harga="${p.harga_produk}"
                    class="pilihProduk"
                    ${disabled}
                    hidden>

                <div class="produk-inner">

                    <div class="produk-header">
                        <div class="produk-icon">📘</div>
                        <div>
                            <h6>${p.nama_produk}</h6>
                            <small>${p.jam_kursus}</small>
                        </div>
                    </div>

                    <div class="produk-detail-modern">

                        <div class="row">
                            <span>Kuota</span>
                            <strong>${p.kuota}</strong>
                        </div>

                        <div class="row">
                            <span>Harga</span>
                            <strong>Rp ${rupiah(parseInt(p.harga_produk))}</strong>
                        </div>

                        <div class="row">
                            <span>Status</span>
                            <span class="${statusClass}">${status}</span>
                        </div>

                    </div>

                    <div class="btn-pilih-modern">
                        ${p.kuota > 0 ? 'Pilih' : 'Penuh'}
                    </div>

                </div>
            </label>
            `;
        });

        container.innerHTML = html;

        // aktifkan event
        document.querySelectorAll('.pilihProduk').forEach(item=>{
            item.addEventListener('change', hitungTotal);
        });

    });
});

// ================= EVENT =================
document.getElementById('durasi').addEventListener('input', hitungTotal);
document.getElementById('uang_bayar').addEventListener('input', hitungTotal);
document.getElementById('tanggal_mulai').addEventListener('change', hitungTotal);

// ================= AUTO CLOSE ALERT =================
setTimeout(() => {
    let alert = document.getElementById('alertBox');
    if(alert){
        alert.style.opacity = '0';
        setTimeout(()=> alert.remove(), 500);
    }
}, 4000);
</script>

<?= view('layout/footer') ?>