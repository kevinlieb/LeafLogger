  function saveTripToSession(start,end) {
    $.getJSON('SaveTripToSession.php?start=' + start + "&end=" + end, function(json) {
    });
  }

  function readTripFromSession() {
    $.getJSON('ReadTripFromSession.php', function(json) {
      var start = json['start'];
      var end = json['end'];
    });
  }
  
  