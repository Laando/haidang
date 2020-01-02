
var myapp = angular.module('myapp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

});

myapp.controller('DesigntourController', ['$scope','$http','$location','$locale',function($scope,$http,$location,$locale) {
    $locale.id='vi-vn';
    $scope.localeId = $locale.id;
    var designtour = this;
    $scope.selecttourtype='point';
    $scope.location = $location;
    $scope.edittransport = '';
    $scope.edithotel = '';
    $scope.editroom = '';
    $scope.transporttypes = ['Tất cả','Ô tô' , 'Máy bay' , 'Tàu hỏa'];
    $scope.transporttype = 'Tất cả';
    /////////////////////////////////// star hotel
    $scope.star = '';
    $scope.stars = [];
    var star = {
        title:'Tất cả',
        value: 6
    };
    $scope.stars.push(star);
    var arrstar = [0,1,2,3,4,5];
    $.each(arrstar,function(index,value){
        star = {
            title:value==0?'Nhà nghỉ':value+' sao',
            value:value
        }
        $scope.stars.push(star);
    });
    $scope.star = $scope.stars[0];
    /////////////////////////////////////////////////////
    //////////////////// transport seat
    $scope.transportseat = {};
    $scope.transportseats = [];
    var arrseat = [4,7,16,35,45];
    var transportseat = {
        title:'Tất cả',
        value: ''
    };
    $scope.transportseats.push(transportseat);
    $.each(arrseat,function(index,value){
        transportseat = {
            title:'Xe '+value+' chỗ',
            value:value
        }
        $scope.transportseats.push(transportseat);
    });
    $scope.transportseat = $scope.transportseats[0];
    /////////////////////////////////////////////////////
    designtour.selectedSource = {};
    designtour.selectedDestination = {};
    $http.post('getSourcePoint',{_token:_token}).success(function(data){
        designtour.sourcepoints = data.sourcepoints;
        designtour.destinationpoints = data.destinationpoints;
        designtour.multiroutes = data.multiroutes;
        designtour.selectedSource = data.sourcepoints[0];
        designtour.selectedDestination = data.destinationpoints[0];
        designtour.selectedMulti = data.multiroutes[0];
        designtour.noticeDID(designtour.selectedSource,designtour.selectedDestination,$scope.transporttype);
    });
    this.noticeSID = function(sourcepoint){

    };
    this.noticeDID = function(sourcepoint,destinationpoint,type,transportseat,star){
        $http.post('getEditTransport',{_token:_token,sid : sourcepoint.id , did : destinationpoint.id,type:type,transportseat:transportseat,star:star }).success(function(data){
            if(data.edittransports.length ==0) {
                data.edittransports.push({ title : 'Không có'});
            }
            designtour.edittransports = data.edittransports ;
            designtour.edithotels = data.edithotels;
            $scope.edittransport = data.edittransports[0] ;
            $scope.edithotel = data.edithotels[0];
            $http.post('getEditRoom',{_token:_token,hid : $scope.edithotel.id }).success(function(data){
                designtour.editrooms = data.rooms;
                $scope.editroom = data.rooms[0];
            });
        });
    };
    this.selectbyType = function(type){
        $scope.selecttourtype=type;
    };
}]);
