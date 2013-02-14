<?php

/* core/modules/toolbar/templates/toolbar.twig */
class __TwigTemplate_ab21012b3bac63195a87f9c637621891 extends Drupal\Core\Template\TwigTemplate
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 25
        echo "
<nav id=\"";
        // line 26
        echo twig_render_var($this->getAttribute($this->getContextReference($context, "attributes"), "id"));
        echo "\" class=\"";
        echo twig_render_var($this->getAttribute($this->getContextReference($context, "attributes"), "class"));
        echo "\"";
        echo twig_render_var($this->getContextReference($context, "attributes"));
        echo ">
  <!-- Tabs -->
  ";
        // line 28
        echo twig_render_var($this->getContextReference($context, "tabs"));
        echo "

  <!-- Trays -->
  ";
        // line 31
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["trays"]) ? $context["trays"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["tray"]) {
            // line 32
            echo "    <div id=\"";
            echo twig_render_var($this->getAttribute($this->getAttribute($this->getContextReference($context, "tray"), "attributes"), "id"));
            echo "\" class=\"";
            echo twig_render_var($this->getAttribute($this->getAttribute($this->getContextReference($context, "tray"), "attributes"), "class"));
            echo "\"";
            echo twig_render_var($this->getAttribute($this->getContextReference($context, "tray"), "attributes"));
            echo ">
      <div class=\"lining clearfix\">
        <h3 class=\"element-invisible\">";
            // line 34
            echo twig_render_var($this->getAttribute($this->getContextReference($context, "tray"), "heading"));
            echo "</h3>
        ";
            // line 35
            echo twig_render_var($this->getAttribute($this->getContextReference($context, "tray"), "content"));
            echo "
      </div>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tray'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 39
        echo "</nav>
";
    }

    public function getTemplateName()
    {
        return "core/modules/toolbar/templates/toolbar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 39,  55 => 35,  51 => 34,  41 => 32,  37 => 31,  31 => 28,  22 => 26,  19 => 25,);
    }
}
