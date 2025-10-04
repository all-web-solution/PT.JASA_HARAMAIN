<?php
// $target = '/home/domains/haramain.allcode.my.id/SERVICE-SYSTEM-PT-JASAHARAMAIN/storage/app/public';
// $link = '/home/domains/haramain.allcode.my.id/public_html/storage';
$target = '/home/allcode1/domains/haramain.allcode.my.id/SERVICE-SYSTEM-PT-JASAHARAMAIN/storage/app/public';
$link = '/home/allcode1/domains/haramain.allcode.my.id/public_html/storage';

if (!is_dir($target)) {
    die("Direktori target tidak ditemukan: $target\n");
}

if (is_link($link)) {
    unlink($link);
    echo "Link yang ada telah di hapus: $link\n";
}

if (symlink($target, $link)) {
    echo "Symlink berhasil dibuat dari $link ke $target \n";
} else {
    echo "Gagal memuat symlink dari $link ke $target\n";
}
?>