<?php

namespace Drupal\export_json\Normalizer;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Drupal\node\NodeInterface;

/**
 * Converts the Drupal entity object structures to a normalized array.
 */
class EventNodeEntityNormalizer extends ContentEntityNormalizer {
  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = 'Drupal\node\NodeInterface';
  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    if (!is_object($data) || !$this->checkFormat($format)) {
      return FALSE;
    }
    if ($data instanceof NodeInterface && $data->getType() == 'event') {
      return TRUE;
    }
    return FALSE;
  }
  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = array()) {
    $attributes = parent::normalize($entity, $format, $context);
    $json_array = array(
      'data' => array(
        'type' => $attributes['type'][0]['target_id'],
        'id' => $attributes['nid'][0]['value'],
        'attributes' => array(
          'title' => $attributes['title'][0]['value'],
          'content' => $attributes['body'][0]['value'],
        ),
      )
    );
    return $json_array;
  }
}
