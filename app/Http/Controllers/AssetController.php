<?php

namespace App\Http\Controllers;

use App\Pages;
use App\Asset;
use App\Province;
use App\City;
use App\AssetType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }

        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
            ->latest()->paginate(9);

        $asset_types = AssetType::orderBy('tipe', 'asc')->get();
        $provinces = Province::orderBy('provinsi', 'asc')->get();
        $cities = City::orderBy('kota', 'asc')->get();

        return view('projects.asset.index')
            ->with(compact('adminPages'))
            ->with(compact('pages'))
            ->with(compact('asset_types'))
            ->with(compact('provinces'))
            ->with(compact('cities'))
            ->with(compact('assets'));
    }

    public function filter(Request $request, Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }

        $provinces = Province::orderBy('provinsi', 'asc')->get();
        $cities = City::orderBy('kota', 'asc')->get();
        $asset_types = AssetType::orderBy('tipe', 'asc')->get();

        // Provinsi kosong
        if ($request->province == "Select Province") {
            //City kosong
            if ($request->city == 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->join('cities', 'assets.kota_id', '=', 'cities.id')
                        ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                        ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->join('cities', 'assets.kota_id', '=', 'cities.id')
                        ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                        ->latest()->paginate(9);

                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
                }
            }
            //City terisi
            elseif ($request->city != 'Select City') {
                //Tipe asset kosong
                if ($request->tipe == 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->join('cities', 'assets.kota_id', '=', 'cities.id')
                        ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                        ->where('assets.kota_id', '=', $request->city)
                        ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                        ->latest()->paginate(9);
                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
                }
                //Tipe asset terisi
                elseif ($request->tipe != 'Select Asset Type') {
                    $assets = DB::table('assets')
                        ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                        ->join('cities', 'assets.kota_id', '=', 'cities.id')
                        ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                        ->where('assets.kota_id', '=', $request->city)
                        ->where('assets.tipe_id', '=', $request->tipe)
                        ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                        ->latest()->paginate(9);

                    return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
                }
            }
        }
        //Province terisi
        elseif ($request->province != "Select Province") {
            // Tipe asset kosong
            if ($request->tipe == 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->join('cities', 'assets.kota_id', '=', 'cities.id')
                    ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                    ->where('assets.kota_id', '=', $request->city)
                    ->where('cities.provinsi_id', '=', $request->province)
                    ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                    ->latest()->paginate(9);
                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
            }
            //Tipe asset terisi
            elseif ($request->tipe != 'Select Asset Type') {
                $assets = DB::table('assets')
                    ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
                    ->join('cities', 'assets.kota_id', '=', 'cities.id')
                    ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
                    ->where('assets.kota_id', '=', $request->city)
                    ->where('cities.provinsi_id', '=', $request->province)
                    ->where('assets.tipe_id', '=', $request->tipe)
                    ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
                    ->latest()->paginate(9);

                return view('projects.asset.index', compact('assets', 'pages', 'cities', 'asset_types', 'provinces', 'adminPages'));
            }
        }
    }

    public function list()
    {
        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
            ->paginate(10);

        return view('layouts.admin.asset.listAsset')
            ->with(compact('assets'));
    }

    public function filter_list(Request $request)
    {
        $cities = City::all();
        $provinces = Province::all();

        $city_id = array();
        $province_id = array();

        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi', 'provinces.id as provinsiId')
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
                if (!empty($city_id) && !empty($province_id)) {
                    if (stripos($asset->namaKota, $request->judulSearch) === false && stripos($asset->namaProvinsi, $request->judulSearch) === false && stripos($asset->judul, $request->judulSearch) === false) {
                        $assets->forget($key);
                    }
                } elseif (!empty($city_id)) {
                    if (stripos($asset->namaKota, $request->judulSearch) === false && stripos($asset->judul, $request->judulSearch) === false) {
                        $assets->forget($key);
                    }
                } elseif (!empty($province_id)) {
                    if (stripos($asset->namaProvinsi, $request->judulSearch) === false && stripos($asset->judul, $request->judulSearch) === false) {
                        $assets->forget($key);
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
            ->with(compact('assets'));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
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

        $idUser = Auth::user()->id;
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
        $asset->kota_id = $request->kota;
        $asset->pembuat_id = $idUser;
        $asset->created_at = date('Y-m-d H:i:s');
        $asset->save();

        return redirect('dashboard/admin/asset')->with('status', 'Your post has been successfully posted');
    }

    public function show_detail(Asset $asset)
    {
        $asset = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
            ->first();

        return view('layouts.admin.asset.showAsset')
            ->with(compact('asset'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset, Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }

        $assets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->where('assets.id', '=', $asset->id)
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi', 'cities.provinsi_id as provinsiId')
            ->first();

        $assetProvinceId = $assets->provinsiId;

        $otherAssets = DB::table('assets')
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->where('cities.provinsi_id', '=', $assetProvinceId)
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi')
            ->get();

        return view('projects.asset.showAsset', compact('assets', 'pages', 'otherAssets', 'adminPages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $asset = DB::table('assets')
            ->where('assets.id', '=', $asset->id)
            ->join('asset_types', 'assets.tipe_id', '=', 'asset_types.id')
            ->join('cities', 'assets.kota_id', '=', 'cities.id')
            ->join('provinces', 'cities.provinsi_id', '=', 'provinces.id')
            ->select('assets.*', 'asset_types.tipe', 'cities.kota as namaKota', 'provinces.provinsi as namaProvinsi', 'provinces.id as provinsiId')
            ->first();

        $asset_types = AssetType::all();
        $cities = City::all();
        $provinces = Province::all();
        $dataGambar =  json_decode($asset->gambar);
        return view('layouts.admin.asset.editAsset')
            ->with(compact('asset'))
            ->with(compact('dataGambar'))
            ->with(compact('provinces'))
            ->with(compact('cities'))
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
                    'kota_id' => $request->kota,
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
                'kota_id' => $request->kota,
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
