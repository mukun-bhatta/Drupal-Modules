<?php

namespace Drupal\automigrate_plugin\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Checks if the mail syntax is correct.
 *
 * @MigrateProcessPlugin(
 *   id = "validate_email"
 * )
 */
class ValidateEmail extends ProcessPluginBase {

  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Validate Email
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) { 
      return $value;
    }else{
      return '';
    }
  }

}
