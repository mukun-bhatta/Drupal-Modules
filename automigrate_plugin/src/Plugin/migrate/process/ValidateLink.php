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
 *   id = "validate_link"
 * )
 */
class ValidateLink extends ProcessPluginBase {

  /**
   * Checks if a link does not return 404.
   *
   * @param string $url
   *   The url to be checked.
   *
   * @return bool
   *   URL is not 404.
   */
  function checkLink($url) {
    $exists = TRUE;
    $file_headers = @get_headers($url);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $exists = FALSE;
    }
    return $exists;
  }

  /**
   * {@inheritdoc}
   */
  function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (is_string($value)) {
      $value = trim($value);
      if ($this->checkLink($value)) {
        return $value;
      }
      else {
        return '';
      }
    }
    else {
      return '';
    }
  }

}
