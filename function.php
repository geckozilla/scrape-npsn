<?php

$uri_nasional = 'http://referensi.data.kemdikbud.go.id/index11.php';
$uri_provinsi = 'http://referensi.data.kemdikbud.go.id/index11.php?level=1&kode=';
$uri_kabupaten = 'http://referensi.data.kemdikbud.go.id/index11.php?level=2&kode=';
$uri_kecamatan = 'http://referensi.data.kemdikbud.go.id/index11.php?level=3&kode=';
$uri_sekolah = 'http://referensi.data.kemdikbud.go.id/tabs.php?npsn=20500509';

# print_r (get_provinsi($uri_nasional));
function get_provinsi($uri_nasional) {
	## mendapatkan nama-nama provinsi + id provinsi
	

	$html = file_get_html($uri_nasional);

	$no = 0;
	foreach($html->find('#box-table-a tr') as $article) {
		 	$no = $no + 1;
			$res[$no]['nama']	= $article->find('a', 0)->plaintext;
			$res[$no]['id_prov']	= substr($article->find('a', 0)->href, 17, 6);
		 
	}

	unset($res[0]);
	unset($res[1]);
	unset($res[2]);
	return $res;
}


function get_kabupaten($uri_provinsi,$kode,$nama_prov) {
	## mendapatkan nama-nama kabupaten
	# //http://referensi.data.kemdikbud.go.id/index11.php?kode=050000&level=1

	$html = file_get_html($uri_provinsi.$kode);

	$no = 0;
	foreach($html->find('#box-table-a tr') as $article) {
		 $no = $no + 1;
			$res[$no]['id_prov']	= $kode;
			$res[$no]['nama_prov']	= $nama_prov;
		 	$res[$no]['nama_kab']	= trim($article->find('a', 0)->plaintext);
			$res[$no]['id_kab']	= trim(substr($article->find('a', 0)->href, 17, 6));
			
			
	}

	unset($res[0]);
	unset($res[1]);
	unset($res[2]);
	return $res;
}


function get_kecamatan($uri_kabupaten,$kode,$nama_kab,$id_prov,$nama_prov) {
	## mendapatkan nama-nama kabupaten
	# //http://referensi.data.kemdikbud.go.id/index11.php?kode=051700&level=2

	$html = file_get_html($uri_kabupaten.$kode);

	$no = 0;
	foreach($html->find('#box-table-a tr') as $article) {
		if (is_object($article)) {
			$no = $no + 1;
			$res[$no]['nama_prov']	= $nama_prov;
			$res[$no]['id_prov']	= $id_prov;
			$res[$no]['nama_kab']	= $nama_kab;
			$res[$no]['id_kab']	= $kode;
			$res[$no]['nama_kec']	= $article->find('a', 0)->plaintext;
			$res[$no]['id_kec']	= substr($article->find('a', 0)->href, 17, 6);
		}
	}

	unset($res[0]);
	unset($res[1]);
	unset($res[2]);
	return $res;
}



function get_sekolah($uri_kecamatan,$kode,$nama_kec,$id_kab,$nama_kab,$id_prov,$nama_prov) {
	## mendapatkan nama-nama kabupaten
	# //http://referensi.data.kemdikbud.go.id/index11.php?kode=051701&level=3

	$html = file_get_html($uri_kecamatan.$kode);

	$no = 0;
	foreach($html->find('.display tr') as $article) {
		$no = $no + 1;

			$item[$no]['nama_prov']	= $nama_prov;
			$item[$no]['id_prov']	= $id_prov;
			$item[$no]['nama_kab']	= $nama_kab;
			$item[$no]['id_kab']	= $id_kab;
			$item[$no]['nama_kec']	= $nama_kec;
			$item[$no]['id_kec']	= $kode;
			$item[$no]['nama_sek']	= $article->find('td', 2)->plaintext;
			$item[$no]['npsn']	= substr($article->find('a', 0)->href, -8);
			$item[$no]['alamat']	= $article->find('td', 3)->plaintext;
			$item[$no]['desa']	= $article->find('td', 4)->plaintext;
			$item[$no]['status']	= $article->find('td', 5)->plaintext;

	}

	unset($item[0]);
	unset($item[1]);
	unset($item[2]);
	return $item;
}



# 12. REDIRECT
#===================
function redirect($url=false, $time = 0) {
	$url = $url ? $url : $_SERVER['HTTP_REFERER'];
	
	if(!headers_sent()){
		if(!$time){
			header("Location: {$url}"); 
		}else{
			header("refresh: $time; {$url}");
		}
	}else{
		echo "<script> setTimeout(function(){ window.location = '{$url}' },". ($time*1000) . ")</script>";	
	}
}
