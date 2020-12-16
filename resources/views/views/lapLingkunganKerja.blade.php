@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="portlet light bordered">
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <table class="TableLHAEks" style="margin-bottom:20px">
              <tr>
               <td style="width:130px;vertical-align:bottom">
                  <h4>{{ "Hasil Pengukuran Lingkungan Kerja di ".$master->lokasi }}<h4>
               </td>
               <td rowspan="9" class="text-right" style="vertical-align:top;width:150px">
                 <div class="btn-group">
                   <div class="btn-group dropdown" style="margin-right:5px">
                      @if(in_array(Session::get('level'),[1,2]))
                      <button type="button" class="btn btn-default" id="BtnLokasi" title="Tambah Lokasi Pengukuran" style="margin-right:5px"><i class=" fa fa-bank"></i></button>
                      @endif
                      <button id="Btnback" type="button" class="btn btn-default" title="Kesimpulan Pengukuran" value="{{ url('kesimpulanpengukuran/'.$master->id_ukurlingkerja) }}"><i class="fa fa-arrow-left"></i></button>
       						 </div>
                 </div>
               </td>
             </tr>
           </table>

           <table class="table table-bordered table-hover" id="sample_1">
           <thead>
            <tr>
              <th style="width:5px;vertical-align:middle">No.</th>
              <th style="width:25%;vertical-align:middle">Lokasi</th>
              <th style="width:25%;vertical-align:middle">Jenis Pengukuran</th>
              <th style="width:25%;vertical-align:middle">Hasil Pengukuran</th>
              <th style="width:25%;vertical-align:middle">{!! "NAB<br>".$nab->no_surat !!}</th>
            </tr>
           </thead>
           <tbody>
            @php
              $no         = 1;
              $val_jenis  = 1;
              $val_hasil  = 1;
              $val_nab    = 1;
            @endphp
            @foreach($lokasiukur as $lokasiukur_)
            <tr>
              <td class="text-center">{{ $no++."." }}</td>
              <td class="text-justify">
                {{ $lokasiukur_->lokasi_ukur }}
                <input type="hidden" id="id_lokukurlingkerja" value="{{ $lokasiukur_->id_lokukurlingkerja }}">
                <br><br>
                <div class="btn-group dropdown">
                   @if(in_array(Session::get('level'),[1,2,3]))
                   <button type="button" class="btn btn-default" id="BtnPengukuran" title="Pengukuran" style="margin-right:5px"><i class=" fa fa-list-ul"></i></button>
                   @endif
                 </div>
              </td>
              <td class="text-center">
                @if(isset($data_jns[$lokasiukur_->id_lokukurlingkerja]))
                  @foreach($data_jns[$lokasiukur_->id_lokukurlingkerja] as $data_jns_)
                    {!! "<div id='jenis_".$val_jenis++."'>".$data_jns_."</div>" !!}
                  @endforeach
                @endif
              </td>
              <td class="text-center">
                @if(isset($data_hasil[$lokasiukur_->id_lokukurlingkerja]))
                  @foreach($data_hasil[$lokasiukur_->id_lokukurlingkerja] as $data_hasil_)
                    {!! "<div id='hasil_".$val_hasil++."'>".$data_hasil_."</div>" !!}
                  @endforeach
                @endif
              </td>
              <td class="text-center">
                @if(isset($data_nab[$lokasiukur_->id_lokukurlingkerja]))
                  @foreach($data_nab[$lokasiukur_->id_lokukurlingkerja] as $data_nab_)
                    {!! "<div id='nab_".$val_nab++."'>".$data_nab_."</div>" !!}
                  @endforeach
                @endif
              </td>
            </tr>
            @endforeach
           </tfoot>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ENTRY TITIK PENGUKURAN -->
<div class="modal fade" id="modal_lokasi" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Titik Pengukuran</h4>
      </div>
      <form class="form-horizontal" id="form_lokasi" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Lokasi</label>
                <div class="col-md-9">
                  <select class="form-control input-large" name="lokasi" id="SelTitik" data-placeholder="Lokasi"></select>
                  <button type="button" class="btn btn-default" id="BtnTambahTitik" title="Tambah Titik Pengukuran" style="height:34px;vertical-align:bottom"><i class=" fa fa-plus"></i></button><br><br>
                  <table class="table table-bordered table-hover input-large" id="TableLokasi">
                    <tbody></tbody>
                  </table>
                </div>
                @csrf
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSaveLokasi" class="btn">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY TITIK PENGUKURAN -->

