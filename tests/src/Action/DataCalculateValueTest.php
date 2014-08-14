<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Action\DataCalculateValueTest.
 */

namespace Drupal\rules\Tests\Action;

use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\rules\Plugin\Action\DataCalculateValue;
use Drupal\rules\Tests\RulesTestBase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Action\DataCalculateValue
 * @group rules_action
 */
class DataCalculateValueTest extends RulesTestBase {

  /**
   * The action to be tested.
   *
   * @var \Drupal\rules\Engine\RulesActionInterface
   */
  protected $action;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->action = new DataCalculateValue([], '', ['context' => [
      'input_1' => new ContextDefinition('decimal'),
      'op' => new ContextDefinition('string'),
      'input_2' => new ContextDefinition('decimal'),
    ]]);

    $this->action->setStringTranslation($this->getMockStringTranslation());
    $this->action->setTypedDataManager($this->getMockTypedDataManager());
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('Calculate a value', $this->action->summary());
  }

  /**
   * Tests the action execution.
   *
   * @covers ::execute()
   */
  public function testActionExecution() {
    $input_1 = 10;
    $input_2 = 18;
    $operations = array(
      array(
        'op' => '+',
        'expected_value' => $input_1 + $input_2,
      ),
      array(
        'op' => '-',
        'expected_value' => $input_1 - $input_2,
      ),
      array(
        'op' => '*',
        'expected_value' => $input_1 * $input_2,
      ),
      array(
        'op' => '/',
        'expected_value' => $input_1 / $input_2,
      ),
      array(
        'op' => 'min',
        'expected_value' => min($input_1, $input_2),
      ),
      array(
        'op' => 'max',
        'expected_value' => max($input_1, $input_2),
      ),
    );
    foreach ($operations as $operation) {
      $this->action->setContextValue('input_1', $this->getMockTypedData($input_1))
        ->setContextValue('op', $this->getMockTypedData($operation['op']))
        ->setContextValue('input_2', $this->getMockTypedData($input_2));

      $this->action->execute();
      $this->assertEquals($operation['expected_value'], $this->action->getProvided('result'), "Action for calculating values of {$input_1} {$operation['op']} {$input_2}.");
    }
  }
}
