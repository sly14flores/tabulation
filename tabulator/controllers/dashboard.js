var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$interval,$http,$scope,bootstrapNotify,blockUI,bootstrapModal) {
	
	$scope.views = {};
	
	$scope.views.filter = 'Overall';
	$scope.views.opt = {id: 0, name: 'Overall'};
	$scope.views.tabulation = 0;
	
	$scope.views.declareWinners = false;
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=startup'
	}).then(function mySucces(response) {

		$scope.judges = response.data['judges'];
		$scope.contestants = response.data['contestants'];
		$scope.winners = response.data['winners'];
		$scope.consolations = response.data['consolations'];
		
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
		
		$scope.views.declareWinners = true;
		
		if (opt.name == 'Overall') $scope.views.declareWinners = false;
		
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
	
	$scope.tabulation = function(id) {
		
		$scope.views.tabulation = id;
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=tabulation',
		  data: {id: id}
		}).then(function mySucces(response) {
			
			$scope.views.contestant_no = "No. "+response.data['contestant']['no']+":";
			$scope.views.contestant = response.data['contestant']['cluster_name'];
			$scope.views.judges = response.data['judges'];
		
		}, function myError(response) {
			
		});		
		
	}
	
	$interval(function() {

		if ($scope.views.tabulation != 0) $scope.tabulation($scope.views.tabulation);
	
	},2000);
	
	$scope.declareWinners = function() {
		
		bootstrapModal.confirm($scope,'Confirmation','Are you sure you want to declare winners?',function() { winners(); },function() {});		
		
		function winners() {
			
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=winners',
			  data: $scope.standing
			}).then(function mySucces(response) {

			
			}, function myError(response) {
				
			});	

		};

	};
	
});	