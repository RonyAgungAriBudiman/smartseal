<!-- fullCalendar -->
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<?php
$tugas = "";
$sql = "SELECT DISTINCT(a.TugasID), a.ProjectID, a.ParentID, a.Subject, a.Keterangan, a.Dari, a.Sampai, a.Progress 
		FROM ms_tugas a 
		LEFT JOIN ms_project_anggota b ON b.ProjectID = a.ProjectID 
		WHERE a.Closed = '0' AND (b.UserID = '".$_SESSION["userid"]."' OR '".$_SESSION["admin"]."' = '1' )";
$data =$sqlLib->select($sql);
foreach($data as $row)
{
	$sql_pers ="SELECT COUNT(TugasID) as Jml, SUM(Progress) as Progress FROM ms_tugas WHERE ParentID = '".$row["ProjectID"]."' AND Closed = '0'" ;
	$data_pers =$sqlLib->select($sql_pers);		
	if($data_pers[0]["Jml"] > 0) $row["Progress"] = ($data_pers[0]["Progress"]/$data_pers[0]["Jml"]);
	
	$time_dari = strtotime($row["Dari"]);
	$time_sampai = strtotime($row["Sampai"]);
	$time_sekarang = strtotime(date("Y-m-d"));
	
	$lama_tugas = (($time_sampai-$time_dari)/(60*60*24));
	$lama_lewat = (($time_sekarang-$time_dari)/(60*60*24));
	$lama_pers = (($lama_lewat/$lama_tugas)*100);	
	
	if($lama_pers<=$row["Progress"]) $color = "#00a65a";
	else if($lama_pers>$row["Progress"] AND $row["Progress"] < "100") $color = "#dd4b39";
	else if($lama_pers>$lama_tugas AND $row["Progress"] < "100") $color = "#dd4b39";
	else if($row["Progress"]=="100") $css = "00a65a";
	
	$tugas .= "{
          title          : '".$row["Subject"]." - ".$row["Progress"]."%',
          start          : '".$row["Dari"]."',
		  end          	 : '".$row["Sampai"]."',
		  url			 : 'index.php?m=tugas&sm=detail&tid=".$row["TugasID"]."',
          backgroundColor: '".$color."', //red
          borderColor    : '".$color."' //red
        },";
}
?>
<div id="calendar"></div>
</style>
<!-- fullCalendar -->
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.js"></script>
<!-- Page specific script -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'today, prev',
        center: 'title',
        right : 'next'
      },
      buttonText: {
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
	  contentHeight:"auto",
      //handleWindowResize:true,
      events    : [<?php echo $tugas?>],
      editable  : false,
      droppable : false, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>