@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <h1>X-MEN</h1>
    <p>
      Ini adalah X-MEN, ini adalah tentang para pahlawan pembela bumi.
    </p>
  </div>
  <div class="col-md-2"></div>

</div>

<hr class="hr100"/>

<!-- Daftar SuperHero Start -->


<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-info">
          Di bawah ini adalah Daftar orang-orang yang super hebat itu.<br/>
          Kamu bisa mencari nama mereka melalui fasilitas pencarian di sebelah kanan.<br/>
          Kita beruntung memiliki data-data mereka. Jangan sampai jatuh ke tangan musuh, ini akan mengubah dunia..
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <h3>Daftar Superhero</h3>
      </div>
      <div class="col-md-4">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
              <i class="fa fa-search"></i>
            </span>
          </div>
          <div id="container" class="inline">
            <input type="text" id="search-hero" placeholder="Live Search Hero" class="form-control"/>
          </div>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">

          <thead>
            <tr>
              <th>NO</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="dynamic-row">
            <?php $no=0; ?>
            @foreach($data as $item)
            <?php $no++ ?>
            <tr>
              <td >{{$no}}</td>
              <td>{{$item->nama}}</td>
              <td>{{$item->jenisKelamin}}</td>
              <td>
                <span class="float-left">
                  <a href="#detailsHero"><button id="{{$item->id}}" class="detailsHero btn btn-primary" >View Details</button></a>
                </span>
                <span class="float-left">
                  <form class="" action="{{ route('delete',$item->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                  </form>
                </span>

              </td>
            </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>
  <div class="col-md-2"></div>
</div>
<!-- Daftar SuperHero End -->

<hr class="hr100"/>

<!-- Detail SuperHero Start -->

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-info">
          Meng-klik "View Detail" di atas akan membawamu ke halaman detail di bawah ini.
          Ini jika kamu mengklik data milik Wolverine.
        </div>
        <hr/>
      </div>
    </div>
    <div id="detailsHero">

    </div>



    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!--live search js-->
    <script type="text/javascript">
    $('body').on('keyup','#search-hero',function(){
      var searchQuest= $(this).val();

      $.ajax({
        method: 'POST',
        url: '{{ route("search")}}',
        dataType: 'json',
        data:{
          '_token':'{{csrf_token()}}',
          searchQuest:searchQuest,
        },
        success: function(res){
          var tableRow = '';

          $('#dynamic-row').html('');

          $.each(res, function(index, value){
            tableRow = '<tr><td>'+value.id+'</td><td>'+value.nama+'</td><td>'+value.jenisKelamin+'</td><td><a href="#detailsHero"><button id="{{$item->id}}" class="detailsHero btn btn-primary" >View Details</button></a><button class="btn btn-danger">Hapus</button></td></tr>';
            tableRowSkill=''


            $('#dynamic-row').append(tableRow);


          });
        }

      });
    });
  </script>
  <!--detail hero js-->
  <script type="text/javascript">

  $('.detailsHero').click(function(){
    $(".toshow").show();
    var detailsId=this.id;
    $.ajax({
      method: 'POST',
      url: '{{ route("detailsHero")}}',
      dataType: 'json',
      data:{
        '_token':'{{csrf_token()}}',
        detailsId:detailsId,
      },
      success: function(res){
        var detailsData = '';

        $('#detailsHero').html('');


        $.each(res, function(index, value){
          detailsData = '<div class="row"><div class="col-md-8"><h3>Detail Superhero: '+value.nama+'</h3></div><div class="col-md-4  text-right"><button class="btn btn-primary">Edit</button></div></div><div class="row"><div class="col-md-12"><table class="table table-bordered"><tr><td>ID</td><td>'+value.id+'</td></tr><tr><td>Nama</td><td><input type="text" class="form-control" value="'+value.nama+'"/></td></tr><tr><td>Jenis Kelamin</td><td><select class="form-control" value="'+value.jenisKelamin+'"><option value="laki-laki" >Laki-laki</option><option value="perempuan" >Perempuan</option></select></td></tr></table>';

          $('#detailsHero').append(detailsData);


        });
      }

    });


  });


</script>

<!--detailnya detail hero-->
<div class="toshow" style="display:none">
<table class="table table-bordered">
  <thead>
    <th>ID</th>
    <th>Skill</th>
    <th>
      <button class="btn btn-primary btn-small">Tambah Skill</button>
    </th>
  </thead>
  <tbody id="detailSuperhero-skill">

  </tbody>
               </table>
           </div>
       </div>
   </div>
   <div class="col-md-2"></div>
