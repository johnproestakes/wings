<!DOCTYPE html>
<html ng-app="wingsInstallapp">
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>Install Wings</title>
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/css/style.css" />
  <style type="text/css">
      body {
        background-color: #fafafa;
        margin-top: 2em;
        min-height: 100%;
      }
      body > section {
        height: 100%;
      }
      .ui.form {max-width: 600px; margin:0 auto;}
      .field p {padding: .5em 0; font-style: italic; color: #333;}

    </style>
    <script src="<?=wings_assets_dir('wings/')?>/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
  <script src="<?=wings_assets_dir('wings/')?>/bower_components/angular/angular.min.js" type="text/javascript"></script>
  <script src="<?=wings_assets_dir('wings/')?>/bower_components/angular-route/angular-route.min.js" type="text/javascript"></script>
</head>
<body ng-controller="InstallController">
  <section ng-view style="margin-top: 20px;"></section>
<script>

(function($a){
  $a.module('install.main',['ngRoute'])
  .config(['$routeProvider', function($routeProvider){
    $routeProvider.when('/main', {templateUrl:"<?=wings_assets_dir('wings/')?>/angular/steps/main.html"});
  }]);
  $a.module('install.one',['ngRoute'])
  .config(['$routeProvider', function($routeProvider){
    $routeProvider.when('/database', {templateUrl:"<?=wings_assets_dir('wings/')?>/angular/steps/one.html"});
  }]);
  $a.module('install.two',['ngRoute'])
  .config(['$routeProvider', function($routeProvider){
    $routeProvider.when('/admin', {templateUrl:"<?=wings_assets_dir('wings/')?>/angular/steps/two.html"});
  }]);
  $a.module('wingsInstallapp',['ngRoute', 'install.main', 'install.one', 'install.two'])
  .directive('dbFormValidation', function(){
    return {
      restrict: 'A',
      link: function(scope, el, attr){
        $(el)
          .form({
            inline: true,
            on:'blur',
            fields: {
              db_hostname:{
                identifier: 'db_hostname',
                rules:[{
                  type: 'empty',
                  prompt : 'Specify a value'
                }]
              },
              db_name:{
                identifier: 'db_name',
                rules:[{
                  type: 'empty',
                  prompt : 'Specify a value'
                }]
              },
              db_username:{
                rules:[{
                  type: 'empty',
                  prompt : 'Specify a value'
                }]
              },
              db_password:{
                rules:[{
                  type: 'empty',
                  prompt : 'Specify a value'
                }]
              }
            }
          })
        ;
        window.debounce = null;
        $(el).submit(function(evt){
          clearTimeout(window.debounce);
          window.debounce = setTimeout(function(){

            if($(el).form('is valid')){
              scope.proceedTo('admin');

            } else {
              //does not pass validation rules
            }
          },300);

          evt.preventDefault(); return false;});

      }
    }
  })
  .directive('adminFormValidation', function(){
    return {
      restrict: 'A',
      link: function(scope, el, attr){
        $(el)
          .form({
            inline: true,
            on:'blur',
            fields: {
              app_name:{
                identifier: 'app_name',
                rules:[{
                  type: 'empty',
                  prompt : 'Specify an application name'
                },{
                  type: 'minLength[5]',
                  prompt : 'Application name should be longer than 5 characters'
                }]
              },
              admin_email:{
                identifier: 'admin_email',
                rules:[{
                  type: 'email',
                  prompt : 'Specify an email address'
                }]
              },
              admin_password:{
                rules:[{
                  type: 'empty',
                  prompt : 'Specify a password'
                },{
                  type: 'minLength[8]',
                  prompt : 'The password should be at least 8 characters long.'
                }]
              },
              admin_confirm:{
                rules:[{
                  type: 'match[admin_password]',
                  prompt : 'The password could not be confirmed. Try again.'
                }]
              }
            }
          })
        ;
        window.debounce = null;
        $(el).submit(function(evt){
          clearTimeout(window.debounce);
          window.debounce = setTimeout(function(){

            if($(el).form('is valid')){
              scope.proceedTo('end');
            } else {
              //does not pass validation rules
            }
          },300);

          evt.preventDefault();
          return false;
        });

      }
    }
  })
  .config(['$routeProvider', function($routeProvider){
    $routeProvider.otherwise({redirectTo:'/main'});
  }]).controller('InstallController', ['$scope', '$http',function($scope,$http){
    $scope.data = {
      "tbl_prefix": "wings_",
      "db_hostname":"localhost",
      "db_name":"wings",
      "db_password":"root",
      "db_username":"root"

    };
    $scope.proceedTo = function(name){
      switch(name){
        case "admin":
        //
        $http({
          method:'POST',
          url:'<?=link_to('/admin/api/db_connection')?>',
          data: $scope.data
        })
          .then(function(response){
            console.log(response);
          if(response.data.response=="good"){
            location.href="#/admin";
          } else {
            alert('sorry, the data you provided is incorrect. please check it and try again.');
          }
        }, function(response){
          alert('nope');
        });

        if($scope.data.tbl_prefix == "wings_"){
          //location.href="#admin";
        }


        break;
        case 'end':

        $http({
          method:'POST',
          url:'<?=link_to('/admin/api/install_wings')?>',
          data: $scope.data
        })

          .then(function(response){
            console.log($scope.data)
            console.log(response);
          if(response.data.response=="good"){
            location.href="<?=link_to('/admin')?>";
          } else {
            alert('sorry, the data you provided is incorrect. please check it and try again.');
          }
        }, function(response){
          alert('nope');
        });
        break;
        default:

        break;


      }

    }
    $scope.isCurrentPage = function(id){
      if(location.hash.substr(2,location.hash.length)==id){
        return true;
      } else {
        return false;
      }
    };
  }]);
})(angular);

  </script>



  <script src="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.js" type="text/javascript"></script>

  </body>
  </html>