<!-- MODAL TAMBAH TITIK PENGUKURAN -->
<div class="modal fade" id="modal_titikpengukuran" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah Titik Pengukuran</h4>
      </div>
      <form class="form-horizontal" id="form_tambahtitik" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Lokasi</label>
                <div class="col-md-9">
                  <div class="input-group">
                    <input type="text" name="lokasi" id="lokasi" class="form-control input-large" style="margin-right:3px">
                    <button type="button" class="btn btn-default" id="BtnTambahTitikPeng" title="Tambah Titik Pengukuran" style="height:34px;vertical-align:bottom"><i class=" fa fa-check"></i></button><br>
                  </div><br>
                  <label style="color:red">Pastikan nama titik pengukuran belum terdaftar.</label>
                  <table class="table table-bordered table-hover input-large" id="TableTitik">
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              @csrf
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_lokasi" value="{{ $master->id_lokasi }}" >
          <button type="button" id="btnSimpanTitik" class="btn">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END TAMBAH TITIK PENGUKURAN -->

<!-- MODAL ENTRY PENGUKURAN -->
<div class="modal fade" id="modal_pengukuran" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pengukuran</h4>
      </div>
      <form class="form-horizontal" id="form_disposisi" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <select class="form-control" id="SelPengukuran" style="width:100%" placeholder="Tambah Jenis Pengukuran">
                <option value=""></option>
                @foreach($jenis as $jenis)
                <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                @endforeach
              </select>
              <hr>
              <table class="table table-bordered table-hover" id="TablePengukuran">
                <tbody></tbody>
              </table>
            </div>
            @csrf
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <input type="hidden" id="id_lokukurlingkerja_dis">
          <button type="button" id="btnSaveDraft" class="btn">Save Draft</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY PENGUKURAN -->


@endsection

@push('scripts')
<script type="text/javascript">

$('#DateRegister').datepicker({

    rtl: Metronic.isRTL(),
    orientation: "right",
    autoclose: true,
    format: 'dd/mm/yyyy',
    // endDate: "today"
});

$('select').select2();

