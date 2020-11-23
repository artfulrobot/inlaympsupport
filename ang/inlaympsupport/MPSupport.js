(function(angular, $, _) {

  angular.module('inlaympsupport').config(function($routeProvider) {
      $routeProvider.when('/inlays/mpsupport/:id', {
        controller: 'InlaympsupportMPSupport',
        controllerAs: '$ctrl',
        templateUrl: '~/inlaympsupport/MPSupport.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".
        resolve: {
          various: function($route, crmApi4, $route) {
            const params = {
              inlayTypes: ['InlayType', 'get', {}, 'class'],
              issues: ['OptionValue', 'get', {
                select: ["value", "label"],
                where: [["option_group_id:name", "=", "issue_20201121080319"]]
              }]
            };
            if ($route.current.params.id > 0) {
              params.inlay = ['Inlay', 'get', {where: [["id", "=", $route.current.params.id]]}, 0];
            }
            return crmApi4(params);
          },
        }
      });
    }
  );

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  angular.module('inlaympsupport').controller('InlaympsupportMPSupport', function($scope, crmApi4, crmStatus, crmUiHelp, various) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('inlaympsupport');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/inlaympsupport/MPSupport'}); // See: templates/CRM/inlaympsupport/MPSupport.hlp
    // Local variable for this controller (needed when inside a callback fn where `this` is not available).
    var ctrl = this;

    $scope.inlayType = various.inlayTypes['Civi\\Inlay\\MPSupport'];
    console.log({various}, $scope.inlayType);
    if (various.inlay) {
      $scope.inlay = various.inlay;
    }
    else {
      $scope.inlay = {
        'class' : 'Civi\\Inlay\\MPSupport',
        name: 'New ' + $scope.inlayType.name,
        public_id: 'new',
        id: 0,
        config: JSON.parse(JSON.stringify($scope.inlayType.defaultConfig)),
      };
    }
    const inlay = $scope.inlay;

    $scope.issues = various.issues;

    $scope.save = function() {
      return crmStatus(
        {start: ts('Saving...'), success: ts('Saved')},
        crmApi4('Inlay', 'save', { records: [inlay] })
      ).then(r => {
        console.log("save result", r);
        window.location = CRM.url('civicrm/a?#inlays');
      });
    };

  });

})(angular, CRM.$, CRM._);
