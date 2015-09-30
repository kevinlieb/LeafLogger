<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>LeafLogs Example</title>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">
    <link rel="stylesheet" href="css/datatable.css" />        
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />    
    <script src="js/jquery.selectboxes.js"></script>
    <script src="js/jQueryRotate.js"></script>
    <link rel="stylesheet" href="css/chart1css.css" />  
    
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.13&amp;sensor=false"></script>
   <script type="text/javascript" src="js/markerwithlabel.js"></script>
   <script type="text/javascript" src="js/fnReloadAjax.js"></script>   
   <script src="js/DistanceBetweenPoints.js"></script>
  
   <script type="text/javascript">
    var markersArray = [];
    var positionsArray = [];
    var thePath;
    var defaultStart = "2013-09-24%2012:00:00";
    var defaultEnd = "2013-09-24%2013:00:00";
    var geoData = {};
    var theDataTable;

    $(function() {
      $( ".datepicker" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
      });
      $( "#submitter" ).click(function() {
        var serializedData = $("#pickthedates").serialize();
        alert("data is " + serializedData);
        $.ajax({
          type: "POST",
          data:{"start":$('#startdate').val(),"end":$('#enddate').val()},
          url: "CoordinatesFeed.php",
          success: function(data) {
            processCoordinateData(data);
          }
        });
        
      });
    });

    initHighcharts(defaultStart, defaultEnd);
    
    function initHighcharts(start,end) {
    $(function () {
      Highcharts.Data.prototype.dateFormats['Y-m-d h:m:s'] = {
        regex: '^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2}) [0-9]{2}\:[0-9]{2}\:[0-9]{2}\$',
        parser: function (match) {
          return Date.UTC(+('20' + match[3]), match[1] - 1, +match[2], match[4], match[5], match[6]);
        }
      };

      // Get the CSV and create the chart
      $.get("GenericFeed.php?fields=leaflogs_timestamp,leaflogs_elevation,leaflogs_elevation_lookedup&start=" + start + "&end=" + end, function (csv) {
        $('#containerElevation').highcharts({
          chart: {
	          events: {
	        	  load: function() {
                $('#containerElevation').highcharts().xAxis[0].update({"tickInterval":(this.series[0].points.length / 20)});
              }
            }
          },
          
          data: {
            csv: csv
          },

          title: {
            text: 'SOC'
          },
          xAxis: {
            type: 'datetime',
            ordinal: false,
            tickInterval: 25, // 10 minutes
            tickWidth: 0,
            gridLineWidth: 1,
            labels: {
              align: 'left',
                x: 3,
                y: -3
            }
          },
          yAxis: [{ // left y axis
            title: {
              text: null
            },
            labels: {
              align: 'left',
              x: 3,
              y: 16,
              formatter: function() {
                return Highcharts.numberFormat(this.value, 0);
              }
            },
            showFirstLabel: false
          }, 
          { // right y axis
            linkedTo: 0,
            gridLineWidth: 0,
            opposite: true,
            title: {
              text: null
            },
            labels: {
              align: 'right',
              x: -3,
              y: 16,
              formatter: function() {
                 return Highcharts.numberFormat(this.value, 0);
              }
            },
            showFirstLabel: false
          }],
          legend: {
            align: 'left',
            verticalAlign: 'top',
            y: 20,
            floating: true,
              borderWidth: 0
          },
          tooltip: {
            shared: true,
            crosshairs: true
          },
          plotOptions: {
            series: {
              cursor: 'pointer',
              point: {
                events: {
                  click: function() {
                    //console.log(this);
                    hs.htmlExpand(null, {
                      pageOrigin: {
                        x: this.pageX,
                        y: this.pageY
                      },
                      headingText: this.series.name,
                      maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ this.y +' visits', width: 200
                    });
                  },
                  mouseOver: function() {
                    console.log(this.category);      
                  }  
                  
                }
              },
              marker: {
                states: {
                  select: {
                    fillColor: 'red',
                    lineWidth: 2
                  }
                },
                enabled: false,
                lineWidth: 1
              }
            }
          },
          series: [{
            type: 'spline',
            name: '',
            lineWidth: 4,
            marker: {
              radius: 4
            }
          },
          {
            type: 'spline',
            name: '',
            lineWidth: 4,
            marker: {
              radius: 4
            }
          }]
        });
      });
    });
    }


    $('#containerElevation').highcharts;

    </script>
                
    <script>
      function highlightChartPoint(pointNumber) {
        console.log("hover over " + pointNumber);
        $('#containerSOC').highcharts().series[0].points[pointNumber].select();
      }
    </script>                
  </head>
