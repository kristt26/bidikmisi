var app = angular.module("app", ["ngRoute", "Ctrl"]);
app.config(function($routeProvider) {  
    $routeProvider
        .when("/Main", {
            templateUrl: "app/View/Main.html",
            controller: "MainController"
        })
        .when("/Kriteria", {
            templateUrl: "apps/view/Kriteria.html",
            controller: "KriteriaController"
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