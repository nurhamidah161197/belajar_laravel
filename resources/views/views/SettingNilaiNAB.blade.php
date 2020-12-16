@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    {{ $no_surat }}
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
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="javascript:;">{{ $no_surat }}</a>
        </li>
      </ul>
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnAddNAB">Add NAB.&nbsp;&nbsp;&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
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
               <th class="text-center" style="width:60%" >
                  Jenis Pengukuran
               </th>
               <th class="text-center" style="width:20%">
                  Hasil
               </th>
               <th class="text-center" style="width:10%">
                  Satuan
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

<!-- MODAL ADD NAB -->
<div class="modal fade" id="modal_addNAB" aria-hidden="true" onSubmit="return false">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Nilai Ambang Batas.</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_addnab" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Jns. Pengukuran</label>
                <div class="col-md-8" id="addModal">
                   <select class="form-control" style="width:100%" id="SelJenis" name="jenisukur" data-placeholder="Jenis Ukur"></select>
                </div>
                <div class="col-md-8" id="editModal">
                   <input type='text' class="form-control" id='desc_jenis' disabled>
                   <input type='hidden' name="id_jenis" id="id_jenis">
                   @csrf
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Hasil</label>
                <div class="col-md-8">
                  <div class="input-group input-medium">
                    <input type="text" class="form-control" name="hasil" id="hasil">
                    <input type="hidden" name="id_surat" value="{{ $id }}">
                    <input type="hidden" id="id_nab" name="id_nab">
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
              <button type="submit" id="btnSaveNAB" class="btn green-seagreen button-submit">Submit</button>
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
<!-- END ADD NAB -->

@endsection

@push('scripts')
<script type="text/javascript">

  $('#SelJenis').select2();

  var table = $("#sample_1").DataTable({
      bLengthChange: false,
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: APP_URL + "/daftarnab/getdata/{{ $id }}",
      columns: [
        {
            data      : 'jenis'
        },
        {
            data      : 'nab',
            className : "text-center"
        },
        {
            data      : 'satuan',
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

  $('#btnAddNAB').click(function(){

       $('#id_nab').val('');

       $('#addModal').show();
       $('#editModal').hide();

       $('#SelJenis').empty();
       $.getJSON(APP_URL + "/daftarnab/getjenisukur/{{$id}}", function(result){

          $.each(result.data, function (i, item) {

              $('#SelJenis').append($('<option>', {
                  value: item.id,
                  text : item.jenis
              }));
          });
       });

       $('#modal_addNAB').modal('show');
  })

  $('#btnSaveNAB').click(function(){

      $.ajax({
          type : 'POST',
          url  : "{{ url('/daftarnab') }}",
          data : $('#form_addnab').serialize(),
          beforeSend: function() {
            Metronic.blockUI({
              boxed: true
            });
          },
          success :  function(response){
            $('#modal_addNAB').modal('hide');
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

     $('#addModal').hide();
     $('#editModal').show();
     $.getJSON(APP_URL + "/daftarnab/getnab/" + this.value, function(result){

         $('#id_jenis').val(result.data['id_jenis']);
         $('#desc_jenis').val(result.data['jenis']);
         $('#hasil').val(result.data['nab']);
         $('#id_nab').val(result.data['id']);

         $('#modal_addNAB').modal('show');
     });
  })

  $('#sample_1').on('click', '.delete_nab', function(){

       var id         = $(this).val();

       bootbox.confirm("Apakah anda yakin menghapus daftar NAB ini?", function(result) {

         if(result){
             $.ajax({
             	type : 'DELETE',
             	url  : APP_URL + '/daftarnab/' + id,
              data : '_token={{ csrf_token() }}',
              beforeSend: function() {
                 Metronic.blockUI({
             			boxed: true
             		});
             	},
             	success :  function(response){
                $('#modal_addNAB').modal('hide');
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
