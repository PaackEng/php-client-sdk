<?php
namespace Paack\Resources;

class Model extends ArrayObject {

  public function __construct($input=[], $flags=0, $iterator_class='ArrayIterator'){
    $mapped = $this->_map($input);
    parent::__construct($mapped, $flags, $iterator_class);
  }

  protected function _map(array $input){
    return $input;
  }
}
