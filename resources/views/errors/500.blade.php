@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{route('home')}}" class="btn btn-dark btn-dash btn-yellow">Back to Website</a>
                    <div class="error-img"><img src="{{asset('images/common/error-404.png')}}" alt="error 404" class="img-fluid"></div>
                </div>
                @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
                    <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

                    <!-- Sentry JS SDK 2.1.+ required -->
                    <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

                    <script>
                        Raven.showReportDialog({
                            eventId: '{{ Sentry::getLastEventID() }}',
                            // use the public DSN (dont include your secret!)
                            dsn: 'https://fad83c2e991b452fa8127b29e54377a4@sentry.io/1318760',
                            user: {
                                'name': 'Hossam',
                                'email': 'hossam@masharee3.com',
                            }
                        });
                    </script>
                @endif
            </div>
        </div>
    </section>
</main>

@endsection