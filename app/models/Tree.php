<?php

class Tree extends Data
{
    public $pkey;

    public function init($options)
    {
        parent::init($options);
        $this->pkey = $options["pkey"];
    }

    public function parent()
    {
        $o = clone $this;
        $o->reset();
        $o->{$o->key} = $this->{$this->pkey};
        return $o->load();
    }

    public function children()
    {
        $o = clone $this;
        $o->reset();
        $o->{$o->pkey} = $this->{$this->key};
        return $o->find();
    }

    public function toRoot()
    {
        $result = array();
        $o = clone $this;
        do {
            $result[] = $o;
            $o = $o->parent();
            /*$o->($o->key) = $this->($this->pkey);
            $o->load();*/
        } while ($o);
        return array_reverse($result);
    }
}