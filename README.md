# Funding

The goal of the [Funding](https://drupal.org/project/funding) Extensions for CMS Users project is to enable people to post their crowdfunding information (Patreon, OpenCollective, etc) without needing to allow script tags. Our first customer will be Drupal.org (we hope).

## How to Install

Once you get the module installed and enabled, you need to decide which content type to attach the funding field to, then:

1. Visit Admin > Structure > Content Types > [your content type] > Manage Fields.
2. Add a new field of type "Funding Yaml".
3. Leave the default widget "Funding".
4. On the "Manage Display" screen, choose between "Funding text box" or "Funding buttons".
5. Create a piece of content with the content type you set up.

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

The discussion for this iteration of the project started when github announced their FUNDING.yml file - I know there are some Drupal projects that have this file in their repo. In addition to open source software projects like Drupal modules or initiatives, we would also like to serve local or virtual user groups - local Drupal user groups or anyone who uses Drupal and one of these ongoing crowdfunding platforms.

## What will this module provide?

* A field formatter for link fields to render an open collective widget
* A Configurable block to display open collective widgets not attached to a node
* Future plan: A Drush command to find crowdfunding links in module.info files
* Future plan: A Composer plugin to find crowdfunding links in composer.json files

Is there a particular crowdfunding service you'd like to see supported? Jump into the issue queue and send us a patch!

Supported by the [Portland Drupal Users Group](https://opencollective.com/portland-drupal).
