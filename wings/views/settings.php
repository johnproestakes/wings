<div ng-app="wingsSettingsApp" ng-controller="WingsSettingsController">
  <div class="ui fluid two item menu">
  <a href="#/database" class="item active">
    Database
  </a>
  <a href="#/other" class="item">
    Other
  </a>
</div>
  <section ng-view></section>
  </div>

  <script type="text/javascript">
  (function($a){
    $a.module('main.view', ['ngRoute'])
    .config(['$routeProvider',function($routeProvider){
      $routeProvider.when('/main', {
        templateUrl: '<?=wings_assets_dir('wings/')?>/angular/settings/main.html'
      });
    }]);
    $a.module('wingsSettingsApp', ['ngRoute',
    'main.view'
  ])
    .config(['$routeProvider', function($routeProvider){
      $routeProvider.otherwise('/main');
    }]).controller('WingsSettingsController',
    ['$scope','$http', function($scope, $http){
      $scope.title = "holler";
      $scope.users = [];
      // $http({
      //   url:"<?=link_to('/admin/api/user_list')?>",
      //   method:"GET"
      // }).then(function(response){
      //   console.log(response);
      //   $scope.users = response.data.response;
      // })
    }]);
  })(angular);
  </script>
  <!-- load -->
