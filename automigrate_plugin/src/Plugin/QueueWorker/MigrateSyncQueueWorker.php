<?php

namespace Drupal\automigrate_plugin\Plugin\QueueWorker;

use Drupal;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Queue\SuspendQueueException;
use Drupal\migrate\MigrateMessage;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Plugin\MigrationPluginManagerInterface;
use Drupal\migrate_tools\MigrateExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Database\Query\Condition;

/**
 * Queueworker to unpublish all the data who are removed from the CSV.
 *
 * @QueueWorker(
 *   id = "migrations_sync",
 *   title = @Translation("Migrations sync"),
 *   cron = {
 *     "time" = 30,
 *   },
 * )
 */
class MigrateSyncQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
   public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
     return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
   }

  public function processItem($data) {
    //created a connected and checked which nodes have been removed from CSV and set them as unpublish
    $connection = \Drupal::database();
    $query = $connection->select('migrate_map_auto_migration', 'm');
    $query->join('node_field_data', 'n', 'n.nid = m.destid1');
    $query->fields('m', array('destid1'));
    $query->condition('m.source_row_status', 1 , '=');
    $query->condition('n.status', 1 , '=');
    $result = $query->execute()->fetchAll();
    foreach ($result as $key => $val) {
      $node = Node::load($val->destid1);
      $node->setPublished(FALSE)->save();
    }
  \Drupal::logger('migrate_sync')->notice("Migration Sync logger");

  }

}
