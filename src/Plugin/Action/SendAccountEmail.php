<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Action\SendAccountEmail.
 */

namespace Drupal\rules\Plugin\Action;

use Drupal\rules\Core\RulesActionBase;

/**
 * Provides a 'Send account e-mail' action.
 *
 * @Action(
 *   id = "rules_send_account_email",
 *   label = @Translation("Send account e-mail"),
 *   category = @Translation("User"),
 *   context = {
 *     "user" = @ContextDefinition("entity:user",
 *       label = @Translation("User"),
 *       description = @Translation("The user to whom we send the e-mail.")
 *     ),
 *     "email_type" = @ContextDefinition("string",
 *       label = @Translation("E-mail type"),
 *       description = @Translation("The type of the e-mail to send."),
 *     )
 *   }
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 */
class SendAccountEmail extends RulesActionBase {

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Send account e-mail');
  }

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $account = $this->getContextValue('user');
    $mail_type = $this->getContextValue('email_type');
    _user_mail_notify($mail_type, $account);
  }

}
