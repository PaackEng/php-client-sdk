<?php
namespace Paack\Resources;

class Order extends \ArrayObject{
  public function __construct($input=[], $flags=0, $iterator_class='ArrayIterator'){
    parent::__construct($input, $flags, $iterator_class);
  }
}
