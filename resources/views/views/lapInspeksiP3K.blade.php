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
                  <b>Periode</b>
               </td>
               <td style="width:1px">:</td>
               <td>
                 @php
                   $periode = explode('-', $master->periode);
                   switch ($periode[1]) {
                       case 1:
                           $per = "JANUARI ".$periode[0];
                           break;
                       case 2:
                           $per = "FEBRUARI ".$periode[0];
                           break;
                       case 3:
                           $per = "MARET ".$periode[0];
                           break;
                       case 4:
                           $per = "APRIL ".$periode[0];
                           break;
                       case 5:
                           $per = "MEI ".$periode[0];
                           break;
                       case 6:
                           $per = "JUNI ".$periode[0];
                           break;
                       case 7:
                           $per = "JULI ".$periode[0];
                           break;
                       case 8:
                           $per = "AGUSTUS ".$periode[0];
                           break;
                       case 9:
                           $per = "SEPTEMBER ".$periode[0];
                           break;
                       case 10:
                           $per = "OKTOBER ".$periode[0];
                           break;
                       case 11:
                           $per = "NOVEMBER ".$periode[0];
                           break;
                       default :
                           $per = "DESEMBER ".$periode[0];
                   }
                 @endphp
                 {{ $per }}
               </td>
               <td rowspan="9" class="text-right" style="vertical-align:top;width:150px">
                 <div class="btn-group">
                   <div class="btn-group dropdown" style="margin-right:5px">
                      @if(in_array(Session::get('level'),[1,2]))
                      <button type="button" class="btn btn-default" id="BtnEditHeader" title="Edit Info." style="margin-right:5px"><i class=" fa fa-pencil"></i></button>
                      <button type="button" class="btn btn-default" id="BtnIsiP3K" title="Isi Daftar P3K" style="margin-right:5px"><i class=" fa fa-list-ul"></i></button>
                      @endif
                      @if(in_array(Session::get('level'),[1,2]) and $master->status=="2")
                      <button type="button" class="btn btn-default" id="BtnStatus" title="Approval" style="margin-right:5px" value="4"><i class=" fa fa-check"></i></button>
                      @endif
                      @if(in_array(Session::get('level[1]'),[1,2]) and in_array($master->status, [1,2]))
                      <button type="button" class="btn btn-default" id="BtnIsiP3K" title="Isi Daftar P3K" style="margin-right:5px"><i class=" fa fa-list-ul"></i></button>
                      @endif
                      @if(Session::get('level[1]')==1 and $master->status=="xxx")
                      <button type="button" class="btn btn-default" id="BtnStatus" title="Approval" style="margin-right:5px" value="3"><i class=" fa fa-angle-double-right"></i></button>
                      @endif
                      @if(Session::get('level[1]')==2 and $master->status==1)
                      <button type="button" class="btn btn-default" id="BtnStatus" title="Kirim Ke Atasan" style="margin-right:5px" value="2"><i class=" fa fa-angle-double-right"></i></button>
                      @endif
       						 </div>
                 </div>
               </td>
              </tr>
              <tr>
               <td>
                  <b>Tanggal</b>
               </td>
               <td>:</td>
               <td>
                 {{ $master->tanggal }}
               </td>
             </tr>
             <tr>
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
                 <b>Representatif</b>
              </td>
              <td>:</td>
              <td>{{ $master->representatif." | ".$master->name }}</td>
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
                @else
                  <font style="color:#0000ff">CLOSED</font>
                @endif
              </font>
              </td>
             </tr>
           </table>

           <table class="table table-bordered table-hover" id="sample_1">
           <thead>
            <tr>
              <th style="width:5px;vertical-align:middle">No.</th>
              <th style="width:30%;vertical-align:middle">Isi Kotak</th>
              <th style="width:10%;vertical-align:middle">Jumlah</th>
              <th style="width:10%;vertical-align:middle">Kondisi (B/TB)</th>
              <th style="width:50%;vertical-align:middle">keterangan</th>
            </tr>
           </thead>
           <tbody>
           @php $no=1 @endphp
           @foreach($p3k as $p3k_)
           <tr>
             <td valign="top" class="text-center">{!! $no++."." !!}</td>
             <td valign="top">{{ $p3k_->barang }}</td>
             <td valign="top" class="text-center">
               @if(isset($data[$p3k_->id_barang]))
                  {{ $data[$p3k_->id_barang]['jumlah'] }}
               @endif
             </td>
             <td valign="top" class="text-center">
               @if(isset($data[$p3k_->id_barang]))
                  {{ $data[$p3k_->id_barang]['kondisi'] }}
               @endif
             </td>
             <td valign="top">
               @if(isset($data[$p3k_->id_barang]))
                  {{ $data[$p3k_->id_barang]['keterangan'] }}
               @endif
             </td>
           </tr>
           @endforeach
           </tbody>
          </table>
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
                <label class="text-left control-label col-md-3">Periode</label>
                <div class="col-md-9">
                  <div class="input-group input-small date date-picker">
                    <input name="periode" id="periode_p3k" type="text" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Tanggal</label>
                <div class="col-md-9">
                  <div class="input-group input-medium date date-picker">
                    <input name="tanggal" id="DateRegister" type="text" class="form-control" value="{{ date('d/m/Y') }}">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
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
                  <select class="form-control input-large" name="lokasi" id="lokasi" data-placeholder="Lokasi">
                    <option></option>
                    @foreach($lokasi as $lokasi)
                      @if(trim($lokasi->id_lokasi) == trim(Session::get('organisasi')))
                          <option value="{{ $lokasi->id_lokasi }}" selected>{{ $lokasi->lokasi }}</option>
                      @else
                          <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->lokasi }}</option>
                      @endif
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
                <label class="text-left control-label col-md-3">Representatif</label>
                <div class="col-md-9">
                  <select class="form-control input-large" name="representatif" id="representatif" data-placeholder="PenanggungJawab">
                    <option></option>
                    @foreach($user as $user)
                      <option value="{{ $user->id }}" >{{ $user->username." - ".$user->name  }}</option>
                    @endforeach
                  </select>
                  <input type="hidden" id="id_inspeksip3k" name="id_inspeksip3k" value="{{ $master->id }}">
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <button class="btn blue form-control pull-right" style="width:100px" id="BtnSimpanHeader">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY SAMPLE -->

