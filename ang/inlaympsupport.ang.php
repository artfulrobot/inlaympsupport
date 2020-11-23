<?php
// This file declares an Angular module which can be autoloaded
// in CiviCRM. See also:
// \https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules/n
return [
  'js' => [
    'ang/inlaympsupport.js',
    'ang/inlaympsupport/*.js',
    'ang/inlaympsupport/*/*.js',
  ],
  'css' => [
    'ang/inlaympsupport.css',
  ],
  'partials' => [
    'ang/inlaympsupport',
  ],
  'requires' => [
    'crmUi',
    'crmUtil',
    'ngRoute',
  ],
  'settings' => [],
];
