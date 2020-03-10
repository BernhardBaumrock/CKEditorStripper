<?php namespace ProcessWire;
/**
 * ProcessWire module to strip unnecessary style attributes and span tags from CKEditor fields
 *
 * The code is taken from forum member Arcturus and packed into a module
 * so that it can be shared and improved across several projects.
 * https://processwire.com/talk/topic/19470-ckeditor-and-pasting/

 * @author Bernhard Baumrock, 10.03.2020
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class CkeStripper extends WireData implements Module {

  public static function getModuleInfo() {
    return [
      'title' => 'CKEditor Stripper',
      'version' => '0.0.1',
      'summary' => 'ProcessWire module to strip unnecessary style attributes and span tags from CKEditor fields.',
      'autoload' => true,
      'singular' => true,
      'icon' => 'code',
      'requires' => [],
      'installs' => [],
    ];
  }

  public function init() {
    $this->addHookAfter('InputfieldCKEditor::processInput', function($event) {
      $inputfield = $event->object;
      $value = $inputfield->attr('value');
      if(strpos($value, 'style=') === false) return;
      $count = 0;
      $qty = 0;

      // Optional remove spans
      $value = preg_replace('/<span.*?>/i', '', $value, -1, $qty);
      $value = preg_replace('/<\/span.*?>/i', '', $value, -1);
      $count = $count + $qty;

      // Remove inline styles from specified tags
      $tags = array('p','h2','h3','h4','li');
      foreach ($tags as $tag){
        $value = preg_replace('/(<'.$tag.'[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $value, -1, $qty);
        $count = $count + $qty;
      }

      if(!$count) return;
      $inputfield->attr('value', $value);
      $inputfield->trackChange('value');
      $inputfield->warning("Stripped $count style attribute(s) from field $inputfield->name");
    });
  }
}
