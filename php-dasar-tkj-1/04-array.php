<?php
// Array Biasa
$name = ['Ruby','Ryo','Caroline','Chriswel'];
echo $name[2];

// Array Asosiatif
$profile = [
    'name' => 'Anderson',
    'age' => 16,
    'nis' => '001'
];
echo $profile['nis'];

// Array Multidimensi
$student = [
    ['nis' => '001','name'=> 'Anderson'],
    ['nis' => '002','name' => 'Ruby']
];
echo $student[0]['name'];

?>