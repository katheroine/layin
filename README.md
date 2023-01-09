# Layin
General purpose web page layout.

See demo [https://katheroine.github.io/layin]

## Prerequisites

1. **PHP**: at least PHP **7.2.5**
2. [**Composer**](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) - dependency manager for PHP.
3. A web server (Apache has been used in the example below).

## Project set-up

1. Create project directory and place `composer.json` - project configurtion file for Composer with appropriate content, eg.:

```JSON
{
    "name": "awesomeauthor/awesomesite",
    "description": "Some awesome site.",
    "type": "project",
    "require": {
        "katheroine/layin": "*"
    },
    "require-dev": {
        "phpunit/phpunit": "*",
        "squizlabs/php_codesniffer": "*"
    },
    "autoload": {
        "psr-4": {
            "AwesomeAuthor\\AwesomeSite\\": [
                "src/"
            ],
            "AwesomeAuthor\\AwesomeSite\\Preconfiguration\\": [
                "site/preconfigurations/",
                "site/preconfigurations/page_renderers/"
            ]
        }
    },
    "autoload-dev": {
        "psr-4": {
            "AwesomeAuthor\\AwesomeSite\\": [
                "tests/"
            ]
        }
    }
}

```

2. Run in the console:

```BASH
$ composer install
```

The `vendor` directory will be created and the dependencies will be placed there.

3. If you're using Git, create `.gitignore` file with `vendor` directory and optionally `composer.lock`:

```
vendor
composer.lock

```

It will remove those files/directories from the Git tracking process, so that those ones won't be placed in the respository.

4. Prepare project directories structure within the main project directory:

```
- site
    - config
    - preconfigurations
    - public
        - assets
            - images
            - scripts
            - stylesheets
        - pages
    - templates
```

You can use the predefined Layin command:

```BASH
$ vendor/bin/layin site:prepare
```

5. Choose concrete theme, e.g. *Violet* - currently the only available, and generate links to its files, which will be placed in the `site` directory.
You can use the predefined Layin command:

```BASH
$ vendor/bin/layin theme:load violet
```

6. Copy and edit the configuration files from vendor/katheroine/layin/site/config to site/config directory and replace its content with the one appropriate to your site:

- `site.config.yaml`

```YAML
html_doc_title: Some awesome site
html_doc_description: My awesome site based on the Layin layout system
html_doc_keywords: awesome site, layin example
html_doc_author:
  name: Lucy Diamond
  email: lucy.diamond@someemailbox.com
html_doc_charset: utf-8
html_doc_language: english
html_doc_language_code: en-EN
header_title: The awesome site
header_subtitle: good place on the web
footer_copyright_range: 2023
footer_site_name: The awesome site

```

- `navigation_links.yaml`

```YAML
- css_id: home-link
  title: News
  url_part: [[base_url]]

```

- `contact_info_links.yaml`

```YAML
- css_id: email-action
  title: e-mail
  value: lucy.diamond@someemailbox.com
  url: mailto:lucy.diamond@someemailbox.com

```

7. Copy and edit the `AbstractBasePreconfiguredPageRenderer.php` file from `vendor/katheroine/layin/site/preconfigurations/page_renderers` to `site/preconfigurations/page_renderers`:

```PHP
<?php

namespace AwesomeAuthor\AwesomeSite\Preconfiguration;

use Katheroine\Layin\Renderer\AbstractPageRenderer;
use Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer;
use Katheroine\Layin\Renderer\TwigPageRenderer;

abstract class AbstractBasePreconfiguredPageRenderer extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePageRenderer(): AbstractPageRenderer
    {
        return new TwigPageRenderer();
    }

    abstract protected function providePreconfiguration(): array;
}

```

Copy and edit the `IndexPreconfiguredPageRenderer.php` file from `vendor/katheroine/layin/site/preconfigurations/page_renderers` to `site/preconfigurations/page_renderers` directory:

```PHP
<?php

namespace AwesomeAuthor\AwesomeSite\Preconfiguration;

class IndexPreconfiguredPageRenderer extends AbstractBasePreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_path' => __DIR__ . '/../../templates',
            'template_subdir_path' => '',
            'template_file_extension' => 'twig.html',
            'page_file_extension' => 'php',
            'site_config_path' => '../../config/site_config.yaml',
            'navigation_links_config_path' => '../../config/navigation_links.yaml',
            'contact_info_links_config_path' => '../../config/contact_info_links.yaml',
            'base_url' => '../',
            'subpages_url' => 'pages',
            'assets_dir_path' => '../assets',
            'is_debug_mode' => false,
        ];
    }
}

```

8. Create custom Twig base template (needed for adding custom CSS stylesheets) `base.awesomesite.twig.html`

```HTML
{% extends 'base.violet.twig.html' %}
{% block stylesheets_custom %}
{% endblock stylesheets_custom %}


```

9. Create Twig template for index page `index.awesomesite.twig.html`, based on `base.awesomesite.twig.html`

```HTML
{% extends 'base.awesomesite.twig.html' %}
{% block board %}
{% endblock %}


```

10. Copy and edit the `index.php` file from `vendor/katheroine/layin/site/public/pages` to `site/public/pages` directory

```PHP
<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use AwesomeAuthor\AwesomeSite\Preconfiguration\IndexPreconfiguredPageRenderer;

$pageRenderer = new IndexPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('index.awesomesite');

echo $pageRenderer->render();

```

11. Generate Composer autoload files

```BASH
$ composer dump-autoload

```

12. Set-up new Apache virtualhost besed on [example](https://github.com/katheroine/layin/blob/develop/doc/examples/apache-site-example.conf) with `ServerName` set to `awesomesite.local`.

13. Add appropriate entry in the `/etc/hosts` file.

14. Run [http://awesomesite.local/](http://awesomesite.local/) on the web browser.
You should see the properly displayed page with the header title and subtitle previously configured by you, but with no graphics nor styles.

15. Create the colors defining stylesheets in the `site/public/assets/stylesheets` directory and name them with the `awesomesite` phrase, and fill with the choosen colors (use the examples below):

- `colors.awesomesite.css`

```CSS
:root
{
  --white: #ffffff;
  --dark-violet: #2d004c;
  --middle-violet: #3e1d54;
  --light-violet: #62357e;
  --dark-orange: #ce6122;
  --deep-orange: #de6c2a;
  --dim-orange: #f17c39;
  --middle-orange: #ff8d4c;
  --light-orange: #fc9d67;
  --dark-blue: #0b1a2e;
}

```

- `colors-site.awesomesite.css`

```CSS
:root
{
  --body-background-color: var(--dark-violet);
  --banner-background-color: var(--dark-violet);
  --banner-text-color: var(--white);
  --controls-background-color: var(--middle-orange);
  --controls-text-color: var(--white);
  --controls-backlight-color: var(--light-orange);
  --guideboard-background-color: var(--middle-orange);
  --guideboard-text-color: var(--white);
  --guideboard-backlight-color: var(--dim-orange);
  --guideboard-button-separator-color: var(--dim-orange);
  --guideboard-submenu-background-color: var(--deep-orange);
  --guideboard-submenu-text-color: var(--white);
  --guideboard-submenu-backlight-color: var(--dark-orange);
  --guideboard-submenu-button-separator-color: var(--dark-orange);
  --board-background-color: var(--white);
  --board-text-color: var(--dark-blue);
  --info-background-color: var(--dark-violet);
  --info-text-color: var(--white);
  --info-backlight-color: var(--middle-violet);
  --info-button-separator-color: var(--middle-violet);
  --copyright-background-color: var(--light-violet);
  --copyright-font-color: var(--white);
}

```

- `colors-site-accessibility.awesomesite.css`

```CSS
:root
{
  /* contrast */
  --contrast-header-background-color: #182652;
  --contrast-header-text-color: white;
  --contrast-controls-background-color: #6e005f;
  --contrast-controls-text-color: white;
  --contrast-controls-backlight-color: #2668bf;
  --contrast-guideboard-background-color: #6e005f;
  --contrast-guideboard-text-color: white;
  --contrast-guideboard-backlight-color: #2668bf;
  --contrast-guideboard-submenu-background-color: #9764c8;
  --contrast-guideboard-button-separator-color: white;
  --contrast-board-background-color: black;
  --contrast-board-text-color: white;
  --contrast-footer-background-color: #6e005f;
  --contrast-footer-backlight-color: #2668bf;
  --contrast-footer-button-separator-color: white;
  --contrast-copyright-background-color: navy;
}

```

16. Complete the `site/templates/base.awesomesite.twig.html` template file with previously creates CSS stylesheets:

```HTML
{% extends 'base.violet.twig.html' %}
{% block stylesheets_custom %}
<link type="text/css" rel="stylesheet" href="{{assets_dir}}/stylesheets/colors.sp22kce.css">
<link type="text/css" rel="stylesheet" href="{{assets_dir}}/stylesheets/colors-site.sp22kce.css">
<link type="text/css" rel="stylesheet" href="{{assets_dir}}/stylesheets/colors-site-accessibility.sp22kce.css">
{% endblock stylesheets_custom %}

```

After refreshing the site in the web browser you should see the change in the colors.

17. Prepare logo in the `PNG` format and save it as `site/public/assets/images/logo.png`.
After refreshing the site in the web browser you should see the logo on the page.

18. Prepare the background cover in the `PNG` format and save it as `site/public/assets/images/cover.jpeg`.
After refreshing the site in the web browser you should see the cover on the page.

19. Create the icons setting `site/public/assets/stylesheets/link-icons.layin.css` stylesheet:

```CSS
#dial .menu-button#increase-font-trigger:before
{
  background-image: url('../images/icons.violet/a_plus.svg');
}

#dial .menu-button#decrease-font-trigger:before
{
  background-image: url('../images/icons.violet/a_minus.svg');
}

#dial .menu-button#toggle-contrast-trigger:before
{
  background-image: url('../images/icons.violet/contrast.svg');
}

#dial .menu-button#reset-accessibility-trigger:before
{
  background-image: url('../images/icons.violet/reset.svg');
}

#dial .menu-button#go-up-link:before
{
  background-image: url('../images/icons.violet/arrow_up.svg');
}

#dial .menu-button#guideboard-trigger:before
{
  background-image: url('../images/icons.violet/hamburger.svg');
}

nav .menu-button#home-link:before
{
  background-image: url('../images/icons.violet/house.svg');
}

#contact-info .menu-button#address-link:before
{
  background-image: url('../images/icons.violet/map.svg');
}

#contact-info .menu-button#email-action:before
{
  background-image: url('../images/icons.violet/monkey_envelope.svg');
}

#contact-info .menu-button#phone-action:before
{
  background-image: url('../images/icons.violet/phone.svg');
}

#contact-info .menu-button#fax-action:before
{
  background-image: url('../images/icons.violet/fax.svg');
}

```

After refreshing the site in the web browser you should see the icons on the page.
