<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <link href='<?=asset('fullcalendar/lib/main.css')?>' rel='stylesheet' />
    <script src='<?=asset('fullcalendar/lib/main.js')?>'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    
    <script>

        $(document).ready(function(){
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    
    </script>

  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>