var app = angular.module("myApp", ["ngRoute"]);

  app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "templates/main.html",
		controller: 'servers'
    })
  });
  
  app.controller('servers' , ['$scope', '$http', function($scope, $http) {
   $scope.token = $("#token").val();
   $scope.message = "";
   
   $scope.showLoading = function() {
	   $("#loading").addClass("actif");
	   $("#singlePage").addClass("loading");
	   $('.modal').modal('hide'); // close all modals
   } 
   
    $scope.resetPage = function(data) {
		$("#loading .message").text(data);
		$("#loading").addClass("loaded");
		$("#loading").addClass("success");
		$scope.getServers();
		
		// remove add form values
	   $("#addModal").find("input[name='serverName']").val('');
	   $("#addModal").find("select[name='serverlocation']").val('Montreal');
	   $("#addModal").find("select[name='servertype']").val('Web Server');		
		
		setTimeout(function(){  
          $("#singlePage").removeClass("loading");		
		  $("#loading").removeClass("actif");
		  $("#loading").removeClass("loaded");
		  $("#loading").removeClass("success");
		  $scope.$apply();
		}, 2700);
		
		
   } 
  
  // get all servers
  $scope.getServers = function() {
	$scope.message = "";
	var jqxhr = 
	$.ajax({
     method: "POST",
     url: "controls.php",
     data: {action:'servers', token: $scope.token },
		
    })
    .done(function(data) {
	  data = JSON.parse(data);
	  $scope.servers = data;
	  $scope.$apply();
    })
    .fail(function(data) {
		 $scope.servers = data;
    })
  };

  // show edit pop-up
  $scope.showModal = function(that){
	$("#myModal").find("input[name='serverId']").val(Number(that.x.id));
	$("#myModal").find("input[name='serverName']").val(that.x.name);
	$("#myModal").find("select[name='serverlocation']").val(that.x.location);
	$("#myModal").find("select[name='servertype']").val(that.x.type);
    $("#myModal").modal();
  }
  
   // re-order servers
   $scope.orderByMe = function(x) {
        $scope.myOrderBy = x;
    }
	
	
	// earse filters   
   $scope.eraseFilter = function(x){
		$scope.selectedType = '';
		$scope.selectedLocation = '';
    }
	

    // edit a server
   $scope.editServer = function(){
    var id  = $("#myModal").find("input[name='serverId']").val();
	var name = $("#myModal").find("input[name='serverName']").val();
	var location = $("#myModal").find("select[name='serverlocation']").val();
	var type = $("#myModal").find("select[name='servertype']").val();
	
	var jqxhr = 
	$.ajax({
       method: "POST",
       url: "controls.php",
       data: {action:'edit', token: $scope.token, serverId: Number(id), serverName: name, serverLocation: location, serverType: type },
	   beforeSend: function(){
        $scope.showLoading();
       },
	
    })
    .done(function(data) {
	  $scope.resetPage(data);

    })
    .fail(function(data) {
     //alert( "error" );
    })
  };
  
  
   $scope.addServer = function(){
	var name = $("#addModal").find("input[name='serverName']").val();
	var location = $("#addModal").find("select[name='serverlocation']").val();
	var type = $("#addModal").find("select[name='servertype']").val();

	var jqxhr = 
	$.ajax({
       method: "POST",
       url: "controls.php",
       data: {action:'add', token: $scope.token, serverName: name, serverLocation: location, serverType: type },
	   beforeSend: function(){
        $scope.showLoading();
       },
	
    })
    .done(function(data) {
	  $scope.resetPage(data);

    })
    .fail(function(data) {
      alert( "error" );
    })
  };  
  
  
  // add server pop-up
  $scope.showAddModal = function(){
    $("#addModal").modal();
  }
  
}]);

   app.directive("gaugeHigh", function() {
    return {
        template : '<div class="containerGauge"> <svg id="Gauge" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 111.98 111.98"> <defs> <style>.gaugeBackground{fill:#fff;}.gaugeOutline,.pointer{fill:#64aa55;}.topGaugeBackground{fill:#646464;}.bottomGauge{fill:#a7a9ad;}.topGauge,.marker,.rect{fill:none;}.pointer,.marker{stroke:#fff;stroke-linejoin:round;stroke-width:1.2px;}.marker{stroke-linecap:round;}</style> </defs> <title>Gauge</title> <g id="gaugeGroup" data-name="gaugeGroup"> <circle class="gaugeBackground" cx="55.99" cy="55.99" r="55.24" transform="translate(-8.25 102.29) rotate(-80.78)"/> <path class="gaugeOutline" d="M56,1.5A54.49,54.49,0,1,1,1.5,56,54.55,54.55,0,0,1,56,1.5M56,0a56,56,0,1,0,56,56A56,56,0,0,0,56,0Z"/> <path class="topGaugeBackground" d="M79.06,56.06h23.07a46.14,46.14,0,0,0-92.28,0H32.92"/> <path class="bottomGauge" d="M56,102.65a46.66,46.66,0,0,0,46.42-42H9.56A46.68,46.68,0,0,0,56,102.65Z"/> <path class="topGauge" d="M56,9.33A46.66,46.66,0,0,0,9.33,56c0,1.58.08,3.13.23,4.67h92.85a45.07,45.07,0,0,0,.24-4.67A46.66,46.66,0,0,0,56,9.33Z"/> <line class="marker" x1="17.38" y1="39.2" x2="28.38" y2="44.2"/> <line class="marker" x1="28.84" y1="22.21" x2="36.92" y2="31.19"/> <line class="marker" x1="56.88" y1="12.66" x2="56.88" y2="24.74"/> <line class="marker" x1="80.92" y1="22.21" x2="72.84" y2="31.19"/> <line class="marker" x1="95.38" y1="39.2" x2="84.38" y2="44.2"/> <path class="pointer animate autoAnimation" d="M59.68,52.28,56.88,24.7l-2.8,27.58a7,7,0,1,0,5.6,0Z"/> </g> </svg> </div>'
     }
	});
	
	app.directive("gaugeMedium", function() {
    return {
        template : '<div class="containerGauge"> <svg id="Gauge" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 111.98 111.98"> <defs> <style>.gaugeBackground{fill:#fff;}.gaugeOutline,.pointer{fill:#64aa55;}.topGaugeBackground{fill:#646464;}.bottomGauge{fill:#a7a9ad;}.topGauge,.marker,.rect{fill:none;}.pointer,.marker{stroke:#fff;stroke-linejoin:round;stroke-width:1.2px;}.marker{stroke-linecap:round;}</style> </defs> <title>Gauge</title> <g id="gaugeGroup" data-name="gaugeGroup"> <circle class="gaugeBackground" cx="55.99" cy="55.99" r="55.24" transform="translate(-8.25 102.29) rotate(-80.78)"/> <path class="gaugeOutline" d="M56,1.5A54.49,54.49,0,1,1,1.5,56,54.55,54.55,0,0,1,56,1.5M56,0a56,56,0,1,0,56,56A56,56,0,0,0,56,0Z"/> <path class="topGaugeBackground" d="M79.06,56.06h23.07a46.14,46.14,0,0,0-92.28,0H32.92"/> <path class="bottomGauge" d="M56,102.65a46.66,46.66,0,0,0,46.42-42H9.56A46.68,46.68,0,0,0,56,102.65Z"/> <path class="topGauge" d="M56,9.33A46.66,46.66,0,0,0,9.33,56c0,1.58.08,3.13.23,4.67h92.85a45.07,45.07,0,0,0,.24-4.67A46.66,46.66,0,0,0,56,9.33Z"/> <line class="marker" x1="17.38" y1="39.2" x2="28.38" y2="44.2"/> <line class="marker" x1="28.84" y1="22.21" x2="36.92" y2="31.19"/> <line class="marker" x1="56.88" y1="12.66" x2="56.88" y2="24.74"/> <line class="marker" x1="80.92" y1="22.21" x2="72.84" y2="31.19"/> <line class="marker" x1="95.38" y1="39.2" x2="84.38" y2="44.2"/> <path class="pointer animate autoAnimation" d="M59.68,52.28,56.88,24.7l-2.8,27.58a7,7,0,1,0,5.6,0Z"/> </g> </svg> </div>'
     }
	});
	
	app.directive("gaugeLow", function() {
    return {
        template : '<div class="containerGauge"> <svg id="Gauge" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 111.98 111.98"> <defs> <style>.gaugeBackground{fill:#fff;}.gaugeOutline,.pointer{fill:#64aa55;}.topGaugeBackground{fill:#646464;}.bottomGauge{fill:#a7a9ad;}.topGauge,.marker,.rect{fill:none;}.pointer,.marker{stroke:#fff;stroke-linejoin:round;stroke-width:1.2px;}.marker{stroke-linecap:round;}</style> </defs> <title>Gauge</title> <g id="gaugeGroup" data-name="gaugeGroup"> <circle class="gaugeBackground" cx="55.99" cy="55.99" r="55.24" transform="translate(-8.25 102.29) rotate(-80.78)"/> <path class="gaugeOutline" d="M56,1.5A54.49,54.49,0,1,1,1.5,56,54.55,54.55,0,0,1,56,1.5M56,0a56,56,0,1,0,56,56A56,56,0,0,0,56,0Z"/> <path class="topGaugeBackground" d="M79.06,56.06h23.07a46.14,46.14,0,0,0-92.28,0H32.92"/> <path class="bottomGauge" d="M56,102.65a46.66,46.66,0,0,0,46.42-42H9.56A46.68,46.68,0,0,0,56,102.65Z"/> <path class="topGauge" d="M56,9.33A46.66,46.66,0,0,0,9.33,56c0,1.58.08,3.13.23,4.67h92.85a45.07,45.07,0,0,0,.24-4.67A46.66,46.66,0,0,0,56,9.33Z"/> <line class="marker" x1="17.38" y1="39.2" x2="28.38" y2="44.2"/> <line class="marker" x1="28.84" y1="22.21" x2="36.92" y2="31.19"/> <line class="marker" x1="56.88" y1="12.66" x2="56.88" y2="24.74"/> <line class="marker" x1="80.92" y1="22.21" x2="72.84" y2="31.19"/> <line class="marker" x1="95.38" y1="39.2" x2="84.38" y2="44.2"/> <path class="pointer animate autoAnimation" d="M59.68,52.28,56.88,24.7l-2.8,27.58a7,7,0,1,0,5.6,0Z"/> </g> </svg> </div>'
     }
	});	
	
	app.directive("location", function() {
    return {
		template : ' <div class="form-group"> <label for="serverlocation">Select location:</label> <select class="form-control" name="serverlocation"> <option value="Montreal">Montreal</option> <option value="Vancouver">Vancouver</option> <option value="Toronto">Toronto</option> </select></div>'
     }
	});
	
	app.directive("servertype", function() {
    return {
		template : ' <div class="form-group"> <label for="servertype">Select type:</label> <select class="form-control" name="servertype"> <option value="Web Server">Web Server</option> <option value="Mail Server">Mail Server</option><option value="Proxy Server">Proxy Server</option><option value="FTP Server">FTP Server</option></select></div>'
     }
	});	
