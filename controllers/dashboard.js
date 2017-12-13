var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$interval,$http,$scope,bootstrapNotify,blockUI) {
	
	$scope.views = {};
	
	$scope.views.edit = false;
	
	$scope.views.portionIndex = 0;	
	$scope.views.currentContestant = 0;
	$scope.views.currentPortion	= '';
	$scope.views.currentPortionId = 0;
	
	$scope.views.criteria = {
		1: true,
		2: true,
		3: true,
		4: true,
		5: true,
		6: true
	};
	
	$scope.criteria = [];	
	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=startup'
	}).then(function mySucces(response) {

		$scope.views.judge = response.data['judge']['name'];
		$scope.contestants = response.data['contestants'];
		$scope.portions = response.data['portions'];
		if ($scope.portions.length > 0) {
			$scope.views.currentPortion = $scope.portions[0].description;
			$scope.views.currentPortionId = $scope.portions[0].id;
		}
		
	}, function myError(response) {
		
	});
	
	/*
	** standing
	*/
	
	$timeout(function() {
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=standing',
		  data: {portion_id: $scope.views.currentPortionId}
		}).then(function mySucces(response) {
			
			$scope.standing = response.data;
		
		}, function myError(response) {
			
		});
		
	}, 300);
	
/* 	$interval(function() {
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=standing'
		}).then(function mySucces(response) {
			
			$scope.standing = response.data;
		
		}, function myError(response) {
			
		});		
		
	},2000); */
	
	$scope.refreshStanding = function(scope) {
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=standing',
		  data: {portion_id: scope.views.currentPortionId}
		}).then(function mySucces(response) {
			
			$scope.standing = response.data;
		
		}, function myError(response) {
			
		});			
		
	};
	
	$scope.tabulate = function(contestant_id,portion_id) {
		
		$scope.views.edit = false;
		
		$scope.views.currentContestant = contestant_id;
		
		blockUI.show('Please wait...');
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=tabulate',
		  data: {contestant_id: contestant_id, portion_id: portion_id}
		}).then(function mySucces(response) {
			
			$scope.views.contestant_no = "No. "+response.data['no'];			
			$scope.views.contestant = response.data['contestant'];
			$scope.criteria = response.data['criteria'];
			blockUI.hide();
			
		}, function myError(response) {
			
		});		
		
	}
	
	$scope.score = function(criterion,index) {
	
		$scope.views.criteria[criterion.criteria_id] = !$scope.views.criteria[criterion.criteria_id];		

		if ($scope.views.criteria[criterion.criteria_id]) {

			if (criterion.score == 0) console.log(criterion.score);
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
	
	$scope.scores = function(scope) {
		
		scope.views.edit = !scope.views.edit;
		
		if (scope.views.edit) {

			blockUI.show("Saving please wait...");
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=save_scores',
			  data: scope.criteria
			}).then(function mySucces(response) {
			
				blockUI.hide();
				
			}, function myError(response) {
				
			});				
			
		};
		
	}

	$scope.logIndex = function(index,portion) {				
		
		$scope.views.portionIndex = index;
		$scope.views.currentPortion = portion.description;
		$scope.views.currentPortionId = portion.id;
		
		$timeout(function() {
			$scope.refreshStanding($scope);
			$scope.portionContestants();
		},300);
		
		$scope.views.contestant_no = '';			
		$scope.views.contestant = '';
		$scope.criteria = [];
		
	};

	$scope.portionContestants = function() {
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=portions_contestants',
		  data: {portion_id: $scope.views.currentPortionId}
		}).then(function mySucces(response) {

			$scope.contestants = response.data;

		}, function myError(response) {

		});			
		
	};
	
	$scope.logout = function() {
		
		$window.location.href = 'logout.php';
	
	}
	
});