<!-- MODAL ENTRY ISI -->
<div class="modal fade" id="modal_isip3k" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Kotak P3K</h4>
      </div>
      <form class="form-horizontal" id="form_disposisi" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-hover" id="TableEntry">
                <thead>
                 <tr>
                   <th style="width:5px;vertical-align:middle">No.</th>
                   <th style="width:30%;vertical-align:middle">Isi Kotak</th>
                   <th style="width:15%;vertical-align:middle">Jumlah</th>
                   <th style="width:15%;vertical-align:middle">Kondisi (B/TB)</th>
                   <th style="width:40%;vertical-align:middle">keterangan</th>
                 </tr>
                </thead>
                <tbody>
                @php $no=1 @endphp
                @foreach($p3k as $p3k_)
                <tr>
                  <td valign="top" class="text-center">{!! $no++."." !!}</td>
                  <td valign="top">
                    {{ $p3k_->barang }}
                    @if(isset($old_data[$p3k_->id_barang]) and $old_data[$p3k_->id_barang]['id_inspeksip3k']==$master->id)
                    <input type='hidden' id="id_hasilinspeksip3k" value="{{ $old_data[$p3k_->id_barang]['id_hasilinspeksip3k'] }}">
                    @endif
                    <input type='hidden' id="id_barang" value="{{ $p3k_->id_barang }}">
                  </td>
                  <td valign="top"><input type='text' id='jumlah' class="form-control" value="@if(isset($old_data[$p3k_->id_barang])) {{ $old_data[$p3k_->id_barang]['jumlah'] }} @endif"></td>
                  <td valign="top">
                    <select class="form-control" id="kondisi" placeholder="Kondisi">
                      <option value="B" @if(isset($old_data[$p3k_->id_barang]['kondisi']) and $old_data[$p3k_->id_barang]['kondisi']=='B'){{ 'selected' }}@endif>BAIK</option>
                      <option value="TB" @if(isset($old_data[$p3k_->id_barang]['kondisi']) and $old_data[$p3k_->id_barang]['kondisi']=='TB'){{ 'selected' }}@endif>TIDAK BAIK</option>
                    </select>
                  </td>
                  <td valign="top"><textarea class="form-control" rows='4' id="keterangan">@if(isset($old_data[$p3k_->id_barang])){{ $old_data[$p3k_->id_barang]['keterangan'] }}@endif</textarea></td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
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
<!-- END ENTRY ISI -->


