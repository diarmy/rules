<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Plugin\Condition\DataComparisonTest.
 */

namespace Drupal\rules\Tests\Condition;

use Drupal\simpletest\KernelTestBase;

/**
 * Tests the 'Data comparison' condition.
 */
class DataComparisonTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['rules'];

  /**
   * The condition manager.
   *
   * @var \Drupal\Core\Condition\ConditionManager
   */
  protected $conditionManager;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => 'Data comparison condition tests',
      'description' => 'Tests that data comparisons are true.',
      'group' => 'Rules conditions',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->conditionManager = $this->container->get('plugin.manager.condition', $this->container->get('container.namespaces'));
  }

  /**
   * Tests evaluating the condition.
   */
  public function testConditionEvaluation() {
    // Test that when the data string equals the value string and the operator
    // is '==', TRUE is returned
    $test_string_data = 'Llama';
    $test_string_value = 'Llama';
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_string_data)
      ->setContextValue('op', '==')
      ->setContextValue('value', $test_string_value);
    $this->assertTrue($condition->execute());

    // Test that when the data string does not equal the value string and the
    // operator is '==', FALSE is returned
    $test_string_data = 'Kitten';
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_string_data)
      ->setContextValue('op', '==')
      ->setContextValue('value', $test_string_value);
    $this->assertFalse($condition->execute());

    // Test that when the data string contains the value string, and the operator
    // is 'CONTAINS', TRUE is returned
    $test_string_data = 'Big Llama';
    $test_string_value = 'Llama';
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_string_data)
      ->setContextValue('op', 'contains')
      ->setContextValue('value', $test_string_value);
    $this->assertTrue($condition->execute());

    // Test that when the data string does not contain the value string, and
    // the operator is 'contains', TRUE is returned
    $test_string_value = 'Big Kitten';
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_string_data)
      ->setContextValue('op', 'contains')
      ->setContextValue('value', $test_string_value);
    $this->assertFalse($condition->execute());

    // Test that when both data and value are false booleans and the operator
    // is '==', TRUE is returned
    $test_boolean_data = FALSE;
    $test_boolean_value = FALSE;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_boolean_data)
      ->setContextValue('op', '==')
      ->setContextValue('value', $test_boolean_value);
    $this->assertTrue($condition->execute());

    // Test that when a boolean data does not equal a boolean value
    // and the operator is '==', FALSE is returned
    $test_boolean_value = TRUE;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_boolean_data)
      ->setContextValue('op', '==')
      ->setContextValue('value', $test_boolean_value);
    $this->assertFalse($condition->execute());

    // Test that when a data array contains the value string, and the operator 
    // is 'CONTAINS', TRUE is returned
    $test_array_data = array('Llama', 'Kitten');
    $test_string_value = 'Llama';
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_array_data)
      ->setContextValue('op', 'contains')
      ->setContextValue('value', $test_string_value);
    $this->assertTrue($condition->execute());

    // Test that when a data array does not contain the value array, and the
    // operator is 'CONTAINS', TRUE is returned
    $test_array_data = array('Kitten');
    $test_array_value = array('Llama');
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_array_data)
      ->setContextValue('op', 'contains')
      ->setContextValue('value', $test_array_value);
    $this->assertFalse($condition->execute());

    // Test that when the data string is 'IN' the value array, TRUE is returned
    $test_string_data = 'Llama';
    $test_array_value = array('Llama', 'Kitten');
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_string_data)
      ->setContextValue('op', 'IN')
      ->setContextValue('value', $test_array_value);
    $this->assertTrue($condition->execute());

    // Test that when the data array is not in the value array, and the operator
    // is 'IN', FALSE is returned
    $test_array_data = array('Llama');
    $test_array_value = array('Kitten');
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_array_data)
      ->setContextValue('op', 'IN')
      ->setContextValue('value', $test_array_value);
    $this->assertFalse($condition->execute());

    // Test that when data is greater than value and operator is '>', 
    // TRUE is returned
    $test_integer_data = 2;
    $test_integer_value = 1;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_integer_data)
      ->setContextValue('op', '>')
      ->setContextValue('value', $test_integer_value);
    $this->assertTrue($condition->execute());

    // Test that when data is less than value and operator is '>', 
    // FALSE is returned
    $test_integer_data = 1;
    $test_integer_value = 2;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_integer_data)
      ->setContextValue('op', '>')
      ->setContextValue('value', $test_integer_value);
    $this->assertFalse($condition->execute());

    // Test that when data is less than value and operator is '<', 
    // TRUE is returned
    $test_integer_data = 1;
    $test_integer_value = 2;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_integer_data)
      ->setContextValue('op', '<')
      ->setContextValue('value', $test_integer_value);
    $this->assertTrue($condition->execute());

    // Test that when data is greater than value and operator is '<', 
    // FALSE is returned
    $test_integer_data = 2;
    $test_integer_value = 1;
    $condition = $this->conditionManager->createInstance('rules_data_comparison')
      ->setContextValue('data', $test_integer_data)
      ->setContextValue('op', '<')
      ->setContextValue('value', $test_integer_value);
    $this->assertFalse($condition->execute());
  }

}
