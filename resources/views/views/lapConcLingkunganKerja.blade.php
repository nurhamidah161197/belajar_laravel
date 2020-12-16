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
               <td style="width:130px">
                  <b>Tanggal</b>
               </td>
               <td style="width:1px">:</td>
               <td>
                 {{ $master->tanggal }}
               </td>
               <td rowspan="5" class="text-right" style="vertical-align:top;width:150px">
                 <div class="btn-group">
                   @if(in_array(Session::get('level'),[1,2]))
                   <button type="button" class="btn btn-default" id="BtnEditHeader" title="Edit Info." style="margin-right:5px"><i class=" fa fa-pencil"></i></button>
                   @endif
                   @if(in_array(Session::get('level'),[1,2,99]))
                   <button type="button" class="btn btn-default" id="Btnback" title="Isi Pengukuran" value="{{ url('laporanpengukuran/'.$master->id_ukurlingkerja) }}"><i class="fa fa-arrow-right"></i></button>
                   @endif
                 </div>
               </td>
             </tr>
             <tr>
              <td>
                 <b>Lokasi</b>
              </td>
              <td>:</td>
              <td>{{ $master->lokasi }}</td>
             </tr>
             <tr>
              <td>
                 <b>Kegiatan</b>
              </td>
              <td>:</td>
              <td>
                {{ $master->kegiatan_desc }}
              </td>
             </tr>
             <tr>
              <td>
                 <b>Nomor Notifikasi</b>
              </td>
              <td>:</td>
              <td>{{ $master->no_notif }}</td>
             </tr>
             <tr>
              <td>
                 <b>Status</b>
              </td>
              <td>:</td>
              <td>
                @if($master->status==1)
                  <font style="color:#ff0000">OPEN</font>
                @elseif($master->status==2)
                  <font style="color:#ff0000">RELEASE</font>
                @elseif($master->status==3)
                  <font style="color:#0000ff">APPROVED BY ADMIN</font>
                @else
                  <font style="color:#0000ff">APPROVED BY USER</font>
                @endif
              </td>
             </tr>
             <tr>
              <td>
                 <b>Petugas</b>
              </td>
              <td>:</td>
              <td>
                @if(!empty($petugas))
                    @foreach($petugas as $petugas_)
                      {{ $petugas_->username." - ".$petugas_->name }}<br>
                    @endforeach
                @else
                    {{ "-" }}
                @endif
              </td>
              <td class="text-right" style="vertical-align:bottom">
                <div class="btn-group">
                  @if($master->status<=2 and Session::get('level')==1)
                  <button type="button" class="btn btn-default" id="BtnStatus" value="3" title="Approval"><i class=" fa fa-check"></i> | Approval</button>
                  @endif
                  @if($master->status==1 and Session::get('level')==2)
                  <button type="button" class="btn btn-default" id="BtnStatus" value="2" title="Approval"><i class=" fa fa-check"></i> | Approval</button>
                  @endif
                  @if($master->status==3 and in_array(Session::get('level[2]'),[1,2]))
                  <button type="button" class="btn btn-default" id="BtnStatus" value="4" title="Approval"><i class=" fa fa-check"></i> | Approval</button>
                  @endif
                </div>
              </td>
             </tr>
           </table>

           <table class="table table-bordered table-hover" id="sample_1">
           <thead>
            <tr>
              <th style="width:5px;vertical-align:middle">No.</th>
              <th style="width:25%;vertical-align:middle">Jenis Pengukuran</th>
              <th style="width:25%;vertical-align:middle">Hasil Pengukuran</th>
              <th style="width:25%;vertical-align:middle">{!! "NAB<br>".$nab->no_surat !!}</th>
              <th style="width:25%;vertical-align:middle">Keterangan</th>
            </tr>
           </thead>
           <tbody>
            @php $no=1; @endphp
            @foreach($data as $data)

            <tr>
              <td class="text-center">{{ $no++."." }}</td>
              <td>
                {{ $data->jenis }}
                <input id="id_jenis" type="hidden" value="{{ $data->id }}">
                <input id="jenis" type="hidden" value="{{ $data->jenis }}">
              </td>
              <td class="text-center">
                @if(min($hasil[$data->id])!=max($hasil[$data->id]))
                  {{ min($hasil[$data->id])." - ".max($hasil[$data->id])." ".$data->satuan }}
                  <input id="hasil" type="hidden" value="{{ min($hasil[$data->id])." - ".max($hasil[$data->id])." ".$data->satuan }}">
                @else
                  {{ min($hasil[$data->id])." ".$data->satuan }}
                  <input id="hasil" type="hidden" value="{{ min($hasil[$data->id])." ".$data->satuan }}">
                @endif
              </td>
              <td class="text-center">
                {{ $data->nab." ".$data->satuan }}
                <input id="nab" type="hidden" value="{{ $data->nab." ".$data->satuan }}">
              </td>
              <td @if(in_array(Session::get('level'),[1,2,99])) {!! "id='BtnKeterangan'" !!} @endif style="cursor:pointer" class="text-center">
                @if(isset($keterangan[$data->id]))
                  <input id="id_keterangan" type="hidden" value="{{ $keterangan[$data->id]['id_keterangan'] }}">
                  <span id="keterangan">{{ $keterangan[$data->id]['keterangan'] }}</span>
                @endif
              </td>
            </tr>
            @endforeach
           </tbody>
           </table>
           @if(in_array(Session::get('level'),[1,2,3]))
           <button type="button" class="btn btn-default pull-right" id="BtnKesimpulan" title="Kesimpulan & Rekomendasi " value="{{ url('laporanpengukuran/'.$master->id_ukurlingkerja) }}" style="margin-right:5px"><i class="fa fa-comments"></i>  Kesimpulan dan Rekomendasi</button>
           @endif
           <br><br>
           @if(!empty($master->kesimpulan))
             <h4><b>Kesimpulan : </b></h4>
             <label id="kesimpulan">{!! stripslashes($master->kesimpulan) !!}</label><hr>
           @endif
           @if(!empty($master->rekomendasi))
             <h4><b>Rekomendasi : </b></h4>
             <label id="rekomendasi">{!! stripslashes($master->rekomendasi) !!}</label><hr>
           @endif
           @if(in_array(Session::get('level[2]'),[4,5]) and $master->status==3)
           <button type="button" class="btn btn-default pull-right" id="BtnTindakLanjut" title="Tindak Lanjut " value="{{ url('laporanpengukuran/'.$master->id_ukurlingkerja) }}" style="margin-right:5px"><i class="fa fa-comments"></i>  Tindak Lanjut</button><br>
           @endif
           @if(in_array($master->status, [3,4]))
           <button type="button" class="btn btn-default pull-right" id="BtnTindakLanjut" title="Tindak Lanjut " value="{{ url('laporanpengukuran/'.$master->id_ukurlingkerja) }}" style="margin-right:5px"><i class="fa fa-comments"></i>  Tindak Lanjut</button><br>
           @endif
           @if(trim(e($master->tindaklanjut))!="")
             <h4><b>Tindak Lanjut : </b></h4>
             <label id="tindaklanjut">{!! stripslashes($master->tindaklanjut) !!}</label>
           @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ENTRY SAMPLE -->
