<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Test EA</title>
   <!-- DayPilot library -->
   <link type="text/css" rel="stylesheet" href="{{ asset('assets/icons/style.css') }}" />

   <style type="text/css">
        body, input, button, select {
            font-size: 14px;
        }

        select {
            padding: 5px;
        }

        .toolbar {
            margin: 10px 0px;
        }

        .toolbar button {
            padding: 5px 15px;
        }

        .icon {
            font-size: 14px;
            text-align: center;
            line-height: 14px;
            vertical-align: middle;

            cursor: pointer;
        }

        .toolbar-separator {
            width: 1px;
            height: 28px;
            /*content: '&nbsp;';*/
            display: inline-block;
            box-sizing: border-box;
            background-color: #ccc;
            margin-bottom: -8px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .scheduler_default_rowheader_inner
        {
            border-right: 1px solid #ccc;
        }
        .scheduler_default_rowheadercol2
        {
            background: White;
        }
        .scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            top: 2px;
            bottom: 2px;
            left: 2px;
            background-color: transparent;
            border-left: 5px solid #38761d; /* green */
            border-right: 0px none;
        }
        .status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            border-left: 5px solid #cc0000; /* red */
        }
        .status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
        {
            border-left: 5px solid #e69138; /* orange */
        }

        .area-menu {
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M 0.5 1.5 L 5 6.5 L 9.5 1.5' style='fill:none;stroke:%23999999;stroke-width:2;stroke-linejoin:round;stroke-linecap:butt' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center center;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 3px;
            opacity: 0.8;
            cursor: pointer;
        }

        .area-menu:hover {
            opacity: 1;
        }

    </style>
