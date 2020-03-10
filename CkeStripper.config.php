<?php namespace ProcessWire;
class CkeStripperConfig extends ModuleConfig {
  public function getDefaults() {
    return [
    ];
  }
  public function getInputfields() {
    $inputfields = parent::getInputfields();
    
    $inputfields->add([
      'type' => 'markup',
      'label' => 'CKEditor remove style attributes via JS',
      'value' => "You can also add this line to your <em>/site/modules/InputfieldCKEditor/config.js</em><br>"
        ."<pre>CKEDITOR.editorConfig = function( config ) {\n"
        ."  config.disallowedContent = '*{*}'; // All styles disallowed\n"
        ."};</pre>",
    ]);
    
    return $inputfields;
  }
}
