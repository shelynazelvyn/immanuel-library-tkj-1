<?php
// print, hanya menerima 1 argumen saja
print("Hello world");

echo "Hello"," ","world";

echo "\n";

// Echo, Bisa menerima lebih dari 1 argumen,dipakai untuk memeunculkan output di browser html
echo "Hello wordl";


echo "\n";

// print_r,Biasanya digunakan untuk mengecek nilai dari variabel untuk kebutuhan debugging terutama itu tipe data array dari object
// jadi misalnya print_r itu untuk mengecek tipe data dari object karena echo dan orint tidak bisa mengecek tipe data array dari object   
// kalau misalnya ada tipe data array dari object kalau kita menggunakan print dan echo untuk mengecek array dia akan error jadi makanya biasanya echo kita menggunakan untuk memunculkan output di browser,sedangkan print dan echo kita cuman pakai di debugging aja,jadi kalau kita mau mengecek variabel debugging kita pakai print atau print_r,tapi kebanyakan untuk memunculkan output kita pakai echo kalau untuk debugging kita pakai print_r kenapa iru karena echo biasanya lebih cepat dari pada print sedikit lebih cepat echo dari pada print karena echo itu tidak punya nilai kembalian
print_r("Hello world");



?>