<?php

namespace App\Http\Controllers;

use App\Pages;
use App\Asset;
use App\Province;
use App\City;
use App\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->latest()->paginate(9);
        $pages = '0';
        $asset_types = AssetType::all();
        $provinces = Province::all();
        $cities = City::all();

        return view('projects.asset.index')
            ->with(compact('pages'))
            ->with(compact('asset_types'))
            ->with(compact('provinces'))
            ->with(compact('cities'))
            ->with(compact('assets'));
    }

    public function index_user(Pages $pages)
    {
        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->latest()->paginate(9);

        $asset_types = AssetType::all();
        $provinces = Province::all();
        $cities = City::all();

        return view('projects.asset.index')
            ->with(compact('pages'))
            ->with(compact('asset_types'))
            ->with(compact('provinces'))
            ->with(compact('cities'))
            ->with(compact('assets'));
    }

    public function list()
    {
        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->paginate(10);
        $cities = City::all();
        $provinces = Province::all();

        // dump($assets);die;

        return view('layouts.admin.asset.listAsset')
            ->with(compact('assets'))
            ->with(compact('cities'))
            ->with(compact('provinces'));
    }

    public function filter_list(Request $request)
    {
        $cities = City::all();
        $provinces = Province::all();

        $city_id = array();
        $province_id = array();

        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->get();

        if (!empty($request->judulSearch)) {
            foreach ($cities as $city) {
                if (stripos($city->kota, $request->judulSearch) !== false) {
                    $city_id[] = $city->id;
                }
            }

            foreach ($provinces as $province) {
                if (stripos($province->provinsi, $request->judulSearch) !== false) {
                    $province_id[] = $province->id;
                }
            }

            foreach ($assets as $key => $asset) {
                $lokasi = explode(',', $asset->lokasi);

                if (!empty($city_id) && !empty($province_id)) {

                    foreach ($city_id as $city) {
                        foreach ($province_id as $province) {
                            if (!($lokasi[0] == $city) && !($lokasi[1] == $province) && stripos($asset->judul, $request->judulSearch) === false) {
                                $assets->forget($key);
                            }
                        }
                    }
                } elseif (!empty($city_id)) {

                    foreach ($city_id as $city) {
                        if (!($lokasi[0] == $city) && stripos($asset->judul, $request->judulSearch) === false) {
                            $assets->forget($key);
                        }
                    }
                } elseif (!empty($province_id)) {

                    foreach ($province_id as $province) {
                        if (!($lokasi[1] == $province) && stripos($asset->judul, $request->judulSearch) === false) {
                            $assets->forget($key);
                        }
                    }
                } else {
                    if (stripos($asset->judul, $request->judulSearch) === false && stripos($asset->tipe, $request->judulSearch) === false) {
                        $assets->forget($key);
                    }
                }
            }
        }

        $assets = collect($assets->values());

        $assets = $this->paginate($assets, $perPage = 10, request('page'), $options = ['path' => '/dashboard/admin/asset/filter', 'pageName' => 'page']);

        return view('layouts.admin.asset.listAsset')
            ->with(compact('assets'))
            ->with(compact('cities'))
            ->with(compact('provinces'));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asset_types = AssetType::all();
        $provinces = Province::all();
        $cities = City::all();
        return view('layouts.admin.asset.createAsset')
            ->with(compact('asset_types'))
            ->with(compact('provinces'))
            ->with(compact('cities'));
    }

    public function getCities(Request $request)
    {
        $cities = Province::find($request->province)->cities;

        if ($request->province !== "Pilih Provinsi") {
            return $cities;
        }
    }

    public function getAllCities()
    {
        $cities = City::all();
        return $cities;
    }

    public function getLokasi($lokasi)
    {
        $dataLokasi =  explode(',',  $lokasi);
        return $dataLokasi;
    }

    public function filter(Request $request)
    {

        $provinces = Province::orderBy('provinsi', 'asc')->get();
        $cities = City::orderBy('kota', 'asc')->get();
        $asset_types = AssetType::all();
        $pages = 0;

        if ($request->province != "Select Province") {
            $location = $request->city . ',' . $request->province;
        } elseif ($request->city != "Select City") {
            foreach ($cities as $city) {
                if ($request->city == $city->id) {
                    $location = $city->id . ',' . $city->provinsi_id;
                }
            }
        }

        // Provinsi kosong
        if ($request->province == "Select Province") {
            //City kosong
            if ($request->city == 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);

                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
            }
            //City terisi
            elseif ($request->city != 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.lokasi', '=', $location)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.lokasi', '=', $location)
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
            }
        } elseif ($request->province != "Select Province") {
            if ($request->tipe == 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->where('assets.lokasi', '=', $location)
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->select('assets.*', 'asset_types.tipe')
                    ->latest()->paginate(9);
                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
            }
            //Tipe asset terisi
            elseif ($request->tipe != 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->where('assets.lokasi', '=', $location)
                    ->where('assets.tipe_id', '=', $request->tipe)
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->select('assets.*', 'asset_types.tipe')
                    ->latest()->paginate(9);
                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
            }
        }
    }

    public function filter_user(Request $request, Pages $pages)
    {

        $provinces = Province::orderBy('provinsi', 'asc')->get();
        $cities = City::orderBy('kota', 'asc')->get();
        $asset_types = AssetType::all();

        if ($request->province != "Select Province") {
            $location = $request->city . ',' . $request->province;
        } elseif ($request->city != "Select City") {
            foreach ($cities as $city) {
                if ($request->city == $city->id) {
                    $location = $city->id . ',' . $city->provinsi_id;
                }
            }
        }

        // Provinsi kosong
        if ($request->province == "Select Province") {
            //City kosong
            if ($request->city == 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
            }
            //City terisi
            elseif ($request->city != 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.lokasi', '=', $location)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->where('assets.lokasi', '=', $location)
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->select('assets.*', 'asset_types.tipe')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
                }
            }
        } elseif ($request->province != "Select Province") {
            if ($request->tipe == 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->where('assets.lokasi', '=', $location)
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->select('assets.*', 'asset_types.tipe')
                    ->latest()->paginate(9);
                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
            }
            //Tipe asset terisi
            elseif ($request->tipe != 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->where('assets.lokasi', '=', $location)
                    ->where('assets.tipe_id', '=', $request->tipe)
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->select('assets.*', 'asset_types.tipe')
                    ->latest()->paginate(9);
                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces'));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tipe' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $lokasi = $request->kota . ',' . $request->provinsi;
        $asset = new Asset();
        $asset->gambar = '';
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path() . '/images/upload/', $name);
                $data[] = $name;
            }
            $asset->gambar = json_encode($data);
        }
        $asset->judul = $request->judul;
        $asset->deskripsi = $request->deskripsi;
        $asset->tipe_id = $request->tipe;
        $asset->lokasi = $lokasi;
        $asset->created_at = date('Y-m-d H:i:s');
        $asset->save();

        return redirect('dashboard/admin/asset')->with('status', 'Your post has been successfully posted');
    }

    public function show_detail(Asset $asset)
    {
        $myAssets = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->get();
        $asset = $myAssets[0];
        $cities = City::all();
        $provinces = Province::all();
        $kota = '';
        $provinsi = '';
        $lokasi = explode(',', $asset->lokasi);

        foreach ($cities as $city) {
            if ($lokasi[0] == $city->id) {
                $kota = $city->kota;
            }
        }
        foreach ($provinces as $province) {
            if ($lokasi[1] == $province->id) {
                $provinsi = $province->provinsi;
            }
        }

        return view('layouts.admin.asset.showAsset')
            ->with(compact('asset'))
            ->with(compact('kota'))
            ->with(compact('provinsi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $pages = 0;
        $assets = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->first();
        $dataLokasi = DB::table('cities')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('provinces.id as prov_id', 'provinces.provinsi', 'cities.*')
            ->get();
        $otherAssets = DB::table('assets')
            ->where('assets.lokasi', '=', $asset->lokasi)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->get();

        $lokasi = explode(',', $asset->lokasi);
        foreach ($dataLokasi as $data) {
            if ($data->id == $lokasi[0]) {
                $city = $data->kota;
            }
        }
        foreach ($dataLokasi as $data) {
            if ($data->prov_id == $lokasi[1]) {
                $province = $data->provinsi;
            }
        }

        return view('projects.asset.showAsset', compact('assets', 'pages', 'city', 'province', 'provinces', 'otherAssets'));
    }

    public function show_user(Asset $asset, Pages $pages)
    {
        $assets = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->first();
        $dataLokasi = DB::table('cities')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('provinces.id as prov_id', 'provinces.provinsi', 'cities.*')
            ->get();
        $otherAssets = DB::table('assets')
            ->where('assets.lokasi', '=', $asset->lokasi)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->get();

        $lokasi = explode(',', $asset->lokasi);
        foreach ($dataLokasi as $data) {
            if ($data->id == $lokasi[0]) {
                $city = $data->kota;
            }
        }
        foreach ($dataLokasi as $data) {
            if ($data->prov_id == $lokasi[1]) {
                $province = $data->provinsi;
            }
        }

        return view('projects.asset.showAsset', compact('assets', 'pages', 'city', 'province', 'provinces', 'otherAssets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $myAssets = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->select('assets.*', 'asset_types.tipe')
            ->get();
        $asset = $myAssets[0];
        $asset_types = AssetType::all();
        $cities = City::all();
        $provinces = Province::all();
        $kota = '';
        $provinsi = '';
        $lokasi = explode(',', $asset->lokasi);
        foreach ($cities as $city) {
            if ($lokasi[0] == $city->id) {
                $kota = $city;
            }
        }
        foreach ($provinces as $province) {
            if ($lokasi[1] == $province->id) {
                $provinsi = $province;
            }
        }
        $dataGambar =  json_decode($asset->gambar);
        return view('layouts.admin.asset.editAsset')
            ->with(compact('asset'))
            ->with(compact('dataGambar'))
            ->with(compact('provinsi'))
            ->with(compact('provinces'))
            ->with(compact('cities'))
            ->with(compact('kota'))
            ->with(compact('asset_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tipe' =>  'required',
            'provinsi' =>  'required',
            'kota' =>  'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = Asset::select('gambar')->where('id', $asset->id)->get();
        $mygambar =  json_decode($data[0]["gambar"], true);
        $lokasi = $request->kota . ',' . $request->provinsi;

        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path() . '/images/upload/', $name);
                $mygambar[] = $name;
                $myArray = array_values($mygambar);
            }
            Asset::where('id', $asset->id)
                ->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'tipe_id' => $request->tipe,
                    'lokasi' => $lokasi,
                    'gambar' => json_encode($myArray),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            return redirect('dashboard/admin/asset/')->with('status', 'Your post has been updated successfully');
        }


        Asset::where('id', $asset->id)
            ->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tipe_id' => $request->tipe,
                'lokasi' => $lokasi,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        return redirect('dashboard/admin/asset/')->with('status', 'Your post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $gambar = json_decode($asset->gambar);
        if (!empty($gambar)) {
            for ($i = 0; $i < sizeof($gambar); $i++) {
                File::delete('images/upload/' . $gambar[$i]);
            }
        }
        Asset::destroy($asset->id);

        return redirect('dashboard/admin/asset')->with('status', 'Your post has been successfully deleted');
    }

    public function deleteImage(Request $request, Asset $asset)
    {
        $data = Asset::select('gambar')->where('id', $request->id)->get();
        $mygambar =  json_decode($data[0]["gambar"], true);
        $gambar = $request->namafile;

        for ($i = 0; $i < count($mygambar); $i++) {
            if ($mygambar[$i] == $gambar) {
                File::delete('images/upload/' . $gambar);
                unset($mygambar[$i]);
                $myArray = array_values($mygambar);
                Asset::where('id', $request->id)
                    ->update([
                        'gambar' => json_encode($myArray),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                return 'ok';
            }
        }

        return 'err';
    }
}