@endsection

@push('scripts')
<script type="text/javascript">

$('#DateRegister').datepicker({

    rtl: Metronic.isRTL(),
    orientation: "right",
    autoclose: true,
    format: 'dd/mm/yyyy'
    // endDate: "today"
});

// $('#DateRegister').datepicker('setDate', "{{ $periode[1].'-'.$periode[0] }}");

$('#periode_p3k').datepicker({

	rtl: Metronic.isRTL(),
	orientation: "right",
	autoclose: true,
	format: "mm/yyyy",
    viewMode: "months",
    minViewMode: "months"
});

$('select').select2();

$('#BtnEditHeader').click(function(event){

    event.preventDefault();

    // $('#lokasi').select2("val", '{{ $master->id_lokasi }}');
    $('#DateRegister').datepicker('setDate', "{{ date('d/m/Y', strtotime($master->tanggal)) }}");
    $('#periode_p3k').datepicker('setDate', "{{ date('m/Y', strtotime($master->periode)) }}");
    $('#lokasi').select2("val", '{{ $master->id_lokasi }}');
    $('#representatif').select2("val", '{{ $master->representatif }}');

    $('#modal_header').modal('show');
    // alert('tes');
})

$('#BtnSimpanHeader').click(function(event){

    event.preventDefault();
    var dt = $('#form_entry').serialize();

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/inspeksip3k',
        // headers : $('#api_token').val(),
      	data : dt,
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){

          Metronic.unblockUI();
      		toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
      		window.setTimeout(function() {
              window.location.reload();
      		}, 2000);
      	},
        error: function(data){
          var errors = data.responseJSON;

          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
})

$('#BtnIsiP3K').click(function(event){

    event.preventDefault();
    // $('#lokasi').val('');
    // $('#id_lokukurlingkerja_edit').val('');
    $('#modal_isip3k').modal('show');
})

$('#btnSaveDraft').click(function(){

    var data  = {};
    var dt    = [];

    $('#TableEntry tbody tr').each(function(){

        var id_hasilinspeksip3k     = $(this).find('#id_hasilinspeksip3k').val();
        var id_barang               = $(this).find('#id_barang').val();
        var jumlah                  = $(this).find('#jumlah').val();
        var kondisi                 = $(this).find('#kondisi').val();
        var keterangan              = $(this).find('#keterangan').val();

        if(jumlah.trim() != ""){
            data = {
                      'id_hasilinspeksip3k'   : id_hasilinspeksip3k,
                      'id_barang'             : id_barang,
                      'jumlah'                : jumlah,
                      'kondisi'               : kondisi,
                      'keterangan'            : keterangan
                   };
            dt.push(data);
        }
    })

    $.ajax({
        type : 'POST',
        url  : "{{ url('/laporaninspeksi/hasil') }}",
        // headers : $('#api_token').val(),
        data : 'data=' + JSON.stringify(dt) + '&id_inspeksip3k=' + $('#id_inspeksip3k').val(),
        beforeSend: function() {
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

$('#BtnStatus').click(function(e){

    var status = this.value;
    var state;

    switch(status){
      case '2':
        state = "Kirim Laporan ke Atasan?";
        break;
      case '3':
        state = "Apakah anda menyetujui laporan?";
        break;
      case '4':
        state = "Tutup Laporan?";
        break;
    }

    bootbox.confirm(state, function(result) {
        if(result==true){
            $.ajax({
                type : 'POST',
                url  : "{{ url('/laporaninspeksi/status') }}/" + $('#id_inspeksip3k').val() + '/' + status,
                // headers : $('#api_token').val(),
                // data : 'data=' + JSON.stringify(dt) + '&id_inspeksip3k=' + $('#id_inspeksip3k').val(),
                beforeSend: function() {
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
        }
    });
});


</script>
@endpush
