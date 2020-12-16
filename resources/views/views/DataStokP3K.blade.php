@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
      Data Stok P3K
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
          <a href="javascript:;">Data Stok P3K</a>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="portlet light bordered">
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
           <div id="datepaginator"></div>
           <input type="hidden" id="date-paginator" value="{{ date('d.m.Y') }}">
           <table class="table table-bordered table-hover" id="sample_1">
           <thead>
            <tr>
              <th style="width:5px;vertical-align:middle">No.</th>
              <th style="width:30%;vertical-align:middle">Isi Kotak</th>
              <th style="width:10%;vertical-align:middle">Jumlah Stok</th>
              <th style="width:40%;vertical-align:middle">keterangan</th>
              <th style="width:10%;vertical-align:middle">Tgl Update</th>
              <th style="width:10%;vertical-align:middle"></th>
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

<!-- MODAL UPDATE STOK -->
<div class="modal fade" id="modal_updatestok" aria-hidden="true">
	<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">UPDATE STOK - <b><span id="title-update"></span></b></h4>
      </div>
      <!-- BEGIN FORM-->
      <form class="form-horizontal" id="form_stok" autocomplete="off" onSubmit="return false">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Tanggal</label>
                <div class="col-md-8">
                  <label class="control-label"><b><span id="tgl_current"></span></b></label>
                  <input type='hidden' name='tanggal_stok' id='tanggal_stok'>
                  <input type='hidden' name='id_barang' id='id_barang'>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label class="control-label col-md-4">Jumlah Stok</label>
                <div class="col-md-8">
                  <div class="input-group input-small">
                    <input name="stok" id="stok" type="number" class="form-control">
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
                <label class="control-label col-md-4">Keterangan</label>
                <div class="col-md-8">
                  <textarea class="form-control input-large" rows='4' id="keterangan" name="keterangan"></textarea>
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
              <button type="submit" id="btnSimpanStok" class="btn green-seagreen button-submit">Submit</button>
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
<!-- END UPDATE STOK -->


@endsection

@push('scripts')
<script type="text/javascript">

$('#datepaginator').datepaginator({
    onSelectedDateChanged: function(event, date) {
      table.ajax.url( '{{ url("/datastokp3k/getalldata") }}/' + moment(date).format("DD.MM.YYYY") ).load();
      $('#date-paginator').val(moment(date).format("DD.MM.YYYY"));
    }
});

var table = $("#sample_1").DataTable({
    searching:false,
    bLengthChange: false,
    ordering: false,
    paging: false,
    info: false,
    processing: true,
    serverSide: true,
    fnCreatedRow: function (row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },
    ajax: APP_URL + "/datastokp3k/getalldata/" + $('#date-paginator').val(),
    columns: [
      {
          data: 'id',
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
          },
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              return "<span id='item_barang'>" + row.barang + "</span><input type='hidden' id='item_id_datastok' value='" + $.trim(row.id_datastok) + "'>";
          }
      },
      {
          data: function ( row, type, set ) {
              return "<span id='item_stok'>" + $.trim(row.stok) + "</span>";
          },
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              return "<span id='item_keterangan'>" + $.trim(row.keterangan) + "</span>";
          },
      },
      {
          data: function ( row, type, set ) {
              return "<span id='item_tgl_upd'>" + $.trim(row.tgl_update) + "</span>";
          },
          className : "text-center"
      },
      {
          data: function ( row, type, set ) {
              return "<button type='button' class='btn btn-sm' id='update_stok' value='" + row.id_barang + "'>Update</button>";
          },
          className : "text-center"
      }
    ],
});

$('#sample_1').on('click', '#update_stok', function(e){

    e.preventDefault();

    $('#title-update').html($(this).closest("tr").find("#item_barang").html());
    $('#tgl_current').html($('#date-paginator').val());
    $('#tanggal_stok').val($('#date-paginator').val());
    $('#id_barang').val(this.value);
    $('#stok').val($(this).closest("tr").find("#item_stok").html());
    $('#keterangan').val($(this).closest("tr").find("#item_keterangan").html());

    $('#modal_updatestok').modal('show');

})

$('#btnSimpanStok').click(function(e){

    e.preventDefault();

    $.ajax({
        type : 'POST',
        url  : APP_URL + '/datastokp3k',
        data : $('#form_stok').serialize(),
        beforeSend: function() {
          Metronic.blockUI({
            boxed: true
          });
        },
        success :  function(response){

          $('#modal_updatestok').modal('hide');
          Metronic.unblockUI();
          toastr["success"]("Data berhasil disimpan!.", "Notifikasi");
          table.draw();
        },
        error: function(data){
          Metronic.unblockUI();
          toastr["error"]("Masih terdapat Error!", "Error");
        }
    })
});




</script>
@endpush
