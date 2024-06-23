<?php
    require_once '../layout/_top.php';
?>
<div class="text-sm breadcrumbs bg-black opacity-50 pt-20 pb-3 text-white ps-5">
    <ul>
        <li><a>Beranda</a></li> 
        <li><a>Info Pembayaran</a></li> 
    </ul>
</div>

<span class="grid justify-center min-h-[15rem]">
    <h1 class="text-center text-4xl font-bold mt-5 mb-10">Metode Pembayaran</h1>

    <span class="flex items-center justify-center gap-10 mb-10 text-white">
        <!--TUNAI  -->
        <div class="card w-96 bg-gray-800 shadow-xl" data-aos="zoom-out">
            <div class="card-body">
                <h2 class="text-center font-bold text-3xl mb-5">
                    Tunai
                </h2>
            
                <span class="grid gap-1 ms-5">
                    <li>Cek Jadwal Pembayaran</li>
                    <li>Persiapkan Dokumen yang diperlukan</li>
                    <li>Kunjungi Tata Usaha Sekolah</li>
                    <li>Mengisi Formulir Pembayaran</li>
                </span>
            </div>
        </div>
        <!--END TUNAI  -->

        <!--NON TUNAI  -->
        <div class="card w-96 bg-gray-800 shadow-xl" data-aos="zoom-out">
            <div class="card-body">
                <h2 class="text-center font-bold text-3xl mb-5">
                    Non Tunai
                </h2>

                <span class="grid gap-1 ms-10">
                    <li>Transfer BANK</li>
                    <li> Virtual Account</li>
                    <li>Barcode atau Qris</li>
                    <li>Dompet Digital</li>
                </span>
            </div>
        </div>
        <!--END END TUNAI  -->
    </span>
</span>


<?php
    require_once '../layout/_bottom.php';
?>