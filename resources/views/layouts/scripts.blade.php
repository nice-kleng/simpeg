<!-- jQuery -->
<script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('assets/vendors/nprogress/nprogress.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('assets/build/js/custom.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>

<!-- PNotify -->
<script src="{{ asset('assets/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('assets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>


@if(session('message'))
    <script>
        new PNotify({
            title: '{{ session('title') }}',
            text: '{{ session('message') }}',
            type: '{{ session('type') }}',
            styling: 'bootstrap3',
        });
    </script>
@endif

<script>
    function deleteData(el) {
        let url = $(el).attr('data-url');
        $('#confirm-delete').modal('show');
        $('#form-delete').attr('action', url);
    }
</script>

@stack('scripts')
