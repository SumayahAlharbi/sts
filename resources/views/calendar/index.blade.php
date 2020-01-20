@extends('layouts.material')
@section('title', 'Calendar')
@section('content')

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <script src="{{ asset('assets/plugins/calendar/jquery-ui.min.js') }}"></script>
                <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
                <script src="{{ asset('assets/plugins/calendar/dist/fullcalendar.min.js') }}"></script>
                {{-- <script src="{{ asset('assets/plugins/calendar/dist/cal-init.js') }}"></script> --}}
                <script>
                    $(document).ready(function() {
                        // page is now ready, initialize the calendar...
                        var defaultEvents =  [
                          @foreach($tickets as $ticket)
                          {
                                title: '{{ $ticket->ticket_title }}',
                                start : '{{ $ticket->due_date }}',
                                url : '{{ route('ticket.show', $ticket->id) }}',
                                @if ($ticket->status_id == 1)
                                className: 'bg-success',
                                @else
                                className: 'bg-warning',
                                @endif
                            },
                            @endforeach
                        ];
                        $('#calendar').fullCalendar({
                            // put your options and callbacks here
                      
                            events: defaultEvents,
                            defaultView: 'month',  
                            handleWindowResize: true,   
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            eventLimit: true, // allow "more" link when too many events
                            selectable: true,
                        })
                    });
                </script>

@endsection
