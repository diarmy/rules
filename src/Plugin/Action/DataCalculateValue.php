<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Action\DataCalculateValue.
 */

namespace Drupal\rules\Plugin\Action;

use Drupal\rules\Engine\RulesActionBase;

/**
 * Provides a 'Calculate a value' action.
 *
 * @Action(
 *   id = "rules_data_calculate_value",
 *   label = @Translation("Calculate a value"),
 *   context = {
 *     "input_1" = @ContextDefinition("decimal",
 *       label = @Translation("Input value 1"),
 *       description = @Translation("The first input value for the calculation.")
 *     ),
 *     "op" = @ContextDefinition("string",
 *       label = @Translation("Operator"),
 *       description = @Translation("The calculation operator.")
 *     ),
 *     "input_2" = @ContextDefinition("decimal",
 *       label = @Translation("Input value 2"),
 *       description = @Translation("The second input value for the calculation.")
 *     )
 *   },
 *  provides = {
 *     "result" = @ContextDefinition("decimal",
 *       label = @Translation("Calculated value")
 *     )
 *   }
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 * @todo: Add group information from Drupal 7.
 */
class DataCalculateValue extends RulesActionBase {

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Calculate a value');
  }

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $input_1 = $this->getContextValue('input_1');
    $op = $this->getContextValue('op');
    $input_2 = $this->getContextValue('input_2');

    switch ($op) {
      case '+':
        $result = $input_1 + $input_2;
        break;

      case '-':
        $result = $input_1 - $input_2;
        break;

      case '*':
        $result = $input_1 * $input_2;
        break;

      case '/':
        $result = $input_1 / $input_2;
        break;

      case 'min':
        $result = min($input_1, $input_2);
        break;

      case 'max':
        $result = max($input_1, $input_2);
        break;
    }

    if (isset($result)) {
      $this->setProvidedValue('result', $result);
    }
  }

}
