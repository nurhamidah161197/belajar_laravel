<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ URL::asset('global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script type="text/javascript">
  var APP_URL = {!! json_encode(url('/')) !!};
</script>
<script src="{{ URL::asset('global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ URL::asset('global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/datatables/datatables.min.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/select2/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" ></script>
<script src="{{ URL::asset('global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>

<!-- <script src="{{ URL::asset('global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" type="text/javascript"></script> -->
<!-- <script src="{{ URL::asset('../assets/pages/scripts/components-bootstrap-multiselect.min.js') }}" type="text/javascript"></script> -->
<!-- END PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/layout2/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/layout2/scripts/demo.js') }}" type="text/javascript"></script>
<script>

jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Demo.init(); // init demo features
});

$("{{ '#'.$header_page }}").addClass('active open');
$("{{ '#sel'.$header_page }}").addClass('selected');

if("{{ $page }}" != "" ){
    $("{{ '#arr'.$header_page }}").addClass('open');
    $("{{ '#'.$page }}").addClass('active');
}
</script>
