var app = angular.module('dashboard', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('dashboardCtrl',function($window,$timeout,$interval,$http,$scope,bootstrapNotify,blockUI,bootstrapModal) {
	
	$scope.views = {};	
	$scope.views.portionIndex = 0;
	
	/*
	** startup
	*/	
	$http({
	  method: 'POST',
	  url: 'controllers/dashboard.php?r=startup'
	}).then(function mySucces(response) {

		$scope.judges_list = response.data['judges_list'];
		$scope.contestants_list = response.data['contestants_list'];
		$scope.portions = response.data['portions'];
		
	}, function myError(response) {
		
	});
	
	$scope.editContestant = function(contestant) {
		
		$scope.contestant_status = {};
		
		$scope.views.contestant_status = {
			"No": 0,
			"Yes": 1
		};
		
		var frm = '<form>';
			frm += '<div class="form-group">';
			frm += '<label>No</label>';
			frm += '<input class="form-control" name="no" ng-model="contestant_status.no" type="number">';
			frm += '</div>';
			frm += '<div class="form-group">';
			frm += '<label>Participated</label>';
			frm += '<select class="form-control" name="participated" ng-model="contestant_status.participated" ng-options="x for (x,y) in views.contestant_status track by y">';
			frm += '<option value="">-</option>';
			frm += '</select>';
			frm += '</div>';
			frm += '<div class="form-group">';
			
			frm += '<div class="checkbox" ng-repeat="portion in contestant_status.portions">';
			frm += '<label>';
			frm += '<input type="checkbox" ng-model="portion.value"> {{portion.description}}';
			frm += '</label>';
			frm += '</div>';					

			frm += '</div>';
			frm += '</form>';
			
		bootstrapModal.confirm($scope,contestant.cluster_name,frm,function() { contestantStatus();  },function() {});		
			
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=contestant_status',
		  data: {id: contestant.id}
		}).then(function mySucces(response) {
			
			$timeout(function() { $scope.contestant_status = response.data; },500);
		
		}, function myError(response) {
			
		});		
		
		function contestantStatus() {
			
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=contestant',
			  data: {id: contestant.id, no: $scope.contestant_status.no, is_active: $scope.contestant_status.participated, portions: $scope.contestant_status.portions}
			}).then(function mySucces(response) {
				
				$scope.contestants_list = response.data['contestants_list'];
			
			}, function myError(response) {
				
			});				
			
		}
		
	};
	
	$scope.editJudge = function(id) {
		
		$scope.judge_status = {};
		
		$scope.judge_status.remarks = "";
		
		var frm = '<form>';
			frm += '<div class="form-group">';
			frm += '<label>Remarks</label>';
			frm += '<input class="form-control" name="remarks" ng-model="judge_status.remarks" type="text">';
			frm += '</div>';			
			frm += '</form>';
			
		bootstrapModal.confirm($scope,'Judge',frm,function() { judgeStatus();  },function() {});		
			
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=judge_status',
		  data: {id: id}
		}).then(function mySucces(response) {
			
			$timeout(function() { $scope.judge_status.remarks = response.data; },500);
		
		}, function myError(response) {
			
		});		
		
		function judgeStatus() {
			
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=judge',
			  data: {id: id, remarks: $scope.judge_status.remarks}
			}).then(function mySucces(response) {
				
			$scope.judges_list = response.data['judges_list'];
			
			}, function myError(response) {
				
			});				
			
		};
		
	};
	
	$scope.refreshStanding = function() {
		
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=startup'
		}).then(function mySucces(response) {

			$scope.judges_list = response.data['judges_list'];
			$scope.contestants_list = response.data['contestants_list'];
			$scope.portions = response.data['portions'];
			
		}, function myError(response) {
			
		});		
		
	};
	
	$scope.logIndex = function(scope,index,portion) {
		
		scope.views.portionIndex = index;
		
	};	

});	