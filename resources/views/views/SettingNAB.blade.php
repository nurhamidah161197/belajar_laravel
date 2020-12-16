@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Administrasi Nilai Ambang Batas
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Setting</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Administrasi Nilai Ambang Batas</a>
        </li>
      </ul>
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnSurat">Add Surat&nbsp;&nbsp;&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-body">
           <table class="table table-striped table-bordered table-hover" id="sample_1">
             <thead>
             <tr style="background-color:#CCCCCC">
               <th class="text-center" style="width:70%" >
                  Nomor Surat
               </th>
               <th class="text-center" style="width:10%" >
                  Tanggal
               </th>
               <th class="text-center" style="width:10%" ></th>
               <th style="width:10%" class="text-center"></th>
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
                <th></th>
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

<!-- MODAL ADD SURAT -->
<div class="modal fade" id="modal_addSurat" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">No. Surat.</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_addSurat" autocomplete="off" onSubmit="return false">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Nomor Surat</label>
                <div class="col-md-8">
                  <div class="input-group input-xlarge">
                    <input name="no_surat" id="no_surat" type="text" class="form-control">
                    <input type="text" name="id_surat" id="id_surat">
                  </div>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="text-left control-label col-md-4">Tanggal</label>
                <div class="col-md-8">
                  <div class="input-group input-medium date date-picker" id="TanggalSurat">
                    <input name="TanggalSurat" type="text" class="form-control" value="{{ date('d/m/Y') }}">
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
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-offset-8 col-md-4">
              <!-- <input class="btn green button-submit" type="submit" value="Submit"> -->
              <button type="submit" id="btnSaveSurat" class="btn green-seagreen button-submit">Submit</button>
              <button type="button" class="btn default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>

      </form>
      <!-- END FORM-->
    </div>
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- END ADD ORG -->

@endsection

@push('scripts')
<script type="text/javascript">

  var table = $("#sample_1").DataTable({
      bLengthChange: false,
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: APP_URL + "/nab/getdata",
      columns: [
        {
            data      : 'no_surat'
        },
        {
            data      : 'tanggal',
            className : "text-center"
        },
        {
            data      : 'id',
            render    : function(data){
                  return "<a href='" + APP_URL + "/daftarnab/" + data + "' class='btn btn-sm default'>NAB</a>";
            },
            className : "text-center"
        },
        {
            data      : 'id',
            render    : function(data){
                  return  "<div class='btn-group'>"+
                              "<button type='button' class='btn btn-sm edit_nab' value='" + data + "'><i class='fa fa-edit'></i></button>"+
                              "<button type='button' class='btn btn-sm delete_nab' value='" + data + "'><i class='fa fa-trash-o'></i></button>"+
                          "</div>";
            },
            className : "text-center"
        },
      ]
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

  $('#btnSurat').click(function(){

       $('#form_addSurat').trigger("reset");
       $('#modal_addSurat').modal('show');
  })

  $('#btnSaveSurat').click(function(){

      $.ajax({
          type : 'POST',
          url  : APP_URL + '/nab',
          data : $('#form_addSurat').serialize(),
          beforeSend: function() {
            Metronic.blockUI({
              boxed: true
            });
          },
          success :  function(response){
            $('#modal_addSurat').modal('hide');
            Metronic.unblockUI();
            toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
            table.draw();
          },
          error: function(data){
            Metronic.unblockUI();
            toastr["error"]("Masih terdapat Error!", "Error");
          }
      })
  })

  $('#sample_1').on('click', 'tbody tr .edit_nab', function(e){

     e.preventDefault();

     $.getJSON(APP_URL + "/nab/getnab/" + this.value, function(result){

         $('#no_surat').val(result.data['no_surat']);
         $('#id_surat').val(result.data['id']);

         if(result.data['tanggal']){
            var tgl = result.data['tanggal'].split('-');
            var tanggal = tgl[2] + '/' + tgl[1] + '/' + tgl[0];
            $('#TanggalSurat').datepicker('setDate', tanggal);
         }

         $('#modal_addSurat').modal('show');

     });


  })

  $('#sample_1').on('click', '.delete_nab', function(){

   var id         = $(this).val();

   bootbox.confirm("Apakah anda yakin menghapus No Surat ini?", function(result) {

     if(result){
         $.ajax({
         	type : 'DELETE',
         	url  : APP_URL + '/nab/' + id,
          beforeSend: function() {
             Metronic.blockUI({
         			boxed: true
         		});
         	},
         	success :  function(response){

            $('#modal_addSurat').modal('hide');
           	Metronic.unblockUI();
         		toastr["success"]("Data berhasil dihapus!.", "Notifikasi");
            table.draw();
         	},
           error: function(data){
             Metronic.unblockUI();
             toastr["error"]("Masih terdapat Error!", "Error");
           }
         });
       }
   	});
  });

$('#TanggalSurat').datepicker({

    rtl: Metronic.isRTL(),
    orientation: "right",
    autoclose: true,
    format: 'dd/mm/yyyy',
    // endDate: "today"
});



</script>
@endpush
