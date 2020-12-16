@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Administrasi Jenis Pengukuran
    </h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Administrasi Jenis Pengukuran</a>
        </li>
      </ul>
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnAddJenis">Add Jenis&nbsp;&nbsp;&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
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
                  Jenis Pengukuran
               </th>
               <th class="text-center" style="width:10%">
                  Satuan
               </th>
               <th class="text-center" style="width:10%">
                  Tgl Update
               </th>
               <th style="width:10%" class="text-center">
               </th>
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

<!-- MODAL ADD ORG -->
<div class="modal fade" id="modal_addJenis" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Jenis Pengukuran.</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_addjenis" autocomplete="off" onSubmit="return false">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Jns. Pengukuran</label>
                <div class="col-md-8">
                  <div class="input-group input-medium">
                    <input name="jenis" id="jenis" type="text" class="form-control">
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
                <label class="control-label col-md-4">Satuan</label>
                <div class="col-md-8">
                  <div class="input-group input-small">
                    <input name="satuan" id="satuan" type="text" class="form-control">
                    <input type="hidden" id="id_jenis" name="id_jenis">
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
              <button type="submit" id="btnSaveJenis" class="btn green-seagreen button-submit">Submit</button>
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
      ajax: APP_URL + "/jenispengukuran/getdata",
      columns: [
        {
            data      : 'jenis'
        },
        {
            data      : 'satuan',
            className : "text-center"
        },
        {
            data      : 'tgl_update',
            className : "text-center"
        },
        {
            data      : 'id',
            render    : function(data){
                  return  "<div class='btn-group'>"+
                              "<button type='button' class='btn btn-sm edit_jenis' value='" + data + "'><i class='fa fa-edit'></i></button>"+
                              "<button type='button' class='btn btn-sm delete_jenis' value='" + data + "'><i class='fa fa-trash-o'></i></button>"+
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

  $('#btnAddJenis').click(function(){

       $('#form_addjenis').trigger("reset");
       $('#modal_addJenis').modal('show');
  })

  $('#btnSaveJenis').click(function(){

      $.ajax({
          type : 'POST',
          url  : APP_URL + '/jenispengukuran',
          data : $('#form_addjenis').serialize(),
          beforeSend: function() {
            Metronic.blockUI({
              boxed: true
            });
          },
          success :  function(response){
            $('#modal_addJenis').modal('hide');
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

  $('#sample_1').on('click', 'tbody tr .edit_jenis', function(e){

     e.preventDefault();

     $.getJSON(APP_URL + "/jenispengukuran/getjenis/" + this.value, function(result){

         $('#id_jenis').val(result.data['id']);
         $('#jenis').val(result.data['jenis']);
         $('#satuan').val(result.data['satuan']);

         $('#modal_addJenis').modal('show');

     });
  })

  $('#sample_1').on('click', '.delete_jenis', function(){

       var id         = $(this).val();

       bootbox.confirm("Apakah anda yakin menghapus Jenis Pengukuran ini?", function(result) {

         if(result){
           $.ajax({
           	type : 'DELETE',
           	url  : APP_URL + '/jenispengukuran/' + id,
            beforeSend: function() {
               Metronic.blockUI({
             			boxed: true
             	 });
           	},
           	success :  function(response){
                $('#modal_addJenis').modal('hide');
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
