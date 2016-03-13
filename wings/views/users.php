<div ng-app="wingsUsersApp" ng-controller="WingsUsersController">
  <section ng-view></section>
  </div>

  <script type="text/javascript">
  (function($a){
    $a.module('main.view', ['ngRoute'])
    .config(['$routeProvider',function($routeProvider){
      $routeProvider.when('/main', {
        templateUrl: '<?=wings_assets_dir('wings/')?>/angular/users/main.html'
      });
    }]);
    $a.module('wingsUsersApp', ['ngRoute','main.view'])
    .config(['$routeProvider', function($routeProvider){
      $routeProvider.otherwise('/main');
    }]).controller('WingsUsersController', ['$scope','$http', function($scope, $http){
      $scope.title = "holler";
      $scope.users = [];
      $scope.levels = <?=json_encode($users_access_levels)?>;
      $http({
        url:"<?=link_to('/admin/api/user_list')?>",
        method:"GET"
      }).then(function(response){
        console.log(response);
        $scope.users = response.data.response;
      })
    }]);
  })(angular);
  </script>
  <!-- load -->
