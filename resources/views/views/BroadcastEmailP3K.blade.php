@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Email Broadcast - P3K
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
          <a href="javascript:;">Email Broadcast - P3K</a>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-7">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <div class="row" style="padding-bottom:10px">
              <div class="col-md-12">
                <label class="control-label col-md-2">Subject</label>
                <div class="col-md-10">
                  <input type='text' id='subject' class="form-control" value="LAPORAN STOK KOTAK P3K">
                </div>
              </div>
              <!--/span-->
            </div>
            <!--/row-->
            <div class="row" style="padding-bottom:10px">
              <div class="col-md-12">
                <label class="control-label col-md-2">Body Email</label>
                <div class="col-md-10">
                  <textarea id="editor_1" class="form-control"></textarea>
                </div>
              </div>
              <!--/span-->
            </div>
            <!--/row-->
            <div class="row" style="padding-bottom:10px">
              <div class="col-md-12">
                <div class="col-md-10 pull-right">
                  <button class="btn blue form-control pull-right" style="width:100px" id="BtnBroadcast">Broadcast</button>
                </div>
              </div>
              <!--/span-->
            </div>
            <!--/row-->
          </div>
          <!--/row-->
       </div>
      </div>
      <div class="col-md-5">
        <div class="portlet light bordered">
          <div class="portlet-body" style="height:357px" >
            DAFTAR USER - P3K :<br><br>
            <div style="height:305px;overflow-y:scroll;">
            <table class="table table-bordered table-hover" id="TableUser">
              <tbody>
                @foreach($user as $user)
                <tr>
                  <td style="width:30px"><i id="delete_list" class='fa fa-times' style="cursor:pointer"></i></td>
                  <td>{{ $user->username." | ".$user->name }}<input type='hidden' id="name" value="{{ $user->name }}"><input type='hidden' id="email_user" value="{{ $user->email }}"></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE CONTENT-->
  </div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">

$('textarea').summernote({

	airMode: false,
	height: 200,
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

$("#editor_1").code("<p>Kpd Yth<br><span style='font-weight: bold;'>User Representatif</span><br><br><br>[body]</p><p>Terima Kasih.<br><span style='font-weight: bold;'>Tim Hiperkes.</span></p>'");

// $('#editor_1').summernote('code', );

$('#TableUser').on('click', '#delete_list', function (e) {

    e.preventDefault();
    var nRow = $(this).parents('tr');
    nRow.remove();

});

$('#BtnBroadcast').click(function(){

    var data = {};
    var dt   = [];

    $('#TableUser tbody tr').each(function(){

        var name        = $(this).find('#name').val();
        var email       = $(this).find('#email_user').val();

        if(email != undefined){
            data = {
                      'name'    : name,
                      'email'   : email
                   };
            dt.push(data);
        }
    });

    $.ajax({
        type : 'POST',
        url  : APP_URL + '/broadcastp3k/sendmail',
        // headers : $('#api_token').val(),
        data : 'subject=' + $('#subject').val() + '&body=' + encodeURIComponent($('#editor_1').code()) + '&email=' + JSON.stringify(dt),
        beforeSend: function() {
          $('#modal_disposisi').modal('hide');
          Metronic.blockUI({
            boxed: true
          });
        },
        success :  function(response){

          Metronic.unblockUI();
          toastr["success"]("Email berhasil dikirim!.", "Notifikasi");
          window.setTimeout(function() {
              // window.location.reload();
          }, 1000);
        },
        error: function(data){
          var errors = data.responseJSON;

          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    });
});



</script>
@endpush
