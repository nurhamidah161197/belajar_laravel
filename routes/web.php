<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

// Route::group( ['middleware' => 'guest' ], function()
// {
//     Route::get('login', 'Auth\LoginController@index')->name('login');
//     Route::post('login', 'Auth\LoginController@postLogin');
// });

// Route::group( ['middleware' => 'auth' ], function()
// {
//     Route::get('', function () {
//         return redirect()->route('home');
//     });

    Route::get('home', 'HomeController@index');

//     Route::get('userplk', 'SettingUserController@plk');
//     Route::get('userp3k', 'SettingUserController@p3k');
//     Route::get('useradmin', 'SettingUserController@admin');
//     Route::get('user/getdata/{modul}', 'SettingUserController@getdata');
//     Route::post('user', 'SettingUserController@store');
//     Route::get('user/getusername/{modul}/{id}', 'SettingUserController@getusername');
//     Route::delete('user/{modul}/{id}', 'SettingUserController@destroy');

//     Route::get('organisasiplk', 'SettingOrganisasiController@plk');
//     Route::get('organisasip3k', 'SettingOrganisasiController@p3k');
//     Route::get('organisasi/getdata/{modul}', 'SettingOrganisasiController@getdata');
//     Route::post('organisasi', 'SettingOrganisasiController@store');
//     Route::get('organisasi/getorg/{id}', 'SettingOrganisasiController@getorg');
//     Route::delete('organisasi/{id}', 'SettingOrganisasiController@destroy');

//     Route::get('jenispengukuran', 'SettingJenisUkurController@index');
//     Route::get('jenispengukuran/getdata', 'SettingJenisUkurController@getdata');
//     Route::post('jenispengukuran', 'SettingJenisUkurController@store');
//     Route::get('jenispengukuran/getjenis/{id}', 'SettingJenisUkurController@getjenis');
//     Route::delete('jenispengukuran/{id}', 'SettingJenisUkurController@destroy');

//     Route::get('nab', 'SettingNABController@index');
//     Route::get('nab/getdata', 'SettingNABController@getdata');
//     Route::post('nab', 'SettingNABController@store');
//     Route::get('nab/getnab/{id}', 'SettingNABController@getnab');
//     Route::delete('nab/{id}', 'SettingNABController@destroy');

//     Route::get('daftarnab/{id}', 'SettingNilaiNABController@index');
//     Route::get('daftarnab/getdata/{id}', 'SettingNilaiNABController@getdata');
//     Route::post('daftarnab', 'SettingNilaiNABController@store');
//     Route::get('daftarnab/getnab/{id}', 'SettingNilaiNABController@getnab');
//     Route::get('daftarnab/getjenisukur/{id}', 'SettingNilaiNABController@getjenisukur');
//     Route::delete('daftarnab/{id}', 'SettingNilaiNABController@destroy');

//     Route::get('lokasi', 'SettingLokasiPengController@index');
//     Route::get('lokasi/getdata', 'SettingLokasiPengController@getdata');
//     Route::post('lokasi', 'SettingLokasiPengController@store');
//     Route::get('lokasi/getlokasi/{id}', 'SettingLokasiPengController@getlokasi');
//     Route::delete('lokasi/{id}', 'SettingLokasiPengController@destroy');

//     Route::get('p3k', 'SettingP3KController@index');
//     Route::get('p3k/getdata', 'SettingP3KController@getdata');
//     Route::post('p3k', 'SettingP3KController@store');
//     Route::get('p3k/getbarang/{id}', 'SettingP3KController@getbarang');
//     Route::delete('p3k/{id}', 'SettingP3KController@destroy');

//     Route::get('lokasip3k', 'SettingLokasiP3KController@index');
//     Route::get('lokasip3k/getdata', 'SettingLokasiP3KController@getdata');
//     Route::post('lokasip3k', 'SettingLokasiP3KController@store');
//     Route::get('lokasip3k/getlokasi/{id}', 'SettingLokasiP3KController@getlokasi');
//     Route::delete('lokasip3k/{id}', 'SettingLokasiP3KController@destroy');

//     Route::get('pengukuranlingkerja', 'listLingkunganKerjaController@index');
//     Route::get('pengukuranlingkerja/getdata', 'listLingkunganKerjaController@getdata');
//     Route::post('pengukuranlingkerja', 'listLingkunganKerjaController@store');
//     // Route::get('pengukuranlingkerja/getdata/{year}/{assrc}/{keg}/{org}', 'ListInternalController@getdata');
//     // Route::get('pengukuranlingkerja/excel/{year}/{assrc}/{keg}/{org}', 'ListInternalController@exportExcel');

//     Route::get('kesimpulanpengukuran/{id}', 'lapConcLingkunganKerjaController@index');
//     Route::get('kesimpulanpengukuran/getpetugas/{id}', 'lapConcLingkunganKerjaController@getpetugas');
//     Route::post('kesimpulanpengukuran/kesimpulan', 'lapConcLingkunganKerjaController@storekesimpulan');
//     Route::post('kesimpulanpengukuran/keterangan', 'lapConcLingkunganKerjaController@storeketerangan');
//     Route::post('kesimpulanpengukuran/tindaklanjut', 'lapConcLingkunganKerjaController@storetindaklanjut');
//     Route::post('kesimpulanpengukuran/status/{id}/{status}', 'lapConcLingkunganKerjaController@storestatus');

//     Route::get('laporanpengukuran/{id}', 'lapLingkunganKerjaController@index');
//     Route::get('laporanpengukuran/lokasi/{id}', 'lapLingkunganKerjaController@getlokasi');
//     Route::get('laporanpengukuran/gettitik/{id}', 'lapLingkunganKerjaController@gettitik');
//     Route::get('laporanpengukuran/getlokukur/{id}', 'lapLingkunganKerjaController@getlokukur');
//     Route::post('laporanpengukuran/titik', 'lapLingkunganKerjaController@storetitik');
//     Route::post('laporanpengukuran/lokasi', 'lapLingkunganKerjaController@storelokasi');
//     Route::get('laporanpengukuran/hasil/{id}', 'lapLingkunganKerjaController@gethasil');
//     Route::post('laporanpengukuran/hasil', 'lapLingkunganKerjaController@storehasil');

//     Route::get('inspeksip3k', 'listInspeksiController@index');
//     Route::get('inspeksip3k/getdata/{bulan}', 'listInspeksiController@getdata');
//     Route::post('inspeksip3k', 'listInspeksiController@store');

//     Route::get('laporaninspeksi/{id}', 'lapInspeksiController@index');
//     Route::get('laporaninspeksi/hasil/{id}', 'lapInspeksiController@gethasil');
//     Route::post('laporaninspeksi/hasil', 'lapInspeksiController@storehasil');
//     Route::post('laporaninspeksi/status/{id}/{status}', 'lapInspeksiController@storestatus');

//     Route::get('datastokp3k', 'DataStokP3KController@index');
//     Route::get('datastokp3k/getalldata/{date}', 'DataStokP3KController@getalldata');
//     Route::post('datastokp3k', 'DataStokP3KController@store');

//     Route::get('pengukuranchart/{year}/{jenis}/{lokasi}', 'PengukuranChartController@index');
//     Route::get('pengukuranchart/getdata/{year}/{jenis}/{lokasi}', 'PengukuranChartController@getdata');

//     Route::get('broadcastp3k', 'BroadcastEmailP3KController@index');
//     Route::post('broadcastp3k/sendmail', 'BroadcastEmailP3KController@sendMail');

//     Route::get('logout', function(Request $request){
//         Auth::logout();
//         $request->session()->flush();
//         return redirect()->route('login');
//     });
// });
