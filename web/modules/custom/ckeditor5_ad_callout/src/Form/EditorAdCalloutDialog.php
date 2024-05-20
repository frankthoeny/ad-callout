<?php

namespace Drupal\ad_callout\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Ajax\EditorDialogSave;
use Drupal\editor\Entity\Editor;

/**
 * Provides an Ad Callout dialog for text editors.
 *
 *
 * @internal
 */
class EditorAdDialog extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'editor_ad_callout_dialog';
  }

  /**
   * {@inheritdoc}
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param \Drupal\editor\Entity\Editor $editor
   *   The text editor to which this dialog corresponds.
   */
  public function buildForm(array $form, FormStateInterface $form_state, Editor $editor = null)
  {

    $form['#tree']                  = true;
    $form['#attached']['library'][] = 'editor/drupal.editor.dialog';
    $form['#prefix']                = '<div id="editor-ad-callout-dialog-form">';
    $form['#suffix']                = '</div>';

    $form['aid'] = [
      '#title'    => $this->t('Ad Callout'),
      '#type'     => 'select',
      '#options'  => [
        '1' => $this->t('One'),
        '2' => [
          '2.1' => $this->t('Two point one'),
          '2.2' => $this->t('Two point two'),
        ],
        '3' => $this->t('Three'),
      ],
      '#required' => true,
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['save_modal'] = [
      '#type'   => 'submit',
      '#value'  => $this->t('Save'),
      // No regular submit-handler. This form only works via JavaScript.
      '#submit' => [],
      '#ajax'   => [
        'callback' => '::submitForm',
        'event'    => 'click',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();

    // AID values to data-entity-uuid
    // attributes and set data-entity-type.
    $aid = $form_state->getValue(['aid', 0]);
    if (!empty($aid)) {
      $form_state->setValue(['attributes', 'src'], $aid);
    }

    if ($form_state->getErrors()) {
      unset($form['#prefix'], $form['#suffix']);
      $form['status_messages'] = [
        '#type'   => 'status_messages',
        '#weight' => -10,
      ];
      $response->addCommand(new HtmlCommand('#editor-ad-callout-dialog-form', $form));
    } else {
      $response->addCommand(new EditorDialogSave($form_state->getValues()));
      $response->addCommand(new CloseModalDialogCommand());
    }

    return $response;
  }

}
