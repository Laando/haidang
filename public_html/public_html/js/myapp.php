var _token = <?php csrf_token()?>;
var myapp = angular.module('myapp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

});
myapp.controller('desgintourController', function($scope,$http) {
    var req = {
        method: 'POST',
        url: 'getSourcePoint',
        data: {}
    }
    $http(req).then(function successCallback(response){
        $scope.designtour = response.records;
    }, function errorCallback(response){

    });
});
function desgintourController($scope,$http) {
    var req = {
        method: 'POST',
        url: 'trang-chu',
        data: { test: 'test' }
    }

    $http(req).then(function successCallback(response){
        alert(response);
    }, function errorCallback(response){

    });
}