</head>
<body>
   <div class="main">
      <div style="width:220px; float:left;">
         <div id="nav"></div>
      </div>

      <div style="margin-left: 220px;">

         <div class="toolbar">

               Room filter:
               <select id="filter">
                  <option value="0">All</option>
                  <option value="1">Single</option>
                  <option value="2">Double</option>
                  <option value="4">Family</option>
               </select>

               &nbsp;&nbsp;

               <button id="addroom">Add Room</button>

               <div class="toolbar-separator"></div>

               Time range:
               <select id="timerange">
                  <option value="week">Week</option>
                  <option value="month" selected>Month</option>
               </select>
               <div class="toolbar-separator"></div>
               <label for="autocellwidth"><input type="checkbox" id="autocellwidth">Auto Cell Width</label>
         </div>
         <div id="dp"></div>
      </div>
   </div>

   <script src="{{ asset('assets/daypilot/daypilot-all.min.js') }}"></script>
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
   <script type="text/javascript">
      var nav = new DayPilot.Navigator("nav");
      nav.selectMode = "month";
      nav.showMonths = 3;
      nav.skipMonths = 3;
      nav.onTimeRangeSelected = function(args) {
         loadTimeline(args.start);
         loadReservations();
      };
      nav.init();

   </script>

   <script>
      var dp = new DayPilot.Scheduler("dp");

      dp.allowEventOverlap = false;

      dp.days = dp.startDate.daysInMonth();
      loadTimeline(DayPilot.Date.today().firstDayOfMonth());

      dp.eventDeleteHandling = "Update";

      dp.timeHeaders = [
         { groupBy: "Month", format: "MMMM yyyy" },
         { groupBy: "Day", format: "d" }
      ];

      dp.eventHeight = 80;
      dp.cellWidth = 60;

      dp.rowHeaderColumns = [
         {title: "Number Room", display: "name", sort: "name"},
         {title: "Capacity", display: "capacity", sort: "capacity"},
         {title: "Status", display:"code", sort:"code"}
      ];

      dp.separators = [
         { location: DayPilot.Date.now(), color: "red" }
      ];

      dp.contextMenuResource = new DayPilot.Menu({
         items: [
               { text: "Edit...", onClick: function(args) {
                     var capacities = [
                           {name: "1", id: 1},
                           {name: "2", id: 2},
                           {name: "4", id: 4},
                     ];

                     var statuses = [
                           {name: "Ready", id: "Ready"},
                           {name: "Cleanup", id: "Cleanup"},
                           {name: "Dirty", id: "Dirty"},
                     ];

                     var form = [
                           {name: "Room Name", id: "name"},
                           {name: "Capacity", id: "capacity", options: capacities},
                           {name: "Status", id: "status", options: statuses}
                     ];

                     var data = args.source.data;

                     DayPilot.Modal.form(form, data).then(function(modal) {
                           if (modal.canceled) {
                              return;
                           }

                           var room = modal.result;
                           DayPilot.Http.ajax({
                              url: "backend_room_update.php",
                              data: room,
                              success: function(ajax) {
                                 dp.rows.update(room);
                              }
                           });
                     });

                  }},
               { text: "Delete", onClick: function (args) {
                     var id = args.source.id;
                     DayPilot.Http.ajax({
                           url: "backend_room_delete.php",
                           data: {id: id},
                           success: function (ajax) {
                              dp.rows.remove(id);
                           }
                     });
                  }
               }
         ]
      });

      dp.onBeforeRowHeaderRender = function(args) {
         var beds = function(count) {
               return count + " bed" + (count > 1 ? "s" : "");
         };

         args.row.columns[1].html = beds(args.row.data.capacity);
         switch (args.row.data.code) {
               case "Dirty":
                  args.row.cssClass = "status_dirty";
                  break;
               case "Cleanup":
                  args.row.cssClass = "status_cleanup";
                  break;
         }

         args.row.columns[0].areas = [
               {right: 3, top: 3, width: 16, height: 16, cssClass: "area-menu", action: "ContextMenu", visibility: "Hover"}
         ];

      };

      // http://api.daypilot.org/daypilot-scheduler-oneventmoved/
      dp.onEventMoved = function (args) {
         DayPilot.Http.ajax({
               url: "backend_reservation_move.php",
               data: {
                  id: args.e.id(),
                  newStart: args.newStart,
                  newEnd: args.newEnd,
                  newResource: args.newResource
               },
               success: function(ajax) {
                  dp.message(ajax.data.message);
               }
         })
      };

      // http://api.daypilot.org/daypilot-scheduler-oneventresized/
      dp.onEventResized = function (args) {
         DayPilot.Http.ajax({
               url: "backend_reservation_resize.php",
               data: {
                  id: args.e.id(),
                  newStart: args.newStart,
                  newEnd: args.newEnd
               },
               success: function () {
                  dp.message("Resized.");
               }
         });
      };

      dp.onEventDeleted = function(args) {
         DayPilot.Http.ajax({
               url: "backend_reservation_delete.php",
               data: {
                  id: args.e.id()
               },
               success: function () {
                  dp.message("Deleted.");
               }
         });
      };

      // event creating
      // http://api.daypilot.org/daypilot-scheduler-ontimerangeselected/
      dp.onTimeRangeSelected = function (args) {

         var rooms = dp.resources.map(function(item) {
               return {
                  name: item.name,
                  id: item.id
               };
         });

         var form = [
               {name: "Text", id: "text"},
               {name: "Start", id: "start", dateFormat: "MM/dd/yyyy HH:mm tt"},
               {name: "End", id: "end", dateFormat: "MM/dd/yyyy HH:mm tt"},
               {name: "Room", id: "resource", options: rooms},
         ];

         var data = {
               start: args.start,
               end: args.end,
               resource: args.resource
         };

         DayPilot.Modal.form(form, data).then(function (modal) {
               dp.clearSelection();
               if (modal.canceled) {
                  return;
               }
               var e = modal.result;
               DayPilot.Http.ajax({
                  url: "backend_reservation_create.php",
                  data: e,
                  success: function(ajax) {
                     e.id = ajax.data.id;
                     e.paid = ajax.data.paid;
                     e.status = ajax.data.status;
                     dp.events.add(e);
                  }
               });
         });

      };

      dp.onBeforeEventRender = function(args) {
         var start = new DayPilot.Date(args.data.start);
         var end = new DayPilot.Date(args.data.end);

         var today = DayPilot.Date.today();
         var now = new DayPilot.Date();

         args.data.html = DayPilot.Util.escapeHtml(args.data.text) + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

         switch (args.data.code) {
               case "New":
                  var in2days = today.addDays(1);

                  if (start < in2days) {
                     args.data.barColor = '#cc0000';
                     args.data.toolTip = 'Expired (not confirmed in time)';
                  }
                  else {
                     args.data.barColor = '#e69138';
                     args.data.toolTip = 'New';
                  }
                  break;
               case "Confirmed":
                  var arrivalDeadline = today.addHours(18);

                  if (start < today || (start.getDatePart() === today.getDatePart() && now > arrivalDeadline)) { // must arrive before 6 pm
                     args.data.barColor = "#cc4125";  // red
                     args.data.toolTip = 'Late arrival';
                  }
                  else {
                     args.data.barColor = "#38761d";
                     args.data.toolTip = "Confirmed";
                  }
                  break;
               case 'Arrived': // arrived
                  var checkoutDeadline = today.addHours(10);

                  if (end < today || (end.getDatePart() === today.getDatePart() && now > checkoutDeadline)) { // must checkout before 10 am
                     args.data.barColor = "#cc4125";  // red
                     args.data.toolTip = "Late checkout";
                  }
                  else
                  {
                     args.data.barColor = "#1691f4";  // blue
                     args.data.toolTip = "Arrived";
                  }
                  break;
               case 'CheckedOut': // checked out
                  args.data.barColor = "gray";
                  args.data.toolTip = "Checked out";
                  break;
               default:
                  args.data.toolTip = "Unexpected state";
                  break;
         }

         args.data.html = "<div>" + args.data.html + "<br /><span style='color:gray'>" + args.data.toolTip + "</span></div>";

         var paid = args.data.paid;
         var paidColor = "#aaaaaa";

         args.data.areas = [
               { bottom: 10, right: 4, html: "<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>", v: "Visible"},
               { left: 4, bottom: 8, right: 4, height: 2, html: "<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>", v: "Visible" }
         ];

      };


      dp.init();

      var elements = {
         filter: document.querySelector("#filter"),
         timerange: document.querySelector("#timerange"),
         autocellwidth: document.querySelector("#autocellwidth"),
         addroom: document.querySelector("#addroom"),
      };

      loadRooms();
      loadReservations();

      function loadTimeline(date) {
         dp.scale = "Manual";
         dp.timeline = [];
         var start = date.getDatePart().addHours(12);

         for (var i = 0; i < dp.days; i++) {
               dp.timeline.push({start: start.addDays(i), end: start.addDays(i+1)});
         }
         dp.update();
      }

      function loadReservations() {
         dp.events.load("backend_reservations.php");
      }

      function loadRooms() {
         DayPilot.Http.ajax({
               
               url: "{{ route('data.rooms') }}",
               data: { 
                  capacity: elements.filter.value,
                  _token: "{{ csrf_token() }}",
                  dataType: 'json', 
                  contentType:'application/json', 
               },
               success: function(args) {
                  dp.resources = args.data;
                  dp.update();
               }
         })
      }

      elements.filter.addEventListener("change", function(e) {
         loadRooms();
      });

      elements.timerange.addEventListener("change", function() {
         switch (this.value) {
               case "week":
                  dp.days = 7;
                  nav.selectMode = "Week";
                  nav.select(nav.selectionDay);
                  break;
               case "month":
                  dp.days = dp.startDate.daysInMonth();
                  nav.selectMode = "Month";
                  nav.select(nav.selectionDay);
                  break;
         }
      });

      elements.autocellwidth.addEventListener("click", function() {
         dp.cellWidth = 60;  // reset for "Fixed" mode
         dp.cellWidthSpec = this.checked ? "Auto" : "Fixed";
         dp.update();
      });

   </script>
</body>
</html>