</div>
</div>
<!-- Detail SuperHero End-->



    <script>
    $('.detailsHero').click(function(){

      var detailsId=this.id;

      $.ajax({
        method: 'POST',
        url: '{{ route("detailsSuperhero-skill")}}',
        dataType: 'json',
        data:{
          '_token':'{{csrf_token()}}',
          detailsId:detailsId,
        },
        success: function(res){
          var detailsData = '';


          $('#detailSuperhero-skill').html('');


          $.each(res, function(index, value){
            detailsData = '<tr><td>'+value.id+'<td>'+value.skill+'</td><td><span class="float-left"> <form class="" action="#" method="post"> @csrf @method("delete") <button type="submit" class="btn btn-danger">Delete</button> </form> </span></td></tr>';


            $('#detailSuperhero-skill').append(detailsData);


          });
        }

      });


    });
      </script>

      <hr class="hr100"/>
      <!-- Simulasi Start -->
      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
              <div class="row">
                <div class="col-md-8">
                <h3>Simulasi Jika Superhero Menikah</h3>
            </div>
            <div class="col-md-4  text-right">
                <button class="btn btn-primary">Edit</button>
                <button class="btn btn-danger">Hapus</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Suami</td>
                        <td>
                          <select id="simulasiHeroPria" class="form-control" onchange="simulasiPria()" >
                            <option disabled selected value> -- pilih hero laki-laki -- </option>
                            @foreach($data as $item)
                            @if($item->jenisKelamin =='laki-laki')
                            <option value="{{$item->id}}"  >{{$item->nama}}</option>
                            @endif
                            @endforeach
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Istri</td>
                        <td>
                          <select id="simulasiHeroPerempuan" class="form-control" onchange="simulasiPerempuan()" >
                            <option disabled selected value> -- pilih hero perempuan -- </option>
                            @foreach($data as $item)
                            @if($item->jenisKelamin =='perempuan')
                            <option value="{{$item->id}}"  >{{$item->nama}}</option>
                            @endif
                            @endforeach
                          </select>
                        </td>
                    </tr>
                </table>

                <h3>Maka Anaknya Kemungkinan Akan Memiliki Skill Berikut:</h3>
                <table class="table table-bordered">
                  <thead>
                    <th>No</th>
                    <th>Skill</th>
                  </thead>



                  <tbody id="simulasiHeroTable">


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<!--simulasi hero menikah js-->
<script>
    function simulasiPria() {
      var detailsId= document.getElementById("simulasiHeroPria").value
      $.ajax({
        method: 'POST',
        url: '{{ route("simulasi")}}',
        dataType: 'json',
        data:{
          '_token':'{{csrf_token()}}',
          detailsId:detailsId,
        },
        success: function(res){
          var detailsData = '';



          $.each(res, function(index, value){


            detailsData = '<tr><td>{{$no}}<td>'+value.skill+'</td></tr>';

            $('#simulasiHeroTable').append(detailsData);


          });

        }

      });
    };
</script>


<script>
    function simulasiPerempuan() {
      var detailsId= document.getElementById("simulasiHeroPerempuan").value
      $.ajax({
        method: 'POST',
        url: '{{ route("simulasi")}}',
        dataType: 'json',
        data:{
          '_token':'{{csrf_token()}}',
          detailsId:detailsId,
        },
        success: function(res){
          var detailsData = '';


          $.each(res, function(index, value){

            detailsData = '<tr><td>{{$no}}<td>'+value.skill+'</td></tr>';

            $('#simulasiHeroTable').append(detailsData);


          });
        }

      });
    };
</script>

<hr class="hr100"/>

<div class="row">
    <div class="col-md-2">

    </div>
    <div class="col-md-8">
        <button class="btn btn-primary">Export To Excel</button>
        <button class="btn btn-primary">Export To PDF</button>

        <hr/>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <p>
                        Kamu juga bisa meng-export data hasil simulasi ini ke EXCEL / PDF. Ingat, data ini rahasia. Jangan sampai jatuh ke tangan musuh ya! Berbahaya!
                    </p>
                </div>
                <hr/>
            </div>
        </div>
    </div>
    <div class="col-md-2">

    </div>
</div>
<!-- Simulasi End-->


<hr class="hr100"/>


<!-- Daftar Skills Start -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    Di bawah ini adalah Daftar Skill yang ada.<br/>
                    Kamu bisa mencari nama mereka melalui fasilitas pencarian di sebelah kanan.<br/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
              <h3>Daftar Skill</h3>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fa fa-search"></i>
                  </span>
                </div>
                  <input type="text" id="search-skill" placeholder="Live Search Skill" class="form-control"/>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="filteredSkill">

                  <?php $no=0; ?>
                  @foreach($skills as $item)
                  <?php $no++ ?>
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->skill}}</td>
                    <td>
                          <a href="#detailsSkill"><button id="{{$item->id}}" class="detailsSkill btn btn-primary" >View Details</button></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<!-- Daftar Skills End -->
<script type="text/javascript">
$('body').on('keyup','#search-skill',function(){
  var searchSkill= $(this).val();

  $.ajax({
    method: 'POST',
    url: '{{ route("searchSkill")}}',
    dataType: 'json',
    data:{
      '_token':'{{csrf_token()}}',
      searchSkill:searchSkill,
    },
    success: function(res){
      var tableRow = '';

      $('#filteredSkill').html('');

      $.each(res, function(index, value){
        tableRow = '<tr><td>'+value.id+'</td><td>'+value.nama+'</td><td><a href="#detailsSkillsHero"><button id="{{$item->id}}" class="detailsSkills btn btn-primary" >View Details</button></a><button class="btn btn-danger">Hapus</button></td></tr>';
        tableRowSkill=''


        $('#filteredSkill').append(tableRow);


      });
    }

  });
});
</script>



    @endsection
