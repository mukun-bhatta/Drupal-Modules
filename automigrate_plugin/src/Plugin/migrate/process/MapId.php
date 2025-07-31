<?php

namespace Drupal\automigrate_plugin\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;


/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "map_id"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_text:
 *   plugin: map_id
 *   source: text
 * @endcode
 *
 */
class MapId extends ProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $connection = \Drupal::database();
    $query = $connection->select('node__field_unique_id', 'n');
    $query->fields('n', array('entity_id'));
    $query->condition('n.field_unique_id_value', $value , '=');
    $result = $query->execute()->fetchAll();
    foreach ($result as $key => $val) {
      $nid = $val->entity_id;
    } 
    if ($nid != NULL) {
      return $nid;
    } else {
      return '';
    }
  }
}