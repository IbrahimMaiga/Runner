<?php
/**
 * @author Ibrahim Maïga <maiga.ibrm@gmail.com>.
 */

namespace Runner\Engine;


interface DefaultValue
{
    /**
     * Injects value as default params
     * @param object $value to inject
     */
    public function inject($value);
}