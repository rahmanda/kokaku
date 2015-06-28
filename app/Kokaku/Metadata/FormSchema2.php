<?php namespace App\Kokaku\Metadata;

/**
 * Provides structure of metadata fields for dynamic form
 * Expect xml schema string input on instantiation
 * Output in array or json 
 */
class FormSchema2 {

  /**
   * Namespace prefix
   * 
   * @var string
   */
  protected $namespacePrefix = 'xs';

  /**
   * Standard XML Schema namespace url
   * 
   * @var string
   */
  protected $xmlSchemaNamespace = 'http://www.w3.org/2001/XMLSchema';

  /**
   * XML Schema encoding
   * 
   * @var string
   */
  protected $encoding = 'utf-8';

  /**
   * DOM Document object
   * 
   * @var \DOMDocument
   */
  protected $doc;

  /**
   * DOM XPath object
   * 
   * @var \DOMXPath
   */
  protected $xpath;

  /**
   * Load XML schema string
   * 
   * @param  string $xmlSchema
   */
  protected function loadSchema($xmlSchema) {
    $this->doc = new \DOMDocument();
    $this->doc->loadXML(mb_convert_encoding($xmlSchema, $this->encoding, mb_detect_encoding($xmlSchema)));
    $this->xpath = new \DOMXPath($this->doc);
    $this->xpath->registerNamespace($this->namespacePrefix, $this->xmlSchemaNamespace);
  }

  /**
   * XPath evaluate if element has enumeration
   * 
   * @param  \DOMXPath $element
   * @return \DOMXPath
   */
  public function evaluateEnumeration($element) {
    return $this->xpath->evaluate($this->namespacePrefix.":simpleType/".$this->namespacePrefix.":restriction/".$this->namespacePrefix.":enumeration", $element);
  }

  /**
   * XPath evaluate if element has sequence
   * 
   * @param  \DOMXPath $element 
   * @return \DOMXPath          
   */
  public function evaluateSequence($element) {
    return $this->xpath->evaluate($this->namespacePrefix.":complexType/".$this->namespacePrefix.":sequence/".$this->namespacePrefix.":element", $element);
  }

  /**
   * XPath evaluate if element has schema
   * 
   * @return \DOMXPath
   */
  public function evaluateSchema() {
    return $this->xpath->evaluate("/".$this->namespacePrefix.":schema/".$this->namespacePrefix.":element");
  }

  /**
   * Make array container for fieldset element
   * 
   * @param  \DOMXPath $element
   * @return array         
   */
  public function makeFieldsetElement($element) {
    return array(
      'type'    => 'object',
      'properties'  => new \stdClass() 
      );
  }

  /**
   * Make array container for select element
   * 
   * @param  \DOMXPath $element
   * @return array         
   */
  public function makeSelectElement($element) {
    return array(
      'type'  => 'string',
      'enum'  => array(),
      'x-schema-form' => (object) array('type'=> 'select')
      );
  }

  /**
   * Make array container for generic element
   * 
   * @param  \DOMXPath $element
   * @return array         
   */
  public function makeElement($element) {
    $type = explode(":", $element->getAttribute('type'));
    return array(
      'type'  => ($type[1] == 'string' ? 'text' : $type[1])
      );
  }

  public function makeArrayElement($element) {
    return array(
      'type'  => 'array',
      'items' => (object) array(
        'type' => 'object',
        'properties' => new \stdClass()
        )
      );
  }

  public function makeSingleArrayElement($element) {
    return array(
      'type'  => 'array',
      'items' => new \stdClass
      );
  }

  /**
   * Get elements from XPath element
   * 
   * @param  \DOMXPath $element
   * @return array         
   */
  public function getElements($element) {
    $result = array();
    $sequences = $this->evaluateSequence($element);
    $enum = $this->evaluateEnumeration($element);

    if($sequences->length) {
      $array = ($element->getAttribute('maxOccurs') == 'unbounded' ? true : false);
      if($array) {
        $result = $this->makeArrayElement($element);
        foreach($sequences as $item) {
          $attr = $item->getAttribute('name');
          $result['items']->properties->$attr = (object) $this->getElements($item);
        }
      } else {
        $result = $this->makeFieldsetElement($element);
        foreach($sequences as $item) {
          $attr = $item->getAttribute('name');
          $result['properties']->$attr = (object) $this->getElements($item);
        }
      }
      return $result;
    }

    if($enum->length) {
      $array = ($element->getAttribute('maxOccurs') == 'unbounded' ? true : false);
      if($array) {
        $result = $this->makeSingleArrayElement($element);
        $result['items']->type = 'text';
        $result['items']->enum = array();
        foreach($enum as $item) {
          $attr = $item->getAttribute('value');
          array_push($result['items']->enum, $attr);
        }
      } else {
        $result = $this->makeSelectElement($element);
        foreach($enum as $item) {
          $attr = $item->getAttribute('value');
          array_push($result['enum'], $attr);
        }
      }
      return $result;
    }

    if($element->getAttribute('maxOccurs') == 'unbounded') {
      $result = $this->makeSingleArrayElement($element);
      $result['items']->type = 'text';
      return $result;
    }

    $result = $this->makeElement($element);
    return $result;
  }

  /**
   * Get entire form schema generated from XML Schema string
   * 
   * @return either json or array
   */
  public function getFormSchema($schema, $mode = "json") {
    if(is_null($this->xpath)) {
      $this->loadSchema($schema);
    }

    $result = array();
    $schema = $this->evaluateSchema();

    foreach($schema as $element) {
      array_push($result, $this->getElements($element));
    }

    if ($mode == "json") {
      return json_encode($result[0]);
    } else if ($mode == "array") {
      return $result[0];
    }

    return $result[0];
  }

}