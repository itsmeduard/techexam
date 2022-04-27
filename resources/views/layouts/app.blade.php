<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tech Exam</title>

    {{--Sweet Alert Notification--}}
    <link rel='stylesheet' href="{{ asset('assets/css/sweetalert2.css')}}">

    <script src="//unpkg.com/alpinejs" defer></script>
    <style> [x-cloak] { display: none !important; } </style>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    @livewireStyles
</head>
<body>

{{$slot}}
@livewireScripts


{{-- Sweetalet2 js --}}
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    /*Toast Notification*/
    @if(Session::has('message'))
    var type = '{{ Session::get('alert-type', 'info') }}';
    switch(type){
        case 'success':
            toastr.success('{{ Session::get('message') }}');
            break;

        case 'error':
            toastr.error('{{ Session::get('message') }}');
            break;
    }
    @endif

    /* Hide Modal Store and Update */
    window.livewire.on('modalStore', () => {
        $('#addModal').modal('hide');
        $('#updateModal').modal('hide');
        $('#changePasswordModal').modal('hide');
        $('#importModal').modal('hide');
        $('#exportModal').modal('hide');
    });

    /* Hide Modal Delete */
    window.livewire.on('modalDelete', () => {
        $('#deleteModal').modal('hide');
    });


    /* Sweetalert2 */
    window.addEventListener('swal',function(e){
        Swal.fire(e.detail);
    });
</script>
</body>
</html>
