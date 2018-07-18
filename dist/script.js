angular.module('myModule', ['datatables'])
.controller("MyCtrl", function($scope, $http, DTOptionsBuilder)
{
   // DataTables configurable options
    $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withDisplayLength(5)
        .withOption('bLengthChange', false);
        
    $scope.users = {};
    
    
    $http.get('')
      .success(function(data, status){
        // Assign http data into scope variable here
        
        $scope.users = [
          {
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          },{
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          },{
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          },{
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          },{
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          },{
            'fullname': 'Alauddin',
            'email':'testing@domain.com'
          },
          {
            'fullname': 'TheWonder',
            'email':'wonder@domain.com'
          }
        ];
      })
      .error(function(data, status){
        
      });
    
   

    
});