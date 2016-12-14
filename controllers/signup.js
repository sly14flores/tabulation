var app = angular.module('signup', ['block-ui','bootstrap-notify','bootstrap-modal']);

app.controller('signupCtrl',function($http,$scope) {
	
	$scope.views = {};
	
	$scope.signUp = function() {
		
		$http({
		  method: 'POST',
		  url: 'controllers/signup.php?r=signup'
		}).then(function mySucces(response) {
			
			
			
		}, function myError(response) {
			
		});		
		
	};
	
});