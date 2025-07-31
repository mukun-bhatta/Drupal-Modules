<?php

namespace Drupal\automigrate_plugin\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Checks if a link is not broken.
 *
 * @MigrateProcessPlugin(
 *   id = "validate_phone"
 * )
 */
class ValidatePhone extends ProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if ($value != NULL) {
      $filtered_phone_number = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
      // Remove "-" from number
      $phone_to_check = str_replace("-", "", $filtered_phone_number);
      // Remove "+" from number
      $phone_to_check = str_replace("+", "", $phone_to_check);
      $phone_to_check = str_replace(" ", "", $phone_to_check);
      if(preg_match('/^[0-9]{11}+$/', $phone_to_check) && is_numeric ($phone_to_check))  {
        return $value;
      }else{
        return '';
      }
    }
    else {
      return '';
    }
  }

}