<body>
  <script src="js/highcharts.js"></script>
  <script src="js/modules/data.js"></script>
  <script src="js/modules/exporting.js"></script>



  <!--<form name="pickthedates" id="pickthedates">
  <p>Start Date: <input type="text" id="startdate" class="datepicker" />
  End Date: <input type="text" id="enddate" class="datepicker" />
  <a href='#' id="submitter">Submit</a>-->
  <div id="topnavbar" style="width:100%; float:left; margin-left: 20px;">  
    <div id='fullname' name='fullname' style='float: left; width:27%'></div>
    <div id='totaltrips' name='totaltrips' style='float: left; width:27%'>---------</div>
    <div id='logout' class='navbuttons'><B><center>Log out</center></B></div>
    <div id='upload' class='navbuttons'><B><center>Upload</center></B></div>
    <div id='main' class='navbuttons'><B><center>Main</center></B></div>
  </div>
  
  <div id="topinfobar" style="width:100%; float:left; margin-left: 20px;">
    <div id="selectarea" style="float:left">Select a trip:</div><select name="myselect" style="float:left" id="myselect" onChange="pulldownChange(this)"><option value="|" selected>----------</option></select>
    <div name="summary" id="summary" style="float:left; margin-left: 20px"></div>
  </div>
  <BR>
  <div id="chartandmap" style="float: left; width:100%">
    <div id="containerElevation" style="float: left; width: 100%; height: 600px; margin: 0 auto"></div>
  </div>
  <script>
    $(document).ready(function() {
      $('#logout').click(function() {
        $.getJSON('Logout.php', function(json) {
          window.location.replace('Login.html');
          //updateData('2013-1-1 00:00:00','2013-1-1 00:00:00');
        });
      });
      $('#upload').click(function() {
          window.location.replace('LogUploader.html');        
      });

      $('#main').click(function() {
          window.location.replace('chart1.html');        
      });
      
      $.getJSON('GetUserInfo.php', function(json) {
        if(json.fullname == undefined) {
          $('#fullname').html("<a href='Login.html'>You must be logged in to view data</a>");
          $('#upload').hide();
          $('#logout').html("<B><center>Log in</b></center>");
        }
        else {
          $('#fullname').html("<b>Welcome back</b> " + json.fullname);
        }
      });
      
      
      $.getJSON('FindDateRanges.php', function(json) {
        $('#totaltrips').html("<b>Total trips:</b> " + json.length);
        //console.log(json);
        for(var eachthing in json) {
          $("#myselect").addOption(json[eachthing]['start'] + "|" + json[eachthing]['end'], json[eachthing]['start'] + " to " + json[eachthing]['end'] + " ( " + json[eachthing]['records'] + ")");
        }
        setTimeout(function() { 
          $("#myselect").val($("#myselect option:last").val());
          pulldownChange($("#myselect option:last").val());        
        }, 1000);
        
      });
      
      loadTripSummaryData(defaultStart, defaultEnd);
      
    });
  
  function loadTripSummaryData(start, end) {
      $.getJSON('TripSummary.php?start=' + start + "&end=" + end, function(json) {
        var output = "<B>Length: </b>" + json['trip_length'] + " mins |  " +
                     "<b>Start: </B>" + numberWithCommas(json['start']) + "  |  " +
                     "<b>End: </B>" + numberWithCommas(json['end']) + "  |  " +
                     "<b>Dist: </B>" + json['trip'] + " " + json['distance_units'] + " |  " +
                     "<b>Avg Spd: </B>" + json['averageSpeed'] + " " + json['speed_units'] +  " |  " +
                     "<b>SOC Diff: </B>" + json['socDifference'] + "%  |  " +
                     "<b>GIDS Diff: </B>" + json['gidsDifference'];
          $("#summary").html(output);
      });            
  }
  
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  
  
  function updateData(start, end) {
    initHighcharts(start,end);
  }
  
  
  function pulldownChange(theobject) {
    //console.log("Object type is " + Object.prototype.toString.call(theobject));
    if(Object.prototype.toString.call(theobject) == "[object HTMLSelectElement]" ) {
      startandend = theobject.value.split("|");
    }
    else {
      //console.log("String object and it is " + theobject)
      startandend = theobject.split("|");
    }
    //console.log(theobject.value);
      //  //var startandend = this.value.split("|");
      //console.log("start is " + startandend[0] + " and end is " + startandend[1]);
      updateData(startandend[0],startandend[1]);
  }
  </script>

  
</body>
</html>
