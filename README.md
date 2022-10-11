# Funding

The goal of the [Funding](https://drupal.org/project/funding) Extensions for CMS Users project is to enable people to post their crowdfunding information ([OpenCollective](https://opencollective.com/), [Patreon](https://www.patreon.com/), etc.) without needing to allow script tags. Our first customer will be Drupal.org (we hope).

## How to Install

Once you get the module [installed](https://www.drupal.org/docs/extending-drupal/installing-modules) and enabled, you need to decide which content type to attach the funding field to, then:

1. Visit Admin > Structure > Content Types > [your content type] > Manage Fields.
2. Add a new field of type "Funding Yaml".
3. Leave the default widget "Funding".
4. On the "Manage Display" screen, choose between "Funding text box" or "Funding buttons".
5. Create a piece of content with the content type you set up.

### Configuration Instructions

[More detailed instructions for setting up Funding, Providers and Widgetsare also available on the Drupal Wiki.](https://www.drupal.org/docs/contributed-modules/funding)

### Example Text

```yaml
open_collective: portland-drupal
patreon: liberatr
github: liberatr
custom: https://example.com
```

Any providers that are not supported will not be displayed, though they will be stored in the database.

### Funding buttons

If you are using the "Funding buttons" variant, you will want to use YAML that looks like this:

```yaml
open_collective-js:
  slug: portland-drupal
  verb: donate
  color: blue
open_collective-img:
  slug: portland-drupal
  verb: contribute
  color: white
```

### Additional Help or Support

If you need help, jump into #drupal-pdx on [Drupal Slack](https://www.drupal.org/slack) or #drupal on [OpenCollective Slack](https://slack.opencollective.com/).

If you have a suggestion or want to contribute code, please visit the [Funding module issue queue on Drupal.org](https://www.drupal.org/project/issues/funding).

## History & Context

The discussion for this iteration of the project started when github announced their [FUNDING.yml file](https://help.github.com/en/github/administering-a-repository/displaying-a-sponsor-button-in-your-repository) - the most basic integration will be a copy/paste of the exact same text from the funding.yml file into a "funding" field on a Drupal entity. You can then choose a number of different output formats - some providers and formats may require additional information in the Yaml, please refer to the project readme for the most up-to-date format.

In addition to open source software projects like Drupal modules or initiatives, we would also like to serve local or virtual user groups - local Drupal user groups or anyone who uses Drupal and one of these ongoing crowdfunding platforms.

### Roadmap

[#3094555: Funding module planning thread](https://www.drupal.org/project/funding/issues/3094555)

## What will this module provide?

* A "funding" yaml field + formatters to render links or buttons to popular crowdfunding sites
* Support for all OpenCollective widgets - other projects will be added based on interest (patches welcome)
* Future: integration with [Project Browser](https://www.drupal.org/project/project_browser)?
* Future: A Configurable block to display open collective widgets not attached to a node (given that Drupal 7 will be EOL, and Drupal 9 has fieldable blocks in core, this is no longer strictly necessary)
* Future plan: A Drush command to find crowdfunding links in module.info files or project pages
* Future: A means of surfacing Drupal.org funding info by inspecting project repository for info in composer.json or funding.yml files

Is there a particular crowdfunding service you'd like to see supported? Jump into the issue queue and send us a patch!

Supported by the [Portland Drupal Users Group](https://opencollective.com/portland-drupal).
