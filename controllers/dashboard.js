var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$http,$scope,bootstrapNotify,blockUI) {
	
	$scope.views = {};
	
	$scope.views.criteria = {
		1: true,
		2: true,
		3: true,
		4: true,
		5: true,
		6: true
	};
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=startup'
	}).then(function mySucces(response) {
		
		$scope.views.judge = response.data['judge']['name'];
		$scope.contestants = response.data['contestants'];
		
	}, function myError(response) {
		
	});

	$scope.tabulate = function(id) {
		
		blockUI.show('Please wait...');
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=tabulate',
		  data: {id: id}
		}).then(function mySucces(response) {
			
			$scope.views.contestant = response.data['contestant'];
			$scope.criteria = response.data['criteria'];
			blockUI.hide();
			
		}, function myError(response) {
			
		});		
		
	}
	
	$scope.score = function(criterion) {

		$scope.views.criteria[criterion.criteria_id] = !$scope.views.criteria[criterion.criteria_id];
		
		if ($scope.views.criteria[criterion.criteria_id]) {

			blockUI.show("Saving please wait...");
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=save',
			  data: {id: criterion.id, score: criterion.score}
			}).then(function mySucces(response) {
			
				blockUI.hide();
				
			}, function myError(response) {
				
			});			
			
		}
		
	}
	
})