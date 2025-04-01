<!--
=========================================================
* Luxe Theme- v2.0.0
=========================================================
Specially Designed for {{ config('global.site_name') }}
Designer: Aleks Iralda
Site: https://airalda.com
=========================================================
 -->
<!DOCTYPE html>
<html lang="<?php echo App::getLocale(); ?>">
@include('luxe-template::templates.head')
{{-- // Brij Negi Update --}}
<body data-spy="scroll" data-target="#secondary_nav" data-offset="75">
    <?php function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    ?>
    @if ($forceLogin === 'yes' && !session()->has('UserViewer'))
        @include('luxe-template::auth.authview')
    @endif
    <div id='wrapper'>
        @include('partials.flash')
        @include('luxe-template::templates.availability')
        @include('luxe-template::templates.mobile-menu')
        @if (config('app.isft'))
            @include('luxe-template::templates.header')
        @endif
        @include('luxe-template::templates.modals')
        @include('luxe-template::templates.call_waiter')
        @include('luxe-template::templates.place-header')
        @include('luxe-template::templates.place-content')
    </div>
    <div id="toTop"></div><!-- Back to top button -->
    @include('luxe-template::templates.scripts')

    @if ($forceLogin === 'yes' && !session()->has('UserViewer'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Pass Blade variables to JS
                var forceLogin = "{{ $forceLogin === 'yes' ? 'true' : 'false' }}";
                var isAuthenticated = {{ session()->has('UserViewer') ? 'true' : 'false' }};

                if (forceLogin === 'true' && !isAuthenticated) {
                    // Show Bootstrap Modal
                    var modalElement = document.getElementById('authModal');
                    if (modalElement) {
                        var modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                }
            });
        </script>
    @elseif ($forceLogin === 'yes' && session()->has('UserViewer'))
        <script>
            function handleLogout() {
                if (confirm('Are you sure you want to log out?')) {
                    fetch('{{ route('userviewer.logout') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Logout failed');
                            }
                            return response.json();
                        })
                        .then(data => {
                           // alert(data.message);
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Something went wrong while logging out!');
                        });
                }
            }
        </script>
    @endif

</body>

</html>
