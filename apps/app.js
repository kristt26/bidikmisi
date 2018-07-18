var app = angular.module("app", ["ngRoute", "Ctrl"])
    .run(function($rootScope, $http) {
        // $rootScope.DataVerifikasi = {};
        // var UrlVerifikasiData = "api/datas/read/VerifikasiData.php";
        // $http.get(UrlVerifikasiData).then(function(response) {
        //     $rootScope.DataVerifikasi = response.data.Biodata[0];
        //     console.log(response.data.Biodata[0].NPM);
        //     $rootScope.NPM = response.data.Biodata[0].NPM;
        // });
    });

app.config(function($routeProvider) {  
    $routeProvider
        .when("/Main", {
            templateUrl: "apps/view/Main.html",
            controller: "MainController"
        })
        .when("/Kriteria", {
            templateUrl: "apps/view/Kriteria.html",
            controller: "KriteriaController"
        })
        .when("/DaftarKriteria", {
            templateUrl: "apps/view/UserKriteria.html",
            controller: "MahasiswaKriteriaController"
        })
        .when("/Mahasiswa", {
            templateUrl: "apps/view/Mahasiswa.html",
            controller: "MahasiswaController"
        })
        .when("/ListMahasiswa", {
            templateUrl: "apps/view/ListMahasiswa.html",
            controller: "MahasiswaController"
        })
        .otherwise({ redirectTo: '/Main' });
});

app.directive('pwCheck', [function() {
    return {
        require: 'ngModel',
        link: function(scope, elem, attrs, ctrl) {
            var firstPassword = '#' + attrs.pwCheck;
            elem.add(firstPassword).on('keyup', function() {
                scope.$apply(function() {
                    var v = elem.val() === $(firstPassword).val();
                    ctrl.$setValidity('pwmatch', v);
                });
            });
        }
    }
}]);

app.directive("fileInput", function($parse) {
    return {
        link: function($scope, element, attrs) {
            element.on("change", function(event) {
                var files = event.target.files;
                console.log(files[0].name);
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    }
});
app.service('fileUpload', ['$http', function($http) {
    this.uploadFileToUrl = function(file, uploadUrl, name) {
        var fd = new FormData();
        fd.append('file', file);
        fd.append('name', name);
        $http.post(uploadUrl, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Process-Data': false }
            })
            .success(function() {
                console.log("Success");
            })
            .error(function() {
                console.log("Success");
            });
    }
}]);

app.factory("Services", function($http, $rootScope, $location) {
    var service = {};
    service.Authentification = function() {
        $rootScope.Session = {};
        var Urlauth = "api/datas/read/auth.php";
        $http({
                method: "get",
                url: Urlauth,
            })
            .then(function(response) {
                if (response.data.Session == false) {
                    window.location.href = 'index.html';
                } else
                    $rootScope.Session = response.data.Session;
            }, function(error) {
                alert(error.message);
            })
    }
    service.Cek = function() {
        var UrlVerifikasiData = "api/datas/read/VerifikasiData.php";
        $http.get(UrlVerifikasiData).then(function(response) {
            $rootScope.DataVerifikasi = response.data.Biodata[0];
            console.log(response.data.Biodata[0].NPM);
            $rootScope.NPM = response.data.Biodata[0].NPM;
        });
    }
    return service;
});