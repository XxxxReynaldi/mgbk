<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Sekolah;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProfilesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!(auth()->user()->user_level == 1)) {
            $profile = null;
            $checkProfile = Profile::with('user')->where('id_user', auth()->user()->id_user)->exists();

            if ($checkProfile) {
                $profile = Profile::with('user', 'sekolah')->where('id_user', auth()->user()->id_user)->first();
            }

            $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

            return view('profile.user.edit', compact('checkProfile', 'profile', 'schools'));
        } else {
            return view('profile.admin.edit');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nama_lengkap'          => 'required|max:255',
            'foto_profil'           => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'alamat_sekolah'        => 'required|max:255',
            'nama_kepala_sekolah'   => 'required|max:255',
            'id_sekolah'            => 'required',
            'tambahan_informasi'    => 'nullable|max:255',
            'logo_sekolah'          => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $nama_foto = null;

        if ($request->hasFile('foto_profil')) {
            $foto_profil    = $request->file('foto_profil');
            $nama_foto      = $foto_profil->getClientOriginalName();
            $request->file('foto_profil')->storeAs('foto_profil/' . auth()->user()->id_user, $nama_foto);
        }

        if ($request->hasFile('logo_sekolah')) {
            $logo_sekolah   = $request->file('logo_sekolah');
            $nama_logo      = $logo_sekolah->getClientOriginalName();
            $request->file('logo_sekolah')->storeAs('logo_sekolah/' . auth()->user()->id_user, $nama_logo);
        }

        $data_request = $request->all();
        $data_request['id_user']        = auth()->user()->id_user;
        $data_request['foto_profil']    = $nama_foto;
        $data_request['logo_sekolah']   = $nama_logo;

        Profile::create($data_request);
        return redirect()->back()->with('status', 'Profile User berhasil diupdate!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {

        $request->validate([
            'nama_lengkap'          => 'required|max:255',
            'foto_profil'           => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120',
            'alamat_sekolah'        => 'required|max:255',
            'nama_kepala_sekolah'   => 'required|max:255',
            'id_sekolah'            => 'required',
            'tambahan_informasi'    => 'nullable|max:255',
            'logo_sekolah'          => 'file|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $nama_foto = $profile->foto_profil;
        $nama_logo = $profile->logo_sekolah;

        if ($request->hasFile('foto_profil')) {
            $foto_profil    = $request->file('foto_profil');
            $nama_foto      = $foto_profil->getClientOriginalName();
            $request->file('foto_profil')->storeAs('foto_profil/' . auth()->user()->id_user, $nama_foto);
        }

        if ($request->hasFile('logo_sekolah')) {
            $logo_sekolah   = $request->file('logo_sekolah');
            $nama_logo      = $logo_sekolah->getClientOriginalName();

            $request->file('logo_sekolah')->storeAs('logo_sekolah/' . auth()->user()->id_user, $nama_logo);
            // Image::make($logo_sekolah)->resize(200, 200)->save(public_path($nama_logo));
        }

        Profile::where('id_profile', $profile->id_profile)
            ->update([
                'id_user'               => auth()->user()->id_user,
                'nama_lengkap'          => $request->nama_lengkap,
                'foto_profil'           => $nama_foto,
                'alamat_sekolah'        => $request->alamat_sekolah,
                'nama_kepala_sekolah'   => $request->nama_kepala_sekolah,
                'id_sekolah'            => $request->id_sekolah,
                'tambahan_informasi'    => $request->tambahan_informasi,
                'logo_sekolah'          => $nama_logo,
            ]);

        return redirect()->back()->with('status', 'Data profile berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function updatePassword()
    {
        if (!(auth()->user()->user_level == 1)) {
            return view('profile.user.editPassword');
        }
        return view('profile.admin.editPassword');
    }

    public function loadSekolah(Request $request)
    {
        // if ($request->has('q')) {
        //     $cari = $request->q;
        //     $data = DB::table('sekolah')->select('id', 'email')->where('email', 'LIKE', '%$cari%')->get();
        //     return response()->json($data);
        // }
    }
}
