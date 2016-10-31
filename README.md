# View Source Plugin

The **View Source** Plugin is for [Grav CMS](http://github.com/getgrav/grav) and allows you to display the raw header and Markdown for a given page

## Installation

Installing the View Source plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install view-source

This will install the View Source plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/view-source`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `view-source`. You can find these files on [GitHub](https://github.com/aaron-dalton/grav-plugin-view-source) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/view-source
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/view-source/view-source.yaml` to `user/config/plugins/view-source.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
header: true
header_interpolated: true
body: true
body_interpolated: true
```

* `enabled` lets you turn the plugin off entirely.

* The `header` and `body` fields tell the plugin which parts of the page users are allowed to view. If these are set to false, then the plugin returns a `403 FORBIDDEN` when the source is requested.

* The `header_interpolated` and `body_interpolated` let the user view the header and body after being processed by the various plugins. If `header` or `body` are set to false, then the accompanying `*_interpolated` is automatically set to false as well.

You can enable/disable permissions on a page-by-page basis by inserting something like the following in the front matter of the page in question:

```yaml
view-source:
  header: false
  body: false
```

This would fully disable viewing the source of that specific page. You can do this by taxonomy also by using the [Header by Taxonomy plugin](https://github.com/Perlkonig/grav-plugin-header-by-taxonomy).

## Usage

Once enabled, each page view is examined for a query string that contains the parameter `view-source`. If found and set to `interpolated` (e.g., `http://example.com/blog/post?view-source=interpolated`), then the mode is set to `interpolated`. Any other setting (including blank) will result in the mode being set to `original` (e.g., `http://example.com/blog/post?view-source=`).

The plugin will then return a `200 OK` response with a `Content Type` header of `text/plain` and the body containing the source code as described below.

### Original Mode

The returned header will be the front matter as it appears in the original Markdown file. 

The body will be the Markdown itself as it appears in the original Markdown file.

### Interpolated Mode

The returned header will be a YAML dump of the page's header (which can be modified in various ways by plugins). 

The returned body will *usually* be the Markdown after any other Markdown-editing plugins are run. You *should* get the Markdown&mdash;not rendered HTML. But this will depend on how the plugins accomplished their task. This plugin grabs the content after the `onPageContentRaw` event. See [the Grav lifecycle](https://learn.getgrav.org/plugins/grav-lifecycle) for more details, and let me know if it doesn't work as expected in certain cases.
