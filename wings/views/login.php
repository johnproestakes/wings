<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title><?=tpl_var('pageTitle', $data)?></title>
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/css/style.css" />

  <style type="text/css">
      body {
        background-color: #fafafa;
      }
      #ng-app, #ng-view, body {height: 100%;}
      #ng-view > .container,
      #ng-view .grid {height:100%;}
      #ng-view .column {max-width:400px;}
      #ng-view .column .container {max-width: 400px;}



    </style>
    <?php if(isset($scripts)): ?>
      <?php foreach($scripts as $script): ?>
        <script src="<?=$script?>" type="text/javascript"></script>
      <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>
<div id="ng-app" ng-app="wingsLoginApp" ng-controller="WingsLoginController" style="height:100%;">

  <section id="ng-view" ng-view style="100%"></section>
  </div>

<script type="text/javascript">
  (function($a){
    $a.module('form.view', ['ngRoute'])
    .config(['$routeProvider', function($routeProvider){
      $routeProvider.when('/form', {
        templateUrl:'<?=(wings_assets_dir('wings/') . "/angular/login/form.html")?>'
      });
    }]);
    $a.module('wingsLoginApp', ['ngRoute', 'form.view'])
    .config(['$routeProvider', function($routeProvider){
      $routeProvider.otherwise('/form');
    }])
    .controller('WingsLoginController',['$scope', '$http', function($scope, $http){
      $scope.title = "new angular effort";
      $scope.data = {};
      $scope.userLogin = function(){
        $http({
          method: "POST",
          data: $scope.data,
          url: '<?=link_to('/admin/api/user_login')?>'
        }).then(function(response){
          console.log(response);
          if(response.data.access_granted){
            location.href='<?=link_to('/admin')?>';
          } else {
            alert(response.data.message);
          }
        }, function(response,a){console.log(response,a);});

      }
    }]);

  })(angular);
</script>
</div>
</div>

  <script src="<?=wings_assets_dir('wings/')?>/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
  <script src="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.js" type="text/javascript"></script>

  </body>
  </html>
