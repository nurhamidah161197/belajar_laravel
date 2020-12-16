<?php

// use DB;

function kdauto($inisial, $tabel){

    // dd($tabel);
    DB::enableQueryLog();
    $column   = DB::select("SELECT COLUMN_NAME
                            FROM INFORMATION_SCHEMA.COLUMNS
                            WHERE  TABLE_NAME = '".$tabel."'");

    // dd(DB::getQueryLog());
    $len      = DB::select("SELECT MAX(CHAR_LENGTH(".$column[0]->COLUMN_NAME.")) len
                            FROM ".$tabel);

    $max      = DB::select("SELECT MAX(".$column[0]->COLUMN_NAME.") max FROM ".$tabel);

    if ($max[0]->max == "") {
         $angka = 0;
    }
    else {
         $angka		= (int)substr($max[0]->max, strlen($inisial)) + 1;
    }

    $tmp	= "";
    for($i=1; $i<=(($len[0]->len)-strlen($inisial)-strlen($angka)); $i++) {
        $tmp = $tmp."0";
    }

    return $inisial.$tmp.$angka;
}
