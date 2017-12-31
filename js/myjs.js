// $('.message a').click(function(){
//    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
// });

var app = angular.module('registApp', ['ngMaterial'])
          .config(function($mdThemingProvider) {
            $mdThemingProvider.theme('default')
              .primaryPalette('red') //button
          });

//factory
app.factory('factoryLogin', function($http) {
  var factoryLogin = {};

  factoryLogin.login = function(dataLogin) {
    return $http.post('../php/action.php', dataLogin);
  };

  return factoryLogin;
});

app.factory("factoryAlert", function($mdDialog) {
  var factoryAlert = {};

  factoryAlert.showAlert = function(ev, nama) {
    $mdDialog.show(
      $mdDialog.alert()
        .parent(angular.element(document.body))
        .clickOutsideToClose(true)
        .title('Selamat datang '+nama)
        .textContent('Have a fun day with Ganesha Fun Day :)')
        .ariaLabel('Alert Dialog')
        .ok('SIAAAPPP')
        .theme('default')
    );
  };
  return factoryAlert;
});



app.controller("loginCont", function($scope, factoryLogin, factoryAlert) {
  $scope.alertText = "Bingung? Hubungi panitia";
  $scope.loginClick = function($ev) {
    var regisData = {
      nama : $scope.formLogin.nama,
      noPes : $scope.formLogin.noPes,
      noHP : $scope.formLogin.noHP
    };

    function emptyInput() {
      $scope.formLogin.nama = "";
      $scope.formLogin.noPes = "";
      $scope.formLogin.noHP = "";
    }

    function resetAlertText() {
      $scope.alertText = "Bingung? Hubungi panitia";
    }

    factoryLogin.login(regisData).then(successCallback, errorCallback);
    function successCallback(response) {
      if ((response.data).toLowerCase() == (regisData.nama).toLowerCase()) {
        factoryAlert.showAlert($ev, response.data);
        resetAlertText();
        emptyInput();
      } else if (response.data == "INVALID") {
        $scope.alertText = "Data registran tidak ditemukan";
      } else if (response.data == "ALREADY") {
        $scope.alertText = "Anda sudah pernah melakukan registrasi";
      } else if (response.data == "RESET") {
        $scope.alertText = "Database telah direset";
        emptyInput();
      } else if ((regisData.nama == "") || (regisData.noPes == "")) {
        resetAlertText();
      }
    };
    function errorCallback(error) {
      log(error, 'login failed!!');
    };
  };
});
