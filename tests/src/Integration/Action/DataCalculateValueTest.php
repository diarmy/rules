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
 * @group rules_actions
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
    ], 'provides' => ['result' => new ContextDefinition('float')]]);

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
   * Tests the addition of two numeric values.
   *
   * @covers ::execute()
   */
  public function testAdditionAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', '+'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals($input_1 + $input_2, $result, "Addition calculation correct");
  }

  /**
   * Tests the subtraction of one numeric value from another.
   *
   * @covers ::execute()
   */
  public function testSubtractionAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', '-'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals($input_1 - $input_2, $result, "Subtraction calculation correct");
  }

  /**
   * Tests the multiplication of one numeric by another.
   *
   * @covers ::execute()
   */
  public function testMultiplicationAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', '*'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals($input_1 * $input_2, $result, "Subtraction calculation correct");
  }

  /**
   * Tests the division of one numeric by another.
   *
   * @covers ::execute()
   */
  public function testDivisionAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', '/'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals($input_1 / $input_2, $result, "Subtraction calculation correct");
  }

  /**
   * Tests the use of php's min function for 2 input values
   *
   * @covers ::execute()
   */
  public function testMinimumAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', 'min'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals(min($input_1, $input_2), $result, "Min calculation correct");
  }

  /**
   * Tests the use of php's max function for 2 input values
   *
   * @covers ::execute()
   */
  public function testMaximumAction() {
    $input_1 = mt_rand();
    $input_2 = mt_rand();
    $this->action->setContextValue('input_1', $this->getTypedData('float', $input_1))
      ->setContextValue('op', $this->getTypedData('string', 'max'))
      ->setContextValue('input_2', $this->getTypedData('float', $input_2));
    $this->action->execute();
    $result = $this->action->getProvided('result')->getContextValue();
    $this->assertEquals(max($input_1, $input_2), $result, "Max calculation correct");
  }
}
