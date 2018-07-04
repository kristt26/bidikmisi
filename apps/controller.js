angular.module("Ctrl", [])
    .controller("RegisterController", function($scope, $http) {
        $scope.username = '';
        $scope.email = '';
        $scope.passw1 = '';
        $scope.passw2 = '';
        $scope.DatasUser = {};

        $scope.edit = true;
        $scope.error = false;
        $scope.incomplete = true;
        $scope.hideform = true;



        //$scope.$watch('passw1', function() { $scope.test(); });
        $scope.$watch('passw2', function() { $scope.test(); });
        $scope.$watch('username', function() { $scope.test(); });
        $scope.$watch('email', function() { $scope.test(); });

        $scope.test = function() {
            if ($scope.passw1 !== $scope.passw2) {
                $scope.error = true;
            } else {
                $scope.error = false;
            }
            $scope.incomplete = false;
            if ($scope.edit && (!$scope.username.length ||
                    !$scope.email.length ||
                    !$scope.passw1.length || !$scope.passw2.length)) {
                $scope.incomplete = true;
            }
        };

        $scope.Signup = function() {
            $scope.DatasUser.username = $scope.username;
            $scope.DatasUser.email = $scope.email;
            $scope.DatasUser.password = $scope.passw1;
            var Data = $scope.DatasUser;
            var UrlSignup = "../../api/datas/create/Signup.php";
            $http({
                    method: "POST",
                    url: UrlSignup,
                    data: Data
                })
                .then(function(response) {
                    if (response.data.message == "Pesan telah terkirim.") {
                        var mess = response.data.message + " ke Email Anda, Silahkan buka email anda untuk melakukan Activation!";
                        alert(mess);
                        window.location.href = '../../index.html';
                    }

                }, function(error) {

                })
        };
    })
    .controller("KriteriaController", function($scope, $http) {
        $scope.DatasKriteria = [];
        $scope.Init = function() {
            var UrlGetKriteria = "api/datas/read/ReadKriteria.php";
            $http({
                    method: "GET",
                    url: UrlGetKriteria
                })
                .then(function(response) {
                    if (response.data.message == "Kriteria found")
                        $scope.DatasKriteria = response.data.Kriteria;
                    else
                        alert(response.data.message);

                }, function(error) {
                    alert(error);
                })
        }

    })
    .controller("LoginController", function($scope, $http){
        $scope.DatasLogin;
        $scope.Login=function(){
            var UrlLogin= "api/datas/read/UserLogin.php";
            var Data = $scope.DatasLogin;
            $http({
                method: "POST",
                url: UrlLogin,
                data: Data
            })
            .then(function(response){
                if(response.data){
                    
                }

            }, function(error){
                alert(error);
            })
        }

    })