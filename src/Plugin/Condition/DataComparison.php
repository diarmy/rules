<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\DataComparison.
 */

namespace Drupal\rules\Plugin\Condition;

use Drupal\Core\TypedData\TypedDataManager;
use Drupal\rules\Context\ContextDefinition;
use Drupal\rules\Engine\RulesConditionBase;

/**
 * Provides a 'Data comparison' condition.
 *
 * @Condition(
 *   id = "rules_data_comparison",
 *   label = @Translation("Compare data")
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 * @todo: Add group information from Drupal 7.
 * @todo: Add public function getContextDefinitions().
 */
class DataComparison extends RulesConditionBase {

  /**
   * {@inheritdoc}
   */
  public static function contextDefinitions(TypedDataManager $typed_data_manager) {
    $contexts['data'] = ContextDefinition::create($typed_data_manager, 'any')
      ->setLabel(t('Data'));

    $contexts['op'] = ContextDefinition::create($typed_data_manager, 'string')
      ->setLabel(t('Operator'));

    $contexts['value'] = ContextDefinition::create($typed_data_manager, 'any')
      ->setLabel(t('Value'));

    return $contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Compare data');
  }

  /**
   * {@inheritdoc}
   */
  protected function isEqual($data, $value) {
    // In case both values evaluate to FALSE, further differentiate between
    // NULL values and values evaluating to FALSE.
    if (!$data && !$value) {
      return (isset($data) && isset($value)) || (!isset($data) && !isset($value));
    }
    return $data == $value;
  }

  /**
   * {@inheritdoc}
   */
  protected function isLessThan($data, $value) {
    return $data < $value;
  }

  /**
   * {@inheritdoc}
   */
  protected function isGreaterThan($data, $value) {
    return $data > $value;
  }

  /**
   * {@inheritdoc}
   */
  protected function contains($data, $value) {
    return is_string($data) && strpos($data, $value) !== FALSE || is_array($data) && in_array($value, $data);
  }

  /**
   * {@inheritdoc}
   */
  protected function isIn($data, $value) {
    return is_array($value) && in_array($data, $value);
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    $data = $this->getContextValue('data');
    $op = $this->getContextValue('op');
    $value = $this->getContextValue('value');
    
    switch ($op) {
      case '<':
        return $this->isLessThan($data, $value);
      case '>':
        return $this->isGreaterThan($data, $value);
        // Note: This is deprecated by the text comparison condition and IN below.
      case 'contains':
        return $this->contains($data, $value);
      case 'IN':
        return $this->isIn($data, $value);
      default:
      case '==':
        return $this->isEqual($data, $value);
    }
  }

}
