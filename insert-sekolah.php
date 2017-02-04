<?php
$page = 0;
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 0;
}

error_reporting(0);
include('simple_html_dom.php');
include('function.php');
include('NotORM.php');

$dsn = "mysql:dbname=sekolah;host=127.0.0.1";
$pdo = new PDO($dsn, "root", "");
$db = new NotORM($pdo);

$jumlah = $db->kecamatan()->count("id");

$file = basename(__FILE__); 

$kecamatan = $db->kecamatan()
    ->select("id,nama_prov,id_prov,nama_kab,id_kab,nama_kec,id_kec")
    ->order("id")
    ->limit(1,$page)
    ;

$sekolah = $db->sekolah();    


foreach ($kecamatan as $r) {


    echo $r['nama_kec'];
   
        //*
        $data =  get_sekolah($uri_kecamatan,$r['id_kec'],$r['nama_kec'],$r['id_kab'],$r['nama_kab'],$r['id_prov'],$r['nama_prov']);
       // var_dump($data);
        ///*
            foreach ($data as $dat) {
                $result = $sekolah->insert($dat);
            }
        // */
    
	echo '<hr />';
}




if ($_GET['page'] > $jumlah) {
	echo 'HABIS';
} else {
//*
$next = $page + 1;
redirect('http://localhost/'.$file.'?page='.$next,1);
//*/
}




