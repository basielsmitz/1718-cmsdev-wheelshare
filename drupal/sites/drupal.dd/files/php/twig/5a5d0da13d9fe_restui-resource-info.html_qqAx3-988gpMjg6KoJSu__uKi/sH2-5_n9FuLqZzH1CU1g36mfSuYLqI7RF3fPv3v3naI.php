<?php

/* modules/restui/templates/restui-resource-info.html.twig */
class __TwigTemplate_49ddca51217eb815cda2181df791ddbb6d78555b021c1187ab4496b26c5f0e33 extends Twig_Template
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
        $tags = array("if" => 15, "for" => 21);
        $filters = array("join" => 16);
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if', 'for'),
                array('join'),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 15
        if ((($context["granularity"] ?? null) == "resource")) {
            // line 16
            echo "    <p>methods: ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_join_filter($this->getAttribute(($context["configuration"] ?? null), "methods", array()), ", "), "html", null, true));
            echo "</br>
        formats: ";
            // line 17
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_join_filter($this->getAttribute(($context["configuration"] ?? null), "formats", array()), ", "), "html", null, true));
            echo "</br>
        authentication: ";
            // line 18
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_join_filter($this->getAttribute(($context["configuration"] ?? null), "authentication", array()), ", "), "html", null, true));
            echo "
    </p>
";
        } else {
            // line 21
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["configuration"] ?? null));
            foreach ($context['_seq'] as $context["method"] => $context["properties"]) {
                // line 22
                echo "        <p>";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $context["method"], "html", null, true));
                echo "</br>
            formats: ";
                // line 23
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_join_filter($this->getAttribute($context["properties"], "supported_formats", array()), ", "), "html", null, true));
                echo "</br>
            authentication: ";
                // line 24
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_join_filter($this->getAttribute($context["properties"], "supported_auth", array()), ", "), "html", null, true));
                echo "
        </p>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['method'], $context['properties'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "modules/restui/templates/restui-resource-info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 24,  70 => 23,  65 => 22,  60 => 21,  54 => 18,  50 => 17,  45 => 16,  43 => 15,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#
/**
 * @file
 * Default theme implementation for basic administrative info about a REST resource.
 *
 * Available variables:
 * - granularity: string REST resource granularity. Either
 *   \\Drupal\\rest\\RestResourceConfigInterface::METHOD_GRANULARITY or
 *   \\Drupal\\rest\\RestResourceConfigInterface::RESOURCE_GRANULARITY.
 * - configuration: array REST resource config.
 *
 * @ingroup themeable
 */
#}
{% if granularity == 'resource' %}
    <p>methods: {{ configuration.methods|join(', ') }}</br>
        formats: {{ configuration.formats|join(', ') }}</br>
        authentication: {{ configuration.authentication|join(', ') }}
    </p>
{% else %}
    {% for method, properties in configuration %}
        <p>{{ method }}</br>
            formats: {{ properties.supported_formats|join(', ') }}</br>
            authentication: {{ properties.supported_auth|join(', ') }}
        </p>
    {% endfor %}
{% endif %}
", "modules/restui/templates/restui-resource-info.html.twig", "C:\\Users\\basie\\Code\\sites\\1718\\1718_cmsdev-eind\\drupal\\modules\\restui\\templates\\restui-resource-info.html.twig");
    }
}
