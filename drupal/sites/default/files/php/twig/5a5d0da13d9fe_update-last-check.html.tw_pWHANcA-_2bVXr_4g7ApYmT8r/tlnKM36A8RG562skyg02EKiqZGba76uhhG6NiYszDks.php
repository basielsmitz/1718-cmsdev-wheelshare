<?php

/* core/themes/stable/templates/admin/update-last-check.html.twig */
class __TwigTemplate_3f6e4ed7965d76c8d33bbd72018e44c02b2b686defbbb91fdeb11f5bf88cbbc8 extends Twig_Template
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
        $tags = array("if" => 15);
        $filters = array("t" => 16);
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('if'),
                array('t'),
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

        // line 14
        echo "<p>
  ";
        // line 15
        if (($context["last"] ?? null)) {
            // line 16
            echo "    ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Last checked: @time ago", array("@time" => ($context["time"] ?? null)))));
            echo "
  ";
        } else {
            // line 18
            echo "    ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Last checked: never")));
            echo "
  ";
        }
        // line 20
        echo "  (";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["link"] ?? null), "html", null, true));
        echo ")
</p>
";
    }

    public function getTemplateName()
    {
        return "core/themes/stable/templates/admin/update-last-check.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 20,  54 => 18,  48 => 16,  46 => 15,  43 => 14,);
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
 * Theme override for the last time update data was checked.
 *
 * Available variables:
 * - last: The timestamp that the site was last checked for updates.
 * - time: The formatted time since the site last checked for updates.
 * - link: A link to check for updates manually.
 *
 * @see template_preprocess_update_last_check()
 */
#}
<p>
  {% if last %}
    {{ 'Last checked: @time ago'|t({'@time': time}) }}
  {% else %}
    {{ 'Last checked: never'|t }}
  {% endif %}
  ({{ link }})
</p>
", "core/themes/stable/templates/admin/update-last-check.html.twig", "C:\\Users\\basie\\Code\\sites\\1718\\1718_cmsdev-eind\\drupal\\core\\themes\\stable\\templates\\admin\\update-last-check.html.twig");
    }
}
