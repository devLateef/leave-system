<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.header')

<body>
    <div id="app">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer>
        <!-- General JS Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{asset('assets/js/stisla.js')}}"></script>
        
        <!-- JS Libraies -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css"
            integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="{{asset('assets/js/plugins/jquery.selectric.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/jquery.uploadPreview.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
        <script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>


        <!-- Template JS File -->
        <script src="{{asset('assets/js/scripts.js')}}"></script>
        <script src="{{asset('assets/js/custom.js')}}"></script>

        <!-- Page Specific JS File -->
        <script src="{{asset('assets/js/page/features-post-create.js')}}"></script>
        <!-- Page Specific JS File -->
        <script src="{{asset('assets/js/page/forms-advanced-forms.js')}}"></script>
    </footer>
</body>

</html>
