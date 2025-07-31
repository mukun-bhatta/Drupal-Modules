<?php

namespace Drupal\automigrate_plugin\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Custom process plugin for status of migration
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "custom_status",
 *   handle_multiples = TRUE
 * )
 */
class CustomStatus extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $keys = array('id','firstname','lastname','email','image_url');

    //Check if Unique Id, firstname, Lastname, email and image URL is not Null
    if(in_array("", $value)){
      return 0;
    }

    // Validate Email
    if (!filter_var($value[3], FILTER_VALIDATE_EMAIL)) { 
      return 0;
    }

    // Validate brandfolder URL link
    $url = trim($value['4']);
    if ($this->checkLink($url) == FALSE) {
      return 0;
    }
    return 1;
  }

  function checkLink($url) {
    $exists = TRUE;
    $file_headers = @get_headers($url);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $exists = FALSE;
    }
    return $exists;
  }
}
