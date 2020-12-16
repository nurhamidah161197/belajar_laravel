@extends('metronic')

@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
      Dashboard Pengukuran Lingkungan Kerja
      <button type="button" class="btn btn-default pull-right" id="BtnFilter" title="Filter" style="margin-right:5px"><i class=" fa fa-list-ul"></i></button>
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
          <a href="javascript:;">Dashboard Pengukuran Lingkungan Kerja</a>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    @foreach($data as $data_)
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-haze"></i>
						<span class="caption-subject font-green-haze"> Pengukuran {{ $jenis_desc->jenis }} di {{ $data_->lokasi }} Tahun 2018</span>
					</div>
				</div>
				<div class="portlet-body">
					<div id="{{ 'chart_'.$data_->id_lokasi }}" class="chart" style="height: 500px;">
					</div>
				</div>
       </div>
      </div>
    </div>
    @endforeach
    <!-- END PAGE CONTENT-->
  </div>
</div>

<!-- MODAL FILTER -->
<div class="modal fade" id="modal_filter" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Filter Chart</h4>
      </div>
      <form class="form-horizontal" id="form_filter" autocomplete="off">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-left control-label col-md-3">Periode</label>
                <div class="col-md-9">
                  <div class="input-group input-small date date-picker">
                    <input name="periode" id="periode_filter" type="text" value="{{ date('Y') }}" class="form-control">
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
                <label class="text-left control-label col-md-3">Jenis Ukur</label>
                <div class="col-md-9">
                  <select class="form-control input-large" name="jenis_ukur" id="SelJenis" data-placeholder="Jenis Ukur">
                    <option></option>
                    @foreach($jenis_ukur as $jenis_ukur)
                      <option value="{{ $jenis_ukur->id }}">{{ $jenis_ukur->jenis }}</option>
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
                <label class="text-left control-label col-md-3">Lokasi</label>
                <div class="col-md-9">
                  <select class="form-control input-large" name="lokasi_ukur" id="SelLokasi" data-placeholder="Lokasi">
                    <option></option>
                    @foreach($lokasi_ukur as $lokasi_ukur)
                      <option value="{{ $lokasi_ukur->id_lokasi."|".$lokasi_ukur->lokasi }}">{{ $lokasi_ukur->lokasi }}</option>
                    @endforeach
                  </select><br><br>
                  <table class="table table-bordered table-hover input-large" id="TableLokasi">
                    <tbody>
                    @foreach($data as $data_)
                    <tr style='border-bottom: 1px solid #ddd'>
                      <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td>
                      <td style='width:100%;vertical-align:top'>{{ $data_->lokasi }}<input type='hidden' id='id_lokasi' value='{{ $data_->id_lokasi }}'></td>
                    <tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
        </div>
        <div class="modal-footer">
          <input type="hidden" id="id_lokukurlingkerja_dis">
          <button type="button" id="btnSaveFilter" class="btn">Filter</button>
        </div>
      </form>
      <!-- END FORM-->
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END FILTER -->

@endsection

@push('scripts')

<script type="text/javascript">

$('select').select2();

$('#periode_filter').datepicker({

	rtl: Metronic.isRTL(),
	orientation: "right",
	autoclose: true,
	format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
});

$.getJSON(APP_URL + "/pengukuranchart/getdata/" + '{{ $year }}' + '/' + '{{ $jenis }}' + '/' + '{{ $lokasi }}', function(result){

    $.each(result, function(i, item) {

        var chart = AmCharts.makeChart("chart_" + item.id_lokasi, {
          type: "serial",
          theme: "light",
          categoryField: "periode",
          // "rotate": true,
          startDuration: 1,
          legend: {
            generateFromData: true, //custom property for the plugin
            align: "center",
            position: "right",
            marginRight: 21,
            markerType: "circle",
            // "right": -4,
          },
          categoryAxis: {
            gridPosition: "start",
            position: "left"
          },
          trendLines: [],
          graphs: item.graphx,
          guides: [],
          valueAxes: [
            {
              // "id": "ValueAxis-1",
              // "position": "top",
              // "axisAlpha": 0
              axisAlpha: 0,
              position: "left"
            }
          ],
          allLabels: [],
          balloon: {},
          titles: [],
          dataProvider : item.data,
          export: {
            enabled: true
          }
        });
    });
});


$('#BtnFilter').click(function(event){

    event.preventDefault();

    var periode = '{{ $year }}';
    if(periode == '0000'){
        $('#periode_filter').datepicker('setDate', "{{ date('Y') }}");
    }else{
        $('#periode_filter').datepicker('setDate', "{{ $year }}");
    }
    // $('#lokasi_ukur').select2("val", '{{ $lokasi }}');
    $('#SelJenis').select2("val", '{{ $jenis }}');

    $('#modal_filter').modal('show');
});

$('#SelLokasi').on('change', function() {

    var lokasi = this.value.split('|');
    $('#TableLokasi tbody').append("<tr style='border-bottom: 1px solid #ddd'> \
                                    <td style='width:10px;cursor:pointer;vertical-align:top' id='delete_list'><i class='fa fa-times'></i></td> \
                                    <td style='width:100%;vertical-align:top'>" + lokasi[1] + "<input type='hidden' id='id_lokasi' value='" + lokasi[0] + "'></td> \
                                   <tr>");
});

$('#TableLokasi').on('click', '#delete_list', function (e) {

    e.preventDefault();
    var nRow = $(this).parents('tr');
    nRow.remove();
});

$('#btnSaveFilter').click(function(e){

    var lokasi = '';

    $('#TableLokasi tbody tr').each(function(){

      if($(this).find('#id_lokasi').val() != undefined){
          lokasi = lokasi.concat($(this).find('#id_lokasi').val() + ".");
      }
    })

    window.location.href = APP_URL + '/pengukuranchart/' + $('#periode_filter').val() + '/' + $('#SelJenis').val() + '/' + lokasi.slice(0,-1);
});

</script>
@endpush
