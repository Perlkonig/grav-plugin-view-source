<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ViewSourcePlugin
 * @package Grav\Plugin
 */
class ViewSourcePlugin extends Plugin
{

    protected $intermediate = null;

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onPageContentRaw' => ['onPageContentRaw', -1000],
            'onOutputGenerated' => ['onOutputGenerated', -100]
        ]);
    }

    public function onPageContentRaw(Event $e) {
        $this->intermediate = $this->grav['page']->content();
    }

    public function onOutputGenerated(Event $e) {
        // First check to see if the query paramter is there
        $format = null;
        if (array_key_exists('view-source', $_GET)) {
            if (strtolower($_GET['view-source']) === 'interpolated') {
                $format = 'interpolated';
            } else {
                $format = 'orig';
            }
        }

        // If so, process
        if (!is_null($format)) {
            // Merge the page header with the config
            $defaults = (array) $this->config->get('plugins.view-source');
            $page = $this->grav['page'];
            if (isset($page->header()->{'view-source'})) {
                $this->config->set('plugins.view-source', array_merge($defaults, $page->header()->{'view-source'}));
            }

            // If both body and header are forbidden, return a 403
            if ( (! $this->config->get('plugins.view-source.header', false)) && (! $this->config->get('plugins.view-source.body', false)) ) {
                http_response_code(403);
                echo "<h1>403 Forbidden</h1>";
                exit();
            }

            // Otherwise, assemble the permitted parts
            $content = '---'."\n";
            if ( ($format === 'interpolated') && ($this->config->get('plugins.view-source.header', false)) && ($this->config->get('plugins.view-source.header_interpolated', false)) ) {
                $content .= YAML::dump((array) $page->header());

            } elseif ($this->config->get('plugins.view-source.header', false)) {
                $content .= $page->frontmatter();
            }
            $content .= "\n---\n\n";

            if ( ($format === 'interpolated') && ($this->config->get('plugins.view-source.body', false)) && ($this->config->get('plugins.view-source.body_interpolated', false)) ) {
                $content .= $this->intermediate;
            } elseif ($this->config->get('plugins.view-source.body', false)) {
                $content .= $page->file()->markdown();
            }

            // Output as 'text/plain' and halt all further Grav processing
            header('Content-Type: text/plain');
            echo $content;
            exit();
        }
    }
}