<div class="modal fade" id="modal_header" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Report Info.</h4>
      </div>
      <form class="form-horizontal" id="form_entry" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Tanggal</label>
                <div class="col-md-9">
                  <div class="input-group input-medium date date-picker">
                    <input name="tanggal" id="DateRegister" type="text" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
                  @csrf
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Lokasi</label>
                <div class="col-md-9">
                  <select class="form-control input-medium" id="lokasi_header" name="lokasi" data-placeholder="Lokasi">
                    <option></option>
                    @foreach($lokasi as $lokasi)
                    <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->lokasi }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Kegiatan</label>
                <div class="col-md-9">
                  <select class="form-control input-small" id="kegiatan_header" name="kegiatan" data-placeholder="Kegiatan">
                    <option></option>
                    <option value="0">RUTIN</option>
                    <option value="1">NON RUTIN</option>
                  </select>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">No. Notifikasi</label>
                <div class="col-md-9">
                  <input type="text" name="no_notif" id="no_notif" class="form-control input-large">
                  <input type="hidden" name="id_ukurlingkerja" value="{{ $master->id_ukurlingkerja }}">
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Petugas</label>
                <div class="col-md-9">
                  <select class="form-control" id="SelUser" style="width:100%" placeholder="Pilih User">
                    <option value=""></option>
                    @foreach($user as $user)
                    <option value="{{ $user->id.'|'.$user->username.'|'.$user->name }}">{{ $user->username." | ".$user->name}}</option>
                    @endforeach
                  </select><br><br>
                  <table class="table table-bordered table-hover" id="TableUser">
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <button class="btn blue form-control pull-right" style="width:100px" id="BtnSaveHeader">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY SAMPLE -->

