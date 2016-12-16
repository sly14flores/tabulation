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
		$scope.contestants_list = response.data['contestants_list'];
		$scope.judges_list = response.data['judges_list'];
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
				
				$scope.winners = response.data['winners'];
				$scope.consolations = response.data['consolations'];
			
			}, function myError(response) {
				
			});	

		};

	};
	
	$scope.editContestant = function(id) {
		
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
			frm += '</form>';
			
		bootstrapModal.confirm($scope,'Contestant',frm,function() { contestantStatus();  },function() {});		
			
		$http({
		  method: 'POST',
		  url: 'controllers/dashboard.php?r=contestant_status',
		  data: {id: id}
		}).then(function mySucces(response) {
			
			$timeout(function() { $scope.contestant_status = response.data; },500);
		
		}, function myError(response) {
			
		});		
		
		function contestantStatus() {
			
			$http({
			  method: 'POST',
			  url: 'controllers/dashboard.php?r=contestant',
			  data: {id: id, no: $scope.contestant_status.no, is_active: $scope.contestant_status.participated}
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
			frm += '<label>No</label>';
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
			
		}
		
	};	
	
	$scope.printWinners = function() {
		
		window.open("reports/winners.php");
		
	};
	
	$scope.printConsolations = function() {

		window.open("reports/consolation-prizes.php");	
	
	};

});	