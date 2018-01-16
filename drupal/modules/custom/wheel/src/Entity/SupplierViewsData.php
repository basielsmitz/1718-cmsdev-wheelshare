<?php

namespace Drupal\wheel\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Supplier entities.
 */
class SupplierViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
