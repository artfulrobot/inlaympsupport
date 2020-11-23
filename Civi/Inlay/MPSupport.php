<?php
namespace Civi\Inlay;

use Civi\Inlay\ApiRequest;
use CRM_Inlaympsupport_ExtensionUtil as E;

class MPSupport extends Type {

  public static $typeName = 'MP support';

  public static $defaultConfig = [
    'issueOptionValue' => NULL,
    'publicTitle' => '',
    'introHTML' => '',
  ];

  /**
   * Note: because of the way CRM.url works, you MUST put a ? before the #
   *
   * @var string
   */
  public static $editURLTemplate = 'civicrm/a?#/inlays/mpsupport/{id}';

  /**
   * Sets the config ensuring it's valid.
   *
   * This implementation simply ensures all the defaults exist, and that no
   * other keys exist, but you could do other things, especially if you need to
   * coerce some old config into a new style.
   *
   * @param array $config
   *
   * @return \Civi\Inlay\Type (this)
   */
  public function setConfig(array $config) {
    $this->config = array_intersect_key($config + static::$defaultConfig, static::$defaultConfig);
  }

  /**
   * Generates data to be served with the Javascript application code bundle.
   *
   * @return array
   */
  public function getInitData() {
    $data = [
      // Name of global Javascript function used to boot this app.
      'init'             => 'inlayMPSupportInit',
      'partiesSvg' => file_get_contents(E::path('src/parties-plain.svg')),
    ];
    foreach (['publicTitle', 'introHTML'
    ] as $_) {
      $data[$_] = $this->config[$_] ?? '';
    }

    // Fetch the data, using a custom API set up in Data Processor since this
    // also provides a handy search/report in CiviCRM.
    $support = civicrm_api3('Contact', 'getmpsupport', [
      'options' => ['limit' => 0],
    ])['values'] ?? [];

    // Simplify the data.
    $struct = [];
    foreach ($support as $_) {
      $partyName = $_['mps_info_party'];
      if (!isset($struct[$partyName])) {
        $struct[$partyName] = [
          'name' => $_['mps_info_party'],
          'mps' => [],
        ];
      }
      $struct[$partyName]['mps'][] = [
        'c' => $_['mps_info_constituency'],
        'n' => $_['mp_name'],
        'h' => (int) ($_['shown_support_for_highlight_at_top_of_list'] ?? 0),
      ];
    }

    // Ditch the party name index, makes it hard to iterate in js.
    $data['mps'] = array_values($struct);
    return $data;
  }

  /**
   * Process a request (not required)
   *
   * Request data is just key, value pairs from the form data. If it does not
   * have 'token' field then a token is generated and returned. Otherwise the
   * token is checked and processing continues.
   *
   * @param \Civi\Inlay\Request $request
   * @return array
   *
   * @throws \Civi\Inlay\ApiException;
   */
  public function processRequest(ApiRequest $request) {

    return [ 'success' => 1 ];
  }

  /**
   * Returns a URL to a page that lets an admin user configure this Inlay.
   *
   * @return string URL
   */
  public function getAdminURL() {

  }

  /**
   * Get the Javascript app script.
   *
   * This will be bundled with getInitData() and some other helpers into a file
   * that will be sourced by the client website.
   *
   * @return string Content of a Javascript file.
   */
  public function getExternalScript() {
    return file_get_contents(E::path('dist/inlay-mpsupport.js'));
  }


}
