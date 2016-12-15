var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$interval,$http,$scope,bootstrapNotify,blockUI) {
	
	$scope.views = {};
	
	$scope.views.filter = 'Overall';
	$scope.views.opt = {id: 0, name: 'Overall'};
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=startup'
	}).then(function mySucces(response) {

		$scope.judges = response.data['judges'];
		
	}, function myError(response) {
		
	});	

	
	/*
	** standing
	*/
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=standing',
	  data: {id: 0}
	}).then(function mySucces(response) {
		
		$scope.standing = response.data;
	
	}, function myError(response) {
		
	});
	
	$interval(function() {

		$scope.loadStanding($scope.views.opt);
	
	},2000);	
	
	$scope.loadStanding = function(opt) {
		
		// blockUI.show();
		$scope.views.opt = opt;
		$scope.views.filter = opt.name;
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=standing',
		  data: {id: opt.id}
		}).then(function mySucces(response) {
			
			$scope.standing = response.data;
			// blockUI.hide();
		
		}, function myError(response) {
			
		});		
		
	}
	
});	