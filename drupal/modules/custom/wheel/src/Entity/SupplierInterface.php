<?php

namespace Drupal\wheel\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Supplier entities.
 *
 * @ingroup wheel
 */
interface SupplierInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Supplier name.
   *
   * @return string
   *   Name of the Supplier.
   */
  public function getName();

  /**
   * Sets the Supplier name.
   *
   * @param string $name
   *   The Supplier name.
   *
   * @return \Drupal\wheel\Entity\SupplierInterface
   *   The called Supplier entity.
   */
  public function setName($name);

  /**
   * Gets the Supplier creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Supplier.
   */
  public function getCreatedTime();

  /**
   * Sets the Supplier creation timestamp.
   *
   * @param int $timestamp
   *   The Supplier creation timestamp.
   *
   * @return \Drupal\wheel\Entity\SupplierInterface
   *   The called Supplier entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Supplier published status indicator.
   *
   * Unpublished Supplier are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Supplier is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Supplier.
   *
   * @param bool $published
   *   TRUE to set this Supplier to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\wheel\Entity\SupplierInterface
   *   The called Supplier entity.
   */
  public function setPublished($published);

}
