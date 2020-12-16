@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Administrasi Lokasi {{ $modul_des }}
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="{{ url('home') }}">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Setting</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">Administrasi Lokasi {{ $modul_des }}</a>
        </li>
      </ul>
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnORGANISASI">Add Lokasi&nbsp;&nbsp;&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
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

<!-- MODAL ADD ORGANISASI -->
<div class="modal fade" id="modal_addLokasi" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Lokasi {{ $modul_des }}.</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_addLokasi" autocomplete="off" onSubmit="return false">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Lokasi</label>
                <div class="col-md-8">
                  <div class="input-group input-xlarge">
                    <input name="lokasi" id="lokasi" type="text" class="form-control">
                    <input type="hidden" name="id_lokasi" id="id_lokasi">
                    <input type="hidden" name="modul" value="{{ $modul }}">
                    @csrf
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
              <button type="submit" id="btnSaveLokasi" class="btn green-seagreen button-submit">Submit</button>
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
      ajax: APP_URL + "/organisasi/getdata/" + '{{ $modul }}',
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

  $('#btnORGANISASI').click(function(){

       $('#form_addLokasi').trigger("reset");
       $('#id_lokasi').val('');
       $('#modal_addLokasi').modal('show');
  })

  $('#btnSaveLokasi').click(function(e){

      e.preventDefault();
      $.ajax({
          type : 'POST',
          url  : APP_URL + '/organisasi',
          data : $('#form_addLokasi').serialize(),
          beforeSend: function() {
            Metronic.blockUI({
              boxed: true
            });
          },
          success :  function(response){
            $('#modal_addLokasi').modal('hide');
            Metronic.unblockUI();
            table.draw();
            toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
          },
          error: function(data){
            Metronic.unblockUI();
            toastr["error"]("Masih terdapat Error!", "Error");
          }
      })
  })

  $('#sample_1').on('click', 'tbody tr .edit_lokasi', function(e){

     e.preventDefault();

     $.getJSON(APP_URL + "/organisasi/getorg/" + this.value, function(result){

         $('#id_lokasi').val(result.data['id_lokasi']);
         $('#lokasi').val(result.data['lokasi']);

         $('#modal_addLokasi').modal('show');
     });
  });

  $('#sample_1').on('click', '.delete_lokasi', function(){

   var id         = $(this).val();

   bootbox.confirm("Apakah anda yakin menghapus lokasi ini?", function(result) {

     if(result==true){
       $.ajax({
       	type : 'DELETE',
       	url  : APP_URL + '/organisasi/' + id,
        data : '_token={{ csrf_token() }}',
        beforeSend: function() {
           Metronic.blockUI({
       			boxed: true
       		});
       	},
       	success :  function(response){
          $('#modal_addLokasi').modal('hide');
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

</script>
@endpush
