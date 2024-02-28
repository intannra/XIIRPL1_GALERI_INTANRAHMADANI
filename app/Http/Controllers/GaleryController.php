<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use function Ramsey\Uuid\v6;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $galeris = Galery::where('iduser',Auth::user()->id)->get();
        return view('timeline',['galeris'=>$galeris]);
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
            'judul'=>'required',
            'deskripsi'=>'required',
            'foto'=>'required'
        ]);
        $namafoto = Auth::user()->id.'-'.date('YmdHis').$request->foto->getClientOriginalName();
        $data = [
            'judul'=>$request->judul,
            'deskripsi'=>$request->deskripsi,
            'foto'=>$namafoto,
            'tanggal'=>now(),
            'iduser'=>Auth::user()->id,
        ];
        $request->foto->move(public_path('images'),$namafoto);
        Galery::create($data);
        return redirect('/galery');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        Galery::where('id',$id)->delete();
        return redirect('/galery');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function edit(Galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galery $galery)
    {
        //
        if($request->hasFile('foto')){
            $namafoto = Auth::user()->id.'-'.date('YmdHis').$request->foto->getClientOriginalName();
            $request->foto->move(public_path('images'),$namafoto);
            $galery -> judul = $request ->judul;
            $galery -> deskripsi = $request -> deskripsi;
            $galery -> foto = $namafoto;
            $galery -> tanggal = now();
            $galery -> iduser = Auth::user()->id;
            $galery -> save(); 
        }else{
            $galery -> judul = $request ->judul;
            $galery -> deskripsi = $request -> deskripsi;
            $galery -> foto = $galery -> foto;
            $galery -> tanggal = now();
            $galery -> iduser = Auth::user()->id;
            $galery -> save(); 
        }
        return redirect('/galery');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galery $galery)
    {
        //
    }
}
