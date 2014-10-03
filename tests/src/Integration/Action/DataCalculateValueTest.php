<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Action\DataCalculateValueTest.
 */

namespace Drupal\Tests\rules\Integration\Action;

use Drupal\rules\Plugin\Action\DataCalculateValue;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Tests\rules\Integration\RulesIntegrationTestBase;
use Drupal\Tests\rules\Unit\RulesUnitTestBase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Action\DataCalculateValue
 * @group rules_action
 */
class DataCalculateValueTest extends RulesIntegrationTestBase {

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
      'input_1' => new ContextDefinition('float'),
      'op' => new ContextDefinition('string'),
      'input_2' => new ContextDefinition('float'),
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
    $this->assertEquals('Calculate a numeric value', $this->action->summary());
  }

  /**
   * Tests the action execution.
   *
   * @covers ::execute()
   */
  public function testActionExecution() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
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
      $this->action->setContextValue('input_1', $this->getTypedData($input_1))
        ->setContextValue('op', $this->getTypedData($operation['op']))
        ->setContextValue('input_2', $this->getTypedData($input_2));

      $this->action->execute();
      $this->assertEquals($operation['expected_value'], $this->action->getProvided('result'), "Action for calculating values of {$input_1} {$operation['op']} {$input_2}.");
    }
  }
}
