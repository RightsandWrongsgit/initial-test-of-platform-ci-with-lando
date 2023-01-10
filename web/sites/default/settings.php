<?php
/**
 * @file
 * Platform.sh example settings.php file for Drupal 9.
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

// The hash_salt should be a unique random value for each application.
// If left unset, the settings.platformsh.php file will attempt to provide one.
// You can also provide a specific value here if you prefer and it will be used
// instead. In most cases it's best to leave this blank on Platform.sh. You
// can configure a separate hash_salt in your settings.local.php file for
// local development.
// $settings['hash_salt'] = 'change_me';

// Set up a config sync directory.
//
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Initialize config-split options all to False.
$config['config_split.config_split.local']['status'] = FALSE;
$config['config_split.config_split.develop']['status'] = FALSE;
$config['config_split.config_split.staged']['status'] = FALSE;
$config['config_split.config_split.main']['status'] = FALSE;

// Detect Lando set environment variable ($env) to local
if (isset($_ENV['LANDO_INFO'])) { define('LANDO_INFO', json_decode($_ENV['LANDO_INFO'], TRUE));
}
if (defined('LANDO_INFO')) {
$env = 'local';
}

// Detect the environment ($env) from the Platform_Branch
if (file_exists($app_root . '/' . $site_path . '/settings.' . getenv('PLATFORM_BRANCH') . '.php')) {
  include $app_root . '/' . $site_path . '/settings.' . getenv('PLATFORM_BRANCH') . '.php';
}

// Enable the config-split definition for the environment
Switch ($env) {
  case 'develop':
// Environment indicator case 'develop':
  $config['environment_indicator.indicator']['bg_color'] = '#4caf50';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'develop';
// Config Split case 'develop':
  $config['config_split.config_split.develop']['status'] = TRUE;
  case 'staged':
// Environment indicator case 'staged':
  $config['environment_indicator.indicator']['bg_color'] = '#fff176';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'staged';
// Config Split case ‘staged’:
  $config['config_split.config_split.staged']['status'] = TRUE;
  case 'main':
// Environment indicator case 'main':
  $config['environment_indicator.indicator']['bg_color'] = '#ef5350';
  $config['environment_indicator.indicator']['fg_color'] = '#000000';
  $config['environment_indicator.indicator']['name'] = 'main';
// Config Split case ‘main’:
  $config['config_split.config_split.main']['status'] = TRUE;
  case 'local':
// Environment indicator case 'local', white text on red:
  $config['environment_indicator.indicator']['bg_color'] = '#006600';
  $config['environment_indicator.indicator']['fg_color'] = '#ffffff';
  $config['environment_indicator.indicator']['name'] = 'local';
// Config Split case ‘local’:
  $config['config_split.config_split.local']['status'] = TRUE;
// Environment indicator default, dark text on brilliant red:
  $config['environment_indicator.indicator']['bg_color'] = '#ff531a';
  $config['environment_indicator.indicator']['fg_color'] = '#902400';
  $config['environment_indicator.indicator']['name'] = 'staged';
// Config Split// Config Split default:
  $config['config_split.config_split.staged']['status'] = TRUE;
}

// Automatic Platform.sh settings.
if (file_exists($app_root . '/' . $site_path . '/settings.platformsh.php')) {
  include $app_root . '/' . $site_path . '/settings.platformsh.php';
}

// Local settings. These come last so that they can override anything.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
