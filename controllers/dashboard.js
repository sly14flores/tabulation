var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$http,$scope,bootstrapNotify,blockUI) {
	
	$scope.views = {};
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=judge'
	}).then(function mySucces(response) {
		
		$scope.views.judge = response.data['name'];
		
	}, function myError(response) {
		
	});		
	
})