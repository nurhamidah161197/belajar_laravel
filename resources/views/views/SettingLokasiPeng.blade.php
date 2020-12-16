@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Administrasi Lokasi Pengukuran Lingkungan
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Administrasi Lokasi Pengukuran Lingkungan</a>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-body">
           <button class='btn pull-right' style='width:120px' id="btnSurat">Lokasi. <i class="m-icon-swapright m-icon-black"></i></button>
           <table class="table table-striped table-bordered table-hover" id="sample_1">
             <thead>
             <tr>
               <th class="text-center" style="width:90%" >
                  Lokasi
               </th>
               <th style="width:10%" class="text-center"></th>
             </tr>
             </thead>
             <tfoot>
             <tr>
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

<!-- MODAL ADD SURAT -->
<div class="modal fade" id="modal_addLokasi" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Lokasi Pengukuran Lingkungan.</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_addLokasi" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Lokasi</label>
                <div class="col-md-8">
                  <div class="input-group input-xlarge">
                    <input name="lokasi" id="lokasi" type="text" class="form-control">
                    <input type="hidden" name="id_lokasi" id="id_lokasi">
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
              <button type="button" id="btnSaveLokasi" class="btn green-seagreen button-submit">Submit</button>
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
      aaSorting: false,
      language: {
          processing: '<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>',
      },
      processing: true,
      serverSide: true,
      ajax: '{{ url("lokasi/getdata") }}',
      columns: [
        {
            data      : 'lokasi'
        },
        {
            data      : 'id_lokasi',
            render    : function(data){
                  return  "<div class='btn-group'>"+
                              "<button type='button' class='btn btn-sm edit_lokasi' value='" + data + "'><i class='fa fa-edit'></i></button>"+
                              "<button type='button' class='btn btn-sm delete_lokasi' value='" + data + "'><i class='fa fa-trash-o'></i></button>"+
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

       $('#form_addLokasi').trigger("reset");

       $('#modal_addLokasi').modal('show');
  })

  $('#btnSaveLokasi').click(function(){

      $.ajax({
          type : 'POST',
          url  : "{{ url('/lokasi') }}",
          // headers : $('#api_token').val(),
          data : $('#form_addLokasi').serialize(),
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

  $('#sample_1').on('click', 'tbody tr .edit_lokasi', function(e){

     e.preventDefault();

     $.getJSON(APP_URL + "/lokasi/getlokasi/" + this.value, function(result){

         $('#id_lokasi').val(result.data['id_lokasi']);
         $('#lokasi').val(result.data['lokasi']);

         $('#modal_addLokasi').modal('show');

     });


  })

  $('#sample_1').on('click', '.delete_lokasi', function(){

   var id         = $(this).val();

   bootbox.confirm("Apakah anda yakin menghapus lokasi ini?", function(result) {

     if(result==true){
       $.ajax({
       	type : 'DELETE',
       	url  : APP_URL + '/lokasi/' + id,
         data : "_token={{ csrf_token() }}",
         beforeSend: function() {
           Metronic.blockUI({
       			boxed: true
       		});
       	},
       	success :  function(response){
           var data = response.data;
         	Metronic.unblockUI();
       		toastr["success"]("Data berhasil dihapus!.", "Notifikasi");
       		window.setTimeout(function() {
       			window.location.reload(true);
       		}, 2000);
       	},
         error: function(data){
           var errors = data.responseJSON;

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
