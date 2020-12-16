@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
      Pengukuran Lingkungan Kerja
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Laporan</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Pengukuran Lingkungan Kerja</a>
        </li>
      </ul>
      @if(in_array(Session::get('level'),[1,2]))
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnRegister">Create Report&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
      @endif
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" style="cursor:pointer" id="sample_1">
             <thead>
             <tr>
               <th style="width:10%" class="text-center">
                  Tanggal
               </th>
               <th style="width:30%" class="text-center">
                  Lokasi
               </th>
               <th style="width:20%" class="text-center">
                  Nomor Notifikasi
               </th>
               <th style="width:15%" class="text-center">
                  Kegiatan
               </th>
               <th style="width:15%" class="text-center">
                  Status
               </th>
               <th style="width:10%"></th>
             </tr>
             </thead>
             <tfoot>
             <tr>
                <th>
                  <input type="text" class="form-control" style="width:100%">
                </th>
                <th>
                   <input type="text" class="form-control" style="width:100%">
                </th>
                <th>
                   <input type="text" class="form-control" style="width:100%">
                </th>
                <th>
                   <input type="text" class="form-control" style="width:100%">
                </th>
                <th>
                   <input type="text" class="form-control" style="width:100%">
                </th>
                <th></th>
             </tr>
             </tfoot>
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
                <label class="text-left control-label col-md-3">Tanggal</label>
                <div class="col-md-9">
                  <div class="input-group input-medium date date-picker">
                    <input name="tanggal" id="DateRegister" type="text" class="form-control" value="{{ date('d/m/Y') }}">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                  </div>
                </div>
                @csrf
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
                  <select class="form-control input-medium" name="lokasi" data-placeholder="Lokasi">
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
                  <select class="form-control input-small" name="kegiatan" data-placeholder="Kegiatan">
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
                  <input type="text" name="no_notif" class="form-control input-large">
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
                  <select class="form-control input-large" id="SelUser" placeholder="Pilih User">
                    <option value=""></option>
                    @foreach($user as $user)
                    <option value="{{ $user->id.'|'.$user->username.'|'.$user->name }}">{{ $user->username." | ".$user->name}}</option>
                    @endforeach
                  </select><br><br>
                  <table class="table table-bordered table-hover input-large" id="TableUser">
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
          <button class="btn blue form-control pull-right" style="width:100px" id="BtnSimpan">Save</button>
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

var table = $("#sample_1").DataTable({
    bLengthChange: false,
    ordering: false,
    processing: true,
    serverSide: true,
    ajax: APP_URL + "/pengukuranlingkerja/getdata",
    columns: [
      {
          data      : 'tanggal',
          className : "text-center"
      },
      {
          data      : 'desc_lokasi'
      },
      {
          data      : 'no_notif',
          className : "text-center"
      },
      {
          data      : 'kegiatan',
          className : "text-center"
      },
      {
          data      : 'status',
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              return "<a href=" + APP_URL + "/kesimpulanpengukuran/"+ row.id_ukurlingkerja +" class='btn btn-xs blue-madison' style='width:100%'>View</a>";
          }
      }
    ],
});

$('#sample_1_filter').hide();

table.columns().every( function () {

  var that = this;

  $( 'input', this.footer() ).on( 'keyup change', function () {
      if ( that.search() !== this.value ) {
          that
              .search( this.value )
              .draw();
      }
  } );

} );

$('#btnRegister').click(function(){
    $('#modal_createrep').modal('show');
})

$('#modal_createrep select').select2();

$('#DateRegister').datepicker({

    rtl: Metronic.isRTL(),
    orientation: "right",
    autoclose: true,
    format: 'dd/mm/yyyy'
});

$('#BtnSimpan').click(function(event){

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

    $.ajax({
      	type : 'POST',
      	url  : APP_URL + '/pengukuranlingkerja',
      	data : dt,
      	beforeSend: function() {
          $('#modal_createrep').modal('hide');
          Metronic.blockUI({
      			boxed: true
      		});
      	},
      	success :  function(response){
          Metronic.unblockUI();
      		toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
          location.replace(APP_URL + "/kesimpulanpengukuran/" + response.id_ukurlingkerja);
      	},
        error: function(){
          $('#modal_createrep').modal('show');
          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
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

</script>
@endpush
