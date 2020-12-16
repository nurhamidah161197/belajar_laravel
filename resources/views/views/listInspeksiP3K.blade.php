@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
      Inspeksi Isi Kotak P3K
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="{{ url('home') }}">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Laporan</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Inspeksi Isi Kotak P3K</a>
        </li>
      </ul>
      @if(in_array(Session::get('level[1]'), [1,2]))
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnRegister">Create Report&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
      @endif
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <table class="TableLHAEks">
             <tr>
               <td>
                 @if(in_array(Session::get('level'),[1,2,3]))
                 <div class="input-group input-small date date-picker" id="dtpicker1">
      						<input type="text" class="form-control" name="date-picker" id="dtpicker1_" value="{{ date('m-Y') }}" readonly>
      						<span class="input-group-btn">
      						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
      						</span>
      					 </div>
                 @endif
               </td>
             </tr>
            </table>
            <table class="table table-striped table-bordered table-hover" style="cursor:pointer" id="sample_1">
             <thead>
             <tr>
               <th style="width:10%" class="text-center">
                  Tanggal
               </th>
               <th style="width:45%" class="text-center">
                  Lokasi
               </th>
               <th style="width:10%" class="text-center">
                  Representatif
               </th>
               <th style="width:10%" class="text-center">
                  Periode
               </th>
               <th style="width:15%" class="text-center">
                  Status
               </th>
               <th style="width:10%" class="text-center"></th>
             </tr>
             </thead>
           </table>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE CONTENT-->
  </div>
</div>

<!-- MODAL ENTRY SAMPLE -->
<div class="modal fade" id="modal_createrep" aria-hidden="true">
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
                    <input name="periode" id="periode_p3k" type="text" value="{{ date('m/Y') }}" class="form-control" @if(in_array(Session::get('level[1]'),[4,5])) {{ 'disabled' }} @endif>
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
                  <select class="form-control input-large" name="lokasi" id="lokasi" data-placeholder="Lokasi"  @if(in_array(Session::get('level[1]'),[4,5])) {{ 'disabled' }} @endif>
                    <option></option>
                    @foreach($lokasi as $lokasi)
                      @if(trim($lokasi->id_lokasi) == trim(Session::get('organisasi[1]')))
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
                  <select class="form-control input-large" name="representatif" id="representatif" data-placeholder="Penanggung Jawab" @if(in_array(Session::get('level[1]'),[4,5])) {{ 'disabled' }} @endif>
                    <option></option>
                    @foreach($user as $user)
                      @if(trim($user->username) == trim(Session::get('username')))
                          <option value="{{ $user->username }}" selected>{{ $user->username." - ".$user->name }}</option>
                      @else
                          <option value="{{ $user->username }}" >{{ $user->username." - ".$user->name  }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn blue form-control pull-right" style="width:100px" id="BtnSimpan">Save</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END ENTRY SAMPLE -->

@endsection

@push('scripts')
<script type="text/javascript">

$('#dtpicker1').datepicker({

	rtl: Metronic.isRTL(),
	orientation: "right",
	autoclose: true,
	format: "mm-yyyy",
  viewMode: "months",
  minViewMode: "months"
}).on("changeDate", function (e) {

    var result = $('#dtpicker1_').val().replace('-', '.');
    table.ajax.url( '{{ url("/inspeksip3k/getdata") }}/' + result ).load();
});

var result = "{{ date('m.Y') }}";

var table = $("#sample_1").DataTable({
    searching:false,
    bLengthChange: false,
    ordering: false,
    autoWidth: false,
    info:true,
    processing: true,
    serverSide: true,
    ajax: '{{ url("/inspeksip3k/getdata") }}/' + result,
    columns: [
      {
          data      : 'tanggal',
          className : "text-center"
      },
      {
          data      : 'desc_lokasi'
      },
      {
          data      : 'representatif',
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              var per = row.periode.split('-');
              return per[1] + '.' + per[0];
          },
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
            var status;
            switch (row.status) {
              case 1:
                status = "<font style='color:#ff0000'>OPEN</font>"
                break;
              case 2:
                status = "<font style='color:#ff0000'>RELEASE</font>"
                break;
              case 3:
                status = "<font style='color:#0000ff'>APPROVED BY USER</font>"
                break;
              default:
                status = "<font style='color:#0000ff'>CLOSED</font>"
            }
            return status;
          },
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              return "<a href=" + APP_URL + "/laporaninspeksi/"+ row.id +" class='btn btn-xs blue-madison' style='width:100%'>View</a>";
          }
      }
    ],
});

$('#btnRegister').click(function(){
    $('#modal_createrep').modal('show');
})

$('#modal_createrep select').select2();

$('#DateRegister').datepicker({

    rtl: Metronic.isRTL(),
    orientation: "right",
    autoclose: true,
    format: 'dd/mm/yyyy',
    // endDate: "today"
});

$('#periode_p3k').datepicker({

	rtl: Metronic.isRTL(),
	orientation: "right",
	autoclose: true,
	format: "mm/yyyy",
    viewMode: "months",
    minViewMode: "months"
});

$('#BtnSimpan').click(function(event){

    event.preventDefault();
    $('#representatif').removeAttr('disabled');
    $('#lokasi').removeAttr('disabled');
    $('#periode_p3k').removeAttr('disabled');
    $('#DateRegister').removeAttr('disabled');

    var dt = $('#form_entry').serialize();

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/inspeksip3k',
      	data : dt,
      	beforeSend: function() {
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){
          Metronic.unblockUI();
          window.location.href = "{{ url('laporaninspeksi') }}/" + response.id;
      	},
        error: function(data){
          var errors = data.responseJSON;
          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })

    $('#representatif').attr('disabled','disabled');
    $('#lokasi').attr('disabled','disabled');
    $('#periode_p3k').attr('disabled','disabled');
    $('#DateRegister').attr('disabled','disabled');
});


</script>
@endpush
