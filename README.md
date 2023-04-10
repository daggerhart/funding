# Funding

The [Funding](https://drupal.org/project/funding) Tools project provides integrations for displaying crowdfunding information ([OpenCollective](https://opencollective.com/), [Patreon](https://www.patreon.com/), etc.).

## How to Install

Once you get the module [installed](https://www.drupal.org/docs/extending-drupal/installing-modules) and enabled, you need to add the funding field to a content type:

1. Visit Admin > Structure > Content Types > [your content type] > Manage Fields.
2. Add a new field of type "Funding Yaml".
3. Leave the default widget "Funding".
4. On the "Manage Display" screen, choose between "Funding Processor".
5. Create a piece of content with the content type you set up. Yaml examples will be provided below the Yaml field.

### Configuration Instructions

[More detailed instructions for setting up Funding, Providers and Widgets are also available on the Drupal Wiki.](https://www.drupal.org/docs/contributed-modules/funding)

Any providers that are not supported will not be displayed, though they will be stored in the database.

### Additional Help or Support

If you need help, jump into `#funding` on [Drupal Slack](https://www.drupal.org/slack) or `#drupal` on [OpenCollective Slack](https://slack.opencollective.com/).

If you have a suggestion or want to contribute code, please visit the [Funding module issue queue](https://www.drupal.org/project/issues/funding).

## Planning

* Future plan: A Drush command to find crowdfunding links in module.info files or project pages
* Future: A means of surfacing Drupal.org funding info by inspecting project repository for info in composer.json or funding.yml files

Is there a particular crowdfunding service you'd like to see supported? Jump into the issue queue and send us a patch!

Supported by the [Portland Drupal Users Group](https://opencollective.com/portland-drupal).
