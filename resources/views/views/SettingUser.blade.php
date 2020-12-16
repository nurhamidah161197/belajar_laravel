@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    {{ "Administrasi User ".$modul_des }}
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
          <a href="javascript:;">{{ "Administrasi User ".$modul_des }}</a>
        </li>
      </ul>
      <button class='btn pull-right' style='width:120px;padding-bottom:13px' id="btnAddUserr">Add User&nbsp;&nbsp;&nbsp;&nbsp;<i class="m-icon-swapright m-icon-black"></i></button>
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
               <th class="text-center" style="width:10%" >
                  Username
               </th>
               <th class="text-center" style="width:25%">
                  Name
               </th>
               <th class="text-center" style="width:25%">
                  Organisasi
               </th>
               <th class="text-center" style="width:15%">
                  Email
               </th>
               <th class="text-center" style="width:15%">
                  Level
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

<!-- MODAL ADD USER -->
<div class="modal fade" id="modal_adduser" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">User - {{ $modul_des }}</h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_adduser" autocomplete="off" onSubmit="return false">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Username</label>
                <div class="col-md-8">
                  <div class="input-group input-small">
                    <input name="username" id="username" type="text" class="form-control">
                    @csrf
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
                <label class="control-label col-md-4">Name</label>
                <div class="col-md-8">
                  <div class="input-group input-large">
                    <input name="name" id="name" type="text" class="form-control">
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
                <label class="control-label col-md-4">Email</label>
                <div class="col-md-8">
                  <div class="input-group input-large">
                    <input name="email" id="email" type="text" class="form-control">
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
                <label class="control-label col-md-4">Level</label>
                <div class="col-md-8">
                  <select class="form-control input-large" name="level" data-placeholder="Choose a level" tabindex="-1" id="SelLevel" title="">
                    <option value=""></option>
                    @if($modul=='admin')
                    <option value="1">Approval Admin</option>
                    <option value="2">Admin</option>
                    @else
                    <option value="1">Approval User</option>
                    <option value="2">User Representatif</option>
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          @if(in_array($modul, ['p3k', 'plk']))
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Organisasi</label>
                <div class="col-md-8">
                  <select class="form-control input-large" name="organisasi"  data-placeholder="Choose an Org." tabindex="-1" id="SelOrganisasi" title="">
                      <option value=""></option>
                      @foreach($organisasi as $organisasi_)
                        <option value="{{ $organisasi_->id_lokasi }}">{{ $organisasi_->lokasi }}</option>
                      @endforeach
                  </select>
                  <input type="hidden" name="modul" value="{{ $modul }}">
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          @endif
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-offset-8 col-md-4">
              <!-- <input class="btn green button-submit" type="submit" value="Submit"> -->
              <button type="submit" id="btnSaveUser" class="btn green-seagreen button-submit">Submit</button>
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
<!-- END ADD USER -->

@endsection

@push('scripts')
<script type="text/javascript">

  var table = $("#sample_1").DataTable({
      bLengthChange: false,
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: APP_URL + "/user/getdata/" + '{{ $modul }}',
      columns: [
        {
            data      : 'username',
            className : "text-center"
        },
        {
            data      : 'name'
        },
        {
            data      : 'organisasi'
        },
        {
            data      : 'email'
        },
        {
            data      : 'level',
            className : "text-center"
        },
        {
            data      : 'username',
            render    : function(data){
                  return  "<div class='btn-group'>"+
                              "<button type='button' class='btn btn-sm edit_user' value='" + data + "'><i class='fa fa-edit'></i></button>"+
                              "<button type='button' class='btn btn-sm delete_user' value='" + data + "'><i class='fa fa-trash-o'></i></button>"+
                          "</div>";
            },
            className : "text-center"
        }
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

 $('select').select2();

 $('#btnAddUserr').click(function(){

      $('#form_adduser').trigger("reset");
      $("#username").prop('readonly', false);

      $('#SelLevel').select2('val', '');
      $('#SelOrganisasi').select2('val', '');

      $('#modal_adduser').modal('show');
 })

 $('#btnSaveUser').click(function(){

     $.ajax({
         type : 'POST',
         url  : APP_URL + '/user',
         data : $('#form_adduser').serialize(),
         beforeSend: function() {
           Metronic.blockUI({
             boxed: true
           });
         },
         success :  function(response){
           $('#modal_adduser').modal('hide');
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

 $('#sample_1').on('click', 'tbody tr .edit_user', function(e){

    e.preventDefault();

    $.getJSON(APP_URL + "/user/getusername/{{ $modul }}/" + this.value, function(result){

        // console.log(result.data['organisasi']);

        $('#username').val(result.data['username']);
        $("#username").prop('readonly', true);

        $('#name').val(result.data['name']);
        $('#email').val(result.data['email']);

        $('#SelLevel').select2('val', result.data['level']);

        $('#SelOrganisasi').select2('val', result.data['organisasi']);
        $('#id_user').val(result.data['id']);

        $('#modal_adduser').modal('show');

    });


 })

 $('#sample_1').on('click', '.delete_user', function(){


      var id         = $(this).val();

      bootbox.confirm("Apakah anda yakin menghapus User ini?", function(result) {

        if(result){
            $.ajax({
            	type : 'DELETE',
            	url  : APP_URL + '/user/{{ $modul }}/' + id,
              beforeSend: function() {
                Metronic.blockUI({
            			boxed: true
            		});
            	},
            	success :  function(response){
                $('#modal_adduser').modal('hide');
              	Metronic.unblockUI();
            		table.draw();
                toastr["success"]("Data berhasil dihapus!.", "Notifikasi");
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
