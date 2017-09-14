var app = angular.module('signup', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('signupCtrl',function($window,$timeout,$http,$scope,bootstrapNotify,blockUI) {
	
	$scope.views = {};
	$scope.judge = {};
	
	$http({
	  method: 'POST',
	  url: 'controllers/signup.php?r=token'  
	}).then(function mySucces(response) {
		
		$scope.views.token = response.data['signup_token'];
		
	}, function myError(response) {
		
	});			
	
	$scope.signUp = function() {

		if ($scope.views.frmSignup.$invalid) {
			
			bootstrapNotify.show('danger','Please fill up required information');
			return;
			
		}
		
		$scope.views.invalidToken = false;
		if (parseInt($scope.judge.token) != parseInt($scope.views.token)) {
			$scope.views.invalidToken = true;
			return;
			
		}		
		
		blockUI.show('Please wait...');
		
		$http({
		  method: 'POST',
		  url: 'controllers/signup.php?r=signup',
		  data: $scope.judge
		}).then(function mySucces(response) {
			
			blockUI.hide();
			$timeout(function() { $window.location.href = 'index.php'; },1000);
			
		}, function myError(response) {
			
		});		
		
	};
	
});