<!-- MODAL ENTRY KETERANGAN -->
<div class="modal fade" id="modal_keterangan" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pengukuran.</h4>
      </div>
      <form class="form-horizontal" id="form_keterangan" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label class="text-left control-label col-md-3">Jenis Pengukuran</label>
              <div class="col-md-9">
                <p id="item_jenis" class="form-control"></p>
              </div>
              @csrf
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <label class="text-left control-label col-md-3">Hasil</label>
              <div class="col-md-9">
                <p id="item_hasil" class="form-control"></p>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <label class="text-left control-label col-md-3">NAB</label>
              <div class="col-md-9">
                <p id="item_nab" class="form-control"></p>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <label class="text-left control-label col-md-3" style="vertical-align:top">Keterangan</label>
              <div class="col-md-9">
                <textarea name='keterangan' id="item_keterangan" class="form-control" rows="3"></textarea>
                <input type="hidden" id="item_id_jenis" name="id_jenis">
                <input type="hidden" id="item_id_keterangan" name="id_keterangan">
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <button class="btn blue form-control pull-right" style="width:100px" id="BtnSaveKeterangan">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY KETERANGAN -->

<!-- MODAL ENTRY KESIMPULAN -->
<div class="modal fade" id="modal_kesimpulan" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Kesimpulan & Rekomendasi</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-bottom:10px">
          <div class="col-md-12">
            <label class="control-label col-md-2">Kesimpulan</label>
            <div class="col-md-10">
              <textarea id="editor_1" name="kesimpulan" class="form-control">{!! $master->kesimpulan !!}</textarea>
            </div>
          </div>
          <!--/span-->
        </div>
        <!--/row-->
        <div class="row">
          <div class="col-md-12">
            <label class="control-label col-md-2">Rekomendasi</label>
            <div class="col-md-10">
              <textarea id="editor_2" name="rekomendasi" class="form-control">{!! $master->rekomendasi !!}</textarea>
            </div>
          </div>
          <!--/span-->
        </div>
        <!--/row-->
      </div>
      <div class="modal-footer">
        <button class="btn blue form-control pull-right" style="width:100px" id="BtnSaveKesimpulan">Save</button>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY KESIMPULAN -->

<!-- MODAL ENTRY KESIMPULAN -->
<div class="modal fade" id="modal_tindaklanjut" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tindak Lanjut</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-bottom:10px">
          <div class="col-md-12">
            <label class="control-label col-md-2">Tindak Lanjut</label>
            <div class="col-md-10">
              <textarea id="editor_3" name="tindaklanjut" class="form-control"></textarea>
            </div>
          </div>
          <!--/span-->
        </div>
        <!--/row-->
      </div>
      <div class="modal-footer">
        <button class="btn blue form-control pull-right" style="width:100px" id="BtnSaveTindakLanjut">Save</button>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY KESIMPULAN -->

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

$('#BtnEditHeader').click(function(event){

    event.preventDefault();
    $("#TableUser tr").remove();

    $('#DateRegister').datepicker('setDate', "{{ date('d/m/Y', strtotime($master->tanggal)) }}");
    $('#lokasi_header').select2("val", '{{ $master->id_lokasi }}');
    $('#kegiatan_header').select2("val", '{{ $master->kegiatan }}');
    $('#no_notif').val('{{ $master->no_notif }}');

    $.getJSON(APP_URL + "/kesimpulanpengukuran/getpetugas/" + '{{ $master->id_ukurlingkerja }}', function(result){

        $.each(result.data , function(index, val) {
            // console.log(val);
            $('#TableUser tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                            <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                            <td style='width:100%;vertical-align:top'>" + val.username + " | " + val.name + "<input type='hidden' id='badge' value='" + val.username + "'><input type='hidden' id='id_petugas' value='" + val.id_petugas + "'></td> \
                                           <tr>");
        });
    })

    $('#modal_header').modal('show');
    // alert('tes');
})

$('#SelUser').on('change', function() {

    var user = this.value.split('|');
    $('#TableUser tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                    <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                    <td style='width:100%;vertical-align:top'>" + user[1] + " | " + user[2] + "<input type='hidden' id='badge' value='" + user[1] + "'></td> \
                                   <tr>");
})

$('#TableUser').on('click', '#delete_list', function (e) {

    e.preventDefault();
    var nRow = $(this).parents('tr');
    nRow.remove();

});

$('#BtnSaveHeader').click(function(event){

    event.preventDefault();
    var user    = {};
    var usr     = [];

    $('#TableUser tbody tr').each(function(){

        var id_petugas              = $(this).find('#id_petugas').val();
        var username                = $(this).find('#badge').val();

        if(username != undefined){
            user = {
                      'id_petugas'  : id_petugas,
                      'username'    : username
                   };
            usr.push(user);
        }
    })

    var dt = $('#form_entry').serialize() + '&user=' + JSON.stringify(usr);

    // console.log(dt);
    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/pengukuranlingkerja',
        data : dt,
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){
          $('#modal_header').modal('hide');
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

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/laporanpengukuran/hasil',
        // headers : $('#api_token').val(),
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
      		window.setTimeout(function() {
              window.location.reload();
      		}, 1000);
      	},
        error: function(data){
          var errors = data.responseJSON;

          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
})

if($('#sample_1 tbody tr').length==0){
    $('#sample_1 tbody').append("<tr><td colspan='5' class='text-center'>No data available in table</td></tr>");
}

$('#sample_1').on('click', '#BtnKeterangan', function(){

    $('#form_keterangan').trigger("reset");

    $('#item_id_keterangan').val($(this).closest("tr").find("#id_keterangan").val());
    $('#item_id_jenis').val($(this).closest("tr").find("#id_jenis").val());
    $('#item_jenis').html($(this).closest("tr").find("#jenis").val());
    $('#item_hasil').html($(this).closest("tr").find("#hasil").val());
    $('#item_nab').html($(this).closest("tr").find("#nab").val());
    $('#item_keterangan').val($(this).closest("tr").find("#keterangan").html());


    $('#modal_keterangan').modal('show');
});

$('#BtnSaveKeterangan').click(function(e){

    e.preventDefault();

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/kesimpulanpengukuran/keterangan',
        data : $('#form_keterangan').serialize() + '&id_ukurlingkerja=' + '{{ $master->id_ukurlingkerja }}',
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){

          $('#modal_keterangan').modal('hide');
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

$('#editor_1, #editor_2, #editor_3').summernote({

	airMode: false,
	height: 150,
	toolbar: [
		['style', ['bold', 'italic', 'underline']],
		['para', ['ul', 'ol', 'paragraph']]
	],
  onpaste: function (e) {
      var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
      e.preventDefault();
      setTimeout(function () {
          document.execCommand('insertText', false, bufferText);
          $(this).parent().siblings('.summernote').destroy();
      }, 10);
  }
});

$('#BtnKesimpulan').click(function(){

    $("#editor_1").code('{!! $master->kesimpulan !!}');
    $("#editor_2").code('{!! $master->rekomendasi !!}');
    $('#modal_kesimpulan').modal('show');
});

$('#BtnSaveKesimpulan').click(function(e){

    e.preventDefault();

    var dt = 'kesimpulan=' + encodeURIComponent($('#editor_1').code()) + '&rekomendasi=' + encodeURIComponent($('#editor_2').code()) + '&id=' + '{{ $master->id_ukurlingkerja }}';

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/kesimpulanpengukuran/kesimpulan',
        data : dt,
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){

          $('#modal_kesimpulan').modal('hide');
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

$('#Btnback').click(function(){
    location.replace(this.value);
});

$('#BtnStatus').click(function(e){

    var status = this.value;
    var state;

    switch(status){
      case '2':
        state = "Kirim laporan ke atasan?";
        break;
      case '3':
      case '4':
        state = "Apakah anda menyetujui laporan?";
        break;

    }

    bootbox.confirm(state, function(result) {
        if(result==true){
            $.ajax({
                type : 'POST',
                url  : APP_URL + '/kesimpulanpengukuran/status/' + '{{ $master->id_ukurlingkerja }}' + '/' + status,
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
        }
    });
});

$('#BtnTindakLanjut').click(function(){

    $("#editor_3").code('{!! $master->tindaklanjut !!}');
    $('#modal_tindaklanjut').modal('show');

});

$('#BtnSaveTindakLanjut').click(function(e){

    e.preventDefault();

    var dt = 'tindaklanjut=' + $('#editor_3').code() + '&id=' + '{{ $master->id_ukurlingkerja }}';


    $.ajax({
        type : 'POST',
        url  : APP_URL + '/kesimpulanpengukuran/tindaklanjut',
        data : dt,
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


</script>
@endpush
