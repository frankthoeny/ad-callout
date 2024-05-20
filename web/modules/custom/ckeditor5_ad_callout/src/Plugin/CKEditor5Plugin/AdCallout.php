<?php

declare(strict_types = 1);

namespace Drupal\ckeditor5_ad_callout\Plugin\CKEditor5Plugin;

use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableInterface;
use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableTrait;
use Drupal\ckeditor5\Plugin\CKEditor5PluginDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\EditorInterface;

/**
 * CKEditor 5 Ad Callout plugin.
 *
 * @internal
 *   Plugin classes are internal.
 */
class AdCallout extends CKEditor5PluginDefault {

  use CKEditor5PluginConfigurableTrait;

  /**
   * {@inheritdoc}
   */
  public function getDynamicPluginConfig(array $static_plugin_config, EditorInterface $editor): array {
    $config = $static_plugin_config;
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    $form_state->setValue('status', (bool) $form_state->getValue('status'));
  }


  /**
   * {@inheritdoc}
   *
   * This returns an empty array as image upload config is stored out of band.
   */
  public function defaultConfiguration() {
    return [];
  }

}