$('#BtnLokasi').click(function(event){

    event.preventDefault();

    $("#SelTitik").empty();
    $.getJSON(APP_URL + "/laporanpengukuran/gettitik/" + "{{ $master->id_lokasi }}", function(result){

        $('#SelTitik').append($('<option>', {
            value: "",
            text : ""
        }));
        $.each(result.data, function (i, item) {

            $('#SelTitik').append($('<option>', {
                value: item.id_titikukur + "|" + item.titik_ukur,
                text : item.titik_ukur
            }));
        });
    });

    $('#TableLokasi tbody').empty();
    $.getJSON(APP_URL + "/laporanpengukuran/getlokukur/" + "{{ $master->id_ukurlingkerja }}", function(result){

        $.each(result.data, function (i, item) {

            $('#TableLokasi tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                            <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                            <td style='width:100%;vertical-align:top'>" + item.titik_ukur + "<input type='hidden' id='titikukur' value='" + item.id_titikukur + "'><input type='hidden' id='lokukurlingkerja' value='" + item.id_lokukurlingkerja + "'></td> \
                                           <tr>");
        });
    });

    $('#modal_lokasi').modal('show');
});

$('#SelTitik').on('change', function() {

    var lokasi = this.value.split('|');
    $('#TableLokasi tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                    <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                    <td style='width:100%;vertical-align:top'>" + lokasi[1] + "<input type='hidden' id='titikukur' value='" + lokasi[0] + "'></td> \
                                   <tr>");
});

$('#TableLokasi').on('click', '#delete_list', function (e) {

    e.preventDefault();
    var nRow = $(this).parents('tr');
    nRow.remove();

});

$('#btnSaveLokasi').click(function(e){

    e.preventDefault();

    var lokasi     = {};
    var lok        = [];

    $('#TableLokasi tbody tr').each(function(){

      var id_lokukurlingkerja     = $(this).find('#lokukurlingkerja').val();
      var id_titikukur            = $(this).find('#titikukur').val();

      if(id_titikukur != undefined){
          lokasi = {
                    'id_lokukurlingkerja'  : id_lokukurlingkerja,
                    'id_titikukur'         : id_titikukur
                 };
          lok.push(lokasi);
      }
    })

    var data = 'lokasi=' + JSON.stringify(lok) + '&id_ukurlingkerja=' + '{{ $master->id_ukurlingkerja }}';

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/laporanpengukuran/lokasi',
        data : data,
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){

          Metronic.unblockUI();
      		toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
          window.location.reload();
      	},
        error: function(data){
          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
});

$('#BtnTambahTitik').click(function(event){

    event.preventDefault();

    $("#TableTitik tbody").empty();
    $.getJSON(APP_URL + "/laporanpengukuran/gettitik/" + "{{ $master->id_lokasi }}", function(result){

        $.each(result.data, function (i, item) {
            $('#TableTitik tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                            <td style='width:10px;cursor:pointer;vertical-align:middle'><span id='edit_titikukur'><i class='fa fa-edit'></i></span><span id='save_titikukur' style='display:none'><i class='fa fa-check'></i></span></td> \
                                            <td style='width:100%;vertical-align:top'><span id='desc_titikukur'>" + item.titik_ukur + "</span><input type='hidden' name='titik_ukur' id='titik_ukur' value='" + item.titik_ukur + "'><input type='hidden' name='id_titikukur' id='id_titikukur' value='" + item.id_titikukur + "'></td> \
                                           <tr>");
        });
    });
    $('#lokasi').val('');
    $('#modal_titikpengukuran').modal('show');
})

$('#BtnTambahTitikPeng').click(function(e){

    e.preventDefault();

    $('#TableTitik tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                    <td style='width:10px;cursor:pointer;vertical-align:middle'><span id='edit_titikukur'><i class='fa fa-edit'></i></span><span id='save_titikukur' style='display:none'><i class='fa fa-check'></i></span></td> \
                                    <td style='width:100%;vertical-align:top'><span id='desc_titikukur'>" + $('#lokasi').val() + "</span><input type='hidden' name='titik_ukur' id='titik_ukur' value='" + $('#lokasi').val() + "'></td> \
                                   <tr>");
    $('#lokasi').val('');
});

$('#btnSimpanTitik').click(function(event){

    event.preventDefault();

    var lokasi     = {};
    var lok        = [];

    $('#TableTitik tbody tr').each(function(){

      var titik_ukur     = $(this).find('#titik_ukur').val();
      var id_titikukur   = $(this).find('#id_titikukur').val();

      if(titik_ukur != undefined){
          lokasi = {
                    'titik_ukur'          : titik_ukur,
                    'id_titikukur'        : id_titikukur
                 };
          lok.push(lokasi);
      }
    })

    var data = 'lokasi=' + JSON.stringify(lok) + '&id_lokasi=' + '{{ $master->id_lokasi }}';

    $.ajax({
        type : 'POST',
        url  : APP_URL + '/laporanpengukuran/titik',
        data : data,
        success :  function(response){

            toastr["success"]("Titik pengukuran berhasil disimpan!.", "Notifikasi");
            $('#modal_titikpengukuran').modal('hide');

            $("#SelTitik").empty();
            $("#SelTitik").select2("val","");
            $.getJSON(APP_URL + "/laporanpengukuran/gettitik/" + "{{ $master->id_lokasi }}", function(result){

                $('#SelTitik').append($('<option>', {
                    value: "",
                    text : ""
                }));
                $.each(result.data, function (i, item) {

                    $('#SelTitik').append($('<option>', {
                        value: item.id_titikukur + "|" + item.titik_ukur,
                        text : item.titik_ukur
                    }));
                });
            });

            $('#TableLokasi tbody tr').empty();
            $.getJSON(APP_URL + "/laporanpengukuran/getlokukur/" + "{{ $master->id_ukurlingkerja }}", function(result){

                $.each(result.data, function (i, item) {

                    $('#TableLokasi tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                                    <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                                    <td style='width:100%;vertical-align:top'>" + item.titik_ukur + "<input type='hidden' id='titikukur' value='" + item.id_titikukur + "'><input type='hidden' id='lokukurlingkerja' value='" + item.id_lokukurlingkerja + "'></td> \
                                                   <tr>");
                });
            });

        },
        error: function(data){
          var errors = data.responseJSON;

          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
});

$('#TableTitik').on('click', '#edit_titikukur', function (e) {

    e.preventDefault();

    $(this).closest('tr').find('#desc_titikukur').hide();
    $(this).closest('tr').find('#edit_titikukur').hide();

    $(this).closest('tr').find('#titik_ukur').prop('type', 'text');
    $(this).closest('tr').find('#save_titikukur').show();

});

$('#TableTitik').on('click', '#save_titikukur', function (e) {

    e.preventDefault();

    var tr = $(this).closest('tr');

    tr.find('#titik_ukur').prop('type', 'hidden');
    tr.find('#save_titikukur').hide();

    tr.find('#desc_titikukur').html(tr.find('#titik_ukur').val());
    tr.find('#desc_titikukur').show();
    tr.find('#edit_titikukur').show();
});

$('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

$('#sample_1').on('click', 'tbody tr #BtnPengukuran', function(e){

    e.preventDefault();

    $("#TablePengukuran tbody").empty();
    $('#id_lokukurlingkerja_dis').val($(this).closest('tr').find('#id_lokukurlingkerja').val());

    $.getJSON(APP_URL + "/laporanpengukuran/hasil/" + $(this).closest('tr').find('#id_lokukurlingkerja').val(), function(result){

        // console.log(result);

        $.each(result.data , function(index, val) {
            $('#TablePengukuran tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                                  <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                                  <td style='width:35%;vertical-align:top'>" + val.jenis + "</td> \
                                                  <td style='width:30%'>\
                                                    <div class='input-group input-medium'> \
                                                        <input type='number' id='hasil' class='form-control' value=" + val.hasil + "> \
                                                        <span class='input-group-addon'>" + val.satuan + "</span> \
                                                    </div> \
                                                    <input type='hidden' id='id_jenis' value='" + val.id_jenis + "'> \
                                                    <input type='hidden' id='id_hasilukurlingkerja' value='" + val.id_hasilukurlingkerja + "'> \
                                                  </td> \
                                                  <td style='width:35%;vertical-align:middle' class='text-center'> \
                                                    <textarea class='form-control' rows='3' name='keterangan' id='keterangan'>" + val.keterangan + "</textarea> \
                                                  </td> \
                                                 <tr>");
        });
    })

    $('#modal_pengukuran').modal('show');
});

$('#SelPengukuran').on('change', function(e) {

    e.preventDefault();

    $.getJSON(APP_URL + "/jenispengukuran/getjenis/" + this.value, function(result){

        $('#TablePengukuran tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                              <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                              <td style='width:35%;vertical-align:top'>" + result.data['jenis'] + "</td> \
                                              <td style='width:30%'>\
                                                <div class='input-group input-medium'> \
                                                    <input id='hasil' type='number' class='form-control'> \
                                                    <span class='input-group-addon'>" + result.data['satuan'] + "</span> \
                                                </div> \
                                                <input type='hidden' id='id_jenis' value='" + result.data['id'] + "'> \
                                                <input type='hidden' id='id_hasilukurlingkerja'> \
                                              </td> \
                                              <td style='width:35%;vertical-align:middle' class='text-center'> \
                                                <textarea class='form-control' rows='3' name='keterangan' id='keterangan'></textarea> \
                                              </td> \
                                             <tr>");
    })

})

$('#TablePengukuran').on('click', '#delete_list', function (e) {

    e.preventDefault();
    var nRow = $(this).parents('tr');
    nRow.remove();

});

$('#btnSaveDraft').click(function(){

    var data  = {};
    var dt    = [];

    $('#TablePengukuran tbody tr').each(function(){

        var hasil                   = $(this).find('#hasil').val();
        var id_jenis                = $(this).find('#id_jenis').val();
        var id_hasilukurlingkerja   = $(this).find('#id_hasilukurlingkerja').val();
        var keterangan              = $(this).find('#keterangan').val();

        if(id_jenis != undefined){
            data = {
                      'hasil' : hasil,
                      'id_jenis' : id_jenis,
                      'id_hasilukurlingkerja' : id_hasilukurlingkerja,
                      'keterangan' : keterangan
                   };
            dt.push(data);
        }
    })

    // console.log(dt);

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/laporanpengukuran/hasil',
        data : 'data=' + JSON.stringify(dt) + '&id_lokukurlingkerja=' + $('#id_lokukurlingkerja_dis').val(),
      	beforeSend: function() {
          $('#modal_disposisi').modal('hide');
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){

          Metronic.unblockUI();
      		toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
          window.location.reload();
      	},
        error: function(data){
          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
})

for(var i=1;i<{{ $val_jenis }};i++)
{
    $("div[id='jenis_" + i + "']").height($("div[id='hasil_" + i + "']").height());
    $("div[id='nab_" + i + "']").height($("div[id='hasil_" + i + "']").height());
}

if($('#sample_1 tbody tr').length==0){
    $('#sample_1 tbody').append("<tr><td colspan='5' class='text-center'>No data available in table</td></tr>");
}

$('#Btnback').click(function(){
    location.replace(this.value);
});


</script>
@endpush
