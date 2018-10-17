<?php

require_once 'currentpaymentversion.civix.php';
use CRM_Currentpaymentversion_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function currentpaymentversion_civicrm_config(&$config) {
  _currentpaymentversion_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function currentpaymentversion_civicrm_xmlMenu(&$files) {
  _currentpaymentversion_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function currentpaymentversion_civicrm_install() {
  _currentpaymentversion_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function currentpaymentversion_civicrm_postInstall() {
  _currentpaymentversion_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function currentpaymentversion_civicrm_uninstall() {
  _currentpaymentversion_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function currentpaymentversion_civicrm_enable() {
  _currentpaymentversion_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function currentpaymentversion_civicrm_disable() {
  _currentpaymentversion_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_alterSettingsMetaData().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsMetaData
 *
 */
function currentpaymentversion_civicrm_alterSettingsMetaData(&$settingsMetadata, $domainID, $profile) {
  $settingsMetadata['show_latest_payments'] = [
    'group_name' => 'Contribute Preferences',
    'group' => 'contribute',
    'name' => 'show_latest_payments',
    'type' => 'Boolean',
    'quick_form_type' => 'YesNo',
    'default' => '1',
    'add' => '5.6',
    'title' => 'Do you want to show latest payment?',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => '',
    'help_text' => 'Currently CiviCRM show all the historical payments of a contribution on contact summary and other backoffice edit and view pages. With this extension you can choose to either show only the latest payment(s) or historical payments based on a special CiviContribute setting.',
  ];
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 */
function currentpaymentversion_civicrm_preProcess($formName, &$form) {
  if ($formName == 'CRM_Admin_Form_Preferences_Contribute') {
    $settings = $form->getVar('_settings');
    $contributeSettings = array();
    foreach ($settings as $key => $setting) {
      $contributeSettings[$key] = $setting;
      if ($key == 'always_post_to_accounts_receivable') {
        $contributeSettings['show_latest_payments'] = CRM_Core_BAO_Setting::CONTRIBUTE_PREFERENCES_NAME;
      }
    }
    $form->setVar('_settings', $contributeSettings);
  }
}


function currentpaymentversion_civicrm_buildForm($formName, &$form) {
  if (Civi::settings()->get('contribution_invoice_settings')['show_latest_payments']) {
    if ((in_array($formName, ['CRM_Contribute_Form_AdditionalPayment', 'CRM_Contribute_Form_Contribution']) && ($id = $form->getVar('_id'))) ||
      ($formName == 'CRM_Contribute_Form_ContributionView' && ($id = $form->get('id')))
    ) {
      $payments = array_reverse(CRM_Contribute_BAO_Contribution::getPaymentInfo($id, 'contribution', TRUE)['transaction']);
      $total = civicrm_api3('Contribution', 'getvalue', ['id' => $id, 'return' => 'total_amount']);
      foreach ($payments as $key => $payment) {
        if ($payment['status'] == 'Refunded') {
          $total -= $payment['total_amount'];
          continue;
        }
        $total = ($payment['total_amount'] > 0) ? $total - $payment['total_amount'] : $total + $payment['total_amount'];
        if ($total < 0) {
          unset($payments[$key]);
        }
      }
      $payments = array_reverse($payments);
      $form->assign('payments', $payments);
    }
  }
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function currentpaymentversion_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _currentpaymentversion_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function currentpaymentversion_civicrm_managed(&$entities) {
  _currentpaymentversion_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function currentpaymentversion_civicrm_caseTypes(&$caseTypes) {
  _currentpaymentversion_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function currentpaymentversion_civicrm_angularModules(&$angularModules) {
  _currentpaymentversion_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function currentpaymentversion_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _currentpaymentversion_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function currentpaymentversion_civicrm_entityTypes(&$entityTypes) {
  _currentpaymentversion_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function currentpaymentversion_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function currentpaymentversion_civicrm_navigationMenu(&$menu) {
  _currentpaymentversion_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _currentpaymentversion_civix_navigationMenu($menu);
} // */
