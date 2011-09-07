<?php
class Project_Twig_Extension extends Twig_Extension
{
    public function getGlobals()
    {
        return array(
            'Admin'         => new ETwigStaticClassProxy('Admin'),
            'Lookup'        => new ETwigStaticClassProxy('Lookup'),
            'ModelFactory'  => new ETwigStaticClassProxy('ModelFactory'),
            'CHtml'         => new ETwigStaticClassProxy('CHtml'),
            //'lipsum' => new Twig_Function(new Text(), 'getLipsum'),
        );
    }

    public function getName()
    {
        return 'project';
    }
}