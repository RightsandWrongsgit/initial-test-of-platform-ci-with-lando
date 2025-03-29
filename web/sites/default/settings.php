<?php
/**
 * @file
 * Platform.sh example settings.php file for Drupal 10.
 */

// Default Drupal settings.
//
// These are already explained with detailed comments in Drupal's
// default.settings.php file.
//
// See https://api.drupal.org/api/drupal/sites!default!default.settings.php/9
$databases = [];
$config_directories = [];
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

// THE FOLLOWING ITEMS UNTIL NOTED DIFFERENTLY ARE FROM DDEVs settings.php but NOT UPDATED HERE
// The hash_salt should be a unique random value for each application.
// If left unset, the settings.platformsh.php file will attempt to provide one.
// You can also provide a specific value here if you prefer and it will be used
// instead. In most cases it's best to leave this blank on Platform.sh. You
// can configure a separate hash_salt in your settings.local.php file for
// local development.
// $settings['hash_salt'] = 'change_me';

/**
 * The default number of entities to update in a batch process.
 *
 * This is used by update and post-update functions that need to go through and
 * change all the entities on a site, so it is useful to increase this number
 * if your hosting configuration (i.e. RAM allocation, CPU speed) allows for a
 * larger number of entities to be processed in a single batch run.
 */
# $settings['entity_update_batch_size'] = 50;

/**
 * Entity update backup.
 *
 * This is used to inform the entity storage handler that the backup tables as
 * well as the original entity type and field storage definitions should be
 * retained after a successful entity update process.
 */
# # $settings['entity_update_backup'] = TRUE;

/**
 * State caching.
 *
 * State caching uses the cache collector pattern to cache all requested keys
 * from the state API in a single cache entry, which can greatly reduce the
 * amount of database queries. However, some sites may use state with a
 * lot of dynamic keys which could result in a very large cache.
 */
# $settings['state_cache'] = TRUE;

/**
 * Node migration type.
 *
 * This is used to force the migration system to use the classic node migrations
 * instead of the default complete node migrations. The migration system will
 * use the classic node migration only if there are existing migrate_map tables
 * for the classic node migrations and they contain data. These tables may not
 * exist if you are developing custom migrations and do not want to use the
 * complete node migrations. Set this to TRUE to force the use of the classic
 * node migrations.
 */
# $settings['migrate_node_migrate_type_classic'] = FALSE;
// END OF SUPPRESSED DDEV OFFERED settings.php items NOT include in active.

// Set up a config sync directory.
//
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Initialize config-split options all to False.
$config['config_split.config_split.local']['status'] = FALSE;
$config['config_split.config_split.develop']['status'] = FALSE;
$config['config_split.config_split.staged']['status'] = FALSE;
$config['config_split.config_split.main']['status'] = FALSE;

// Detect the environment ($env) from the Platform_Branch
// if (isset($_ENV['PLATFORM_ENVIRONMENT'])) { define('PLATFORM_BRANCH', json_decode($_ENV['PLATFORM_BRANCH'], TRUE));
// }
// if (defined('PLATFORM_BRANCH')) {
  $env = getenv('PLATFORM_ENVIRONMENT'); 
// }

// Enable the config-split definition for the environment
switch ($env) {
  case 'develop':
// Environment indicator case 'develop':
  $config['environment_indicator.indicator']['bg_color'] = '#4caf50';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'develop';
// Config Split case 'develop':
  $config['config_split.config_split.develop']['status'] = TRUE;
  $config['stage_file_proxy.settings']['origin'] = '';
  break;
  case 'staged':
// Environment indicator case 'staged':
  $config['environment_indicator.indicator']['bg_color'] = '#fff176';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'staged';
// Config Split case ‘staged’:
  $config['config_split.config_split.staged']['status'] = TRUE;
  $config['stage_file_proxy.settings']['origin'] = '';
  break;
  case 'main':
// Environment indicator case 'main':
  $config['environment_indicator.indicator']['bg_color'] = '#ef5350';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'main';
// Config Split case ‘main’:
  $config['config_split.config_split.main']['status'] = TRUE;
  $config['stage_file_proxy.settings']['origin'] = '';
  break;
  default:
//  case 'local':
// Environment indicator case 'local', white text on red:
  $config['environment_indicator.indicator']['bg_color'] = '#006600';
  $config['environment_indicator.indicator']['fg_color'] = '#ffffff';
  $config['environment_indicator.indicator']['name'] = 'local';
// Config Split case ‘local’:
  $config['config_split.config_split.local']['status'] = TRUE;
  $config['stage_file_proxy.settings']['origin'] = `platform url -e main --primary --pipe`;
}

// Automatically generated include for settings managed by ddev.
if (getenv('IS_DDEV_PROJECT') == 'true' && file_exists(__DIR__ . '/settings.ddev.php')) {
  include __DIR__ . '/settings.ddev.php';
}

// Automatic Platform.sh settings.
if (file_exists($app_root . '/' . $site_path . '/settings.platformsh.php')) {
  include $app_root . '/' . $site_path . '/settings.platformsh.php';
}

// Local settings. These come last so that they can override anything.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
