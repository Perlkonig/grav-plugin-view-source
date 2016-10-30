# View Source Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of this plugin.**

The **View Source** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Allows you to display the raw header and Markdown for a given page

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
```

## Usage

**Describe how to use the plugin.**

## Credits

**Did you incorporate third-party code? Want to thank somebody?**

## To Do

- [ ] Future plans, if any

