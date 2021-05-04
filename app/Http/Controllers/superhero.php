<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class superhero extends Controller
{
    public function index(){
      $data=DB::table('superhero')->paginate(10);
      $skills=DB::table('skills')->paginate(10);

      return view('index')->with('data',$data)->with('skills',$skills);
    }

    public function search(Request $request)
  	{
  		// menangkap data pencarian

      $search = $request->get('searchQuest');

      		// mengambil data dari table superhero sesuai pencarian data
  		$data = DB::table('superhero')
  		->where('nama','like',"%".$search."%")
      ->orwhere('jenisKelamin','like',"%".$search."%")
  		->get();

      		// mengirim data pegawai ke view index
  		return json_encode($data);

  	}


    public function simulasi(Request $request)
  	{
  		// menangkap data pencarian

      $simulasiId = $request->get('detailsId');

      		// mengambil data dari table superhero sesuai pencarian data
  		$data = DB::table('superheroskill')
            ->select('skills.skill as skill')
            ->leftJoin('skills', 'skills.id', '=', 'superheroskill.id_skill')
            ->where('superheroskill.id_superhero',$simulasiId)
            ->get();

      		// mengirim data pegawai ke view index
  		return json_encode($data);

  	}



    public function getDetailsHero(Request $request)
  	{
  		// menangkap data pencarian

      $search = $request->get('detailsId');

      		// mengambil data dari table superhero sesuai pencarian data
  		$data = DB::table('superhero')
  		->where('id',$search)
      ->get();

      		// mengirim data pegawai ke view index
  		return json_encode($data);

  	}







    public function getDetailsSkill(Request $request)
    {
      // menangkap data pencarian

      $search = $request->get('detailsId');

          // mengambil data dari table superhero sesuai pencarian data
          $search = $request->get('detailsId');

              // mengambil data dari table superhero sesuai pencarian data
          $data = DB::table('superheroskill')
                    ->select('skills.skill as skill','skills.id as id')
                    ->leftJoin('skills', 'skills.id', '=', 'superheroskill.id_skill')
                    ->where('superheroskill.id_superhero',$search)
                    ->get();

        // mengirim data pegawai ke view index
      return json_encode($data);

    }
    public function getDetailsHeroSkill(Request $request)
    {
      // menangkap data pencarian

      $search = $request->get('detailsId');

          // mengambil data dari table superhero sesuai pencarian data
      $data = DB::table('superheroskill')
                ->select('skills.skill as skill')
                ->leftJoin('skills', 'skills.id', '=', 'superheroskill.id_skill')
                ->where('superheroskill.id_superhero',$search)
                ->get();

          // mengirim data pegawai ke view index
      return json_encode($data);

    }
    public function getDetailsSkillHero(Request $request)
    {
      // menangkap data pencarian

      $search = $request->get('detailsId');

          // mengambil data dari table superhero sesuai pencarian data
      $data = DB::table('superhero')
                ->select('superhero.nama as nama')
                ->leftJoin('superheroskill', 'superhero.id', '=', 'superheroskill.id_superhero')
                ->where('superheros.id',$search)
                ->get();

          // mengirim data pegawai ke view index
      return json_encode($data);

    }

    public function destroy($id)
    {
      $superhero= DB::table('superhero')
  		->where('id',$id);
      $superhero->delete();

      if($superhero){
         //redirect dengan pesan sukses
         return redirect('/')->with(['success' => 'Data Berhasil Dihapus!']);
      }else{
        //redirect dengan pesan error
        return redirect('/')->with(['error' => 'Data Gagal Dihapus!']);
      }
    }

    public function deleteskillOfHero($id ,$skillid)
    {
      $superhero= DB::table('superheroskill')
  		->where('id_superhero',$id)
      ->where('id_skill',$skillid);
      $superhero->delete();

      if($superhero){
         //redirect dengan pesan sukses
         return redirect('/')->with(['success' => 'Data Berhasil Dihapus!']);
      }else{
        //redirect dengan pesan error
        return redirect('/')->with(['error' => 'Data Gagal Dihapus!']);
      }
    }



    public function searchSkill(Request $request)
    {
      // menangkap data pencarian

      $search = $request->get('searchSkill');

          // mengambil data dari table superhero sesuai pencarian data
      $data = DB::table('skill')
      ->where('nama','like',"%".$search."%")
    ->get();

          // mengirim data pegawai ke view index
      return json_encode($data);

    }


  public function getSuperhero($id = 0){

    if($id==0){
       $superhero = superhero::orderby('id','asc')->select('*')->get();
    }else{
       $superhero = superhero::select('*')->where('id', $id)->get();
    }
    // Fetch all records
    $data['superhero'] = $superhero;

    echo json_encode($data);
    exit;
 }

}
