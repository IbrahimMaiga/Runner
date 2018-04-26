<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Tests;


class FakeClass
{
    public function id($i) {
        return $i;
    }

    public function injection(ToInject $inject, int $id) {
        if ($inject instanceof ToInject) {
            return $id;
        } else {
            return null;
        }
    }

    public function injection2(ToInject $inject, ToInject1 $inject1, int $id) {
        if ($inject instanceof ToInject and $inject1 instanceof ToInject1) {
            return $id;
        } else {
            return null;
        }
    }

}