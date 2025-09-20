# RememberUs.org Custom WordPress Theme

This is the official, bespoke WordPress theme for [RememberUs.org](https://rememberus.org/), a non-profit organization dedicated to providing humanitarian aid to the people of Ukraine. The theme was built from the ground up to support the organization's mission and showcase its vital work.

This project was developed on a volunteer basis to support a critical humanitarian cause.

> RememberUs.org is a group of US and Ukraine based volunteers working to help people of Ukraine. Our goal is to provide humanitarian aid to Ukrainians living in war zones. We support orphanages, hospitals, community centers, and vulnerable populations: families with many children, families in poverty situations, the elderly, people with disabilities. Our ears are always on the ground, observing the evolution of the war and responding quickly to the most critical needs.

**Live Site:** [https://rememberus.org/](https://rememberus.org/)

---

## Technical Stack & Key Features

This theme is built with a modern, professional WordPress development stack that emphasizes separation of concerns, maintainability, and ease of content management.

*   **Timber & Twig:** The theme uses the [Timber library](https://timber.github.io/docs/) to separate PHP logic from presentation. All markup is written in `.twig` files located in the `/views` directory, keeping the theme files clean and secure.
*   **Advanced Custom Fields (ACF) Pro:** Content architecture is heavily reliant on ACF Pro. Flexible Content fields and other advanced field types are used to give content editors maximum flexibility.
*   **ACF JSON Sync:** The `core/acf-json` directory is used to store all ACF field group definitions as version-controlled JSON files. This is a best practice for collaborative development and deployment.
*   **Custom Gutenberg Blocks:** The theme extends the native WordPress block editor with custom-built blocks to meet the specific design and content needs of the site. Block registration and logic are handled in `core/gutenberg.php`.
*   **SASS & Prepros:** All theme styles are written in SASS (`.scss`) for maintainability and are organized using a modular structure in the `/assets/scss/` directory. The `prepros.config` file indicates that [Prepros](https://prepros.io/) is the recommended tool for compiling SASS into standard CSS.
*   **Responsive & Mobile-First:** The theme is designed to be fully responsive and provide an optimal viewing experience across all devices.

## Theme Structure

The theme is organized into a logical and intuitive directory structure:

*   `/assets/`: Contains all frontend assets.
    *   `/scss/`: The source SASS files. **This is where you edit styles.**
    *   `/css/`: Compiled CSS files. Do not edit these directly.
    *   `/js/`: Custom JavaScript files.
    *   `/img/`, `/svg/`, `/fonts/`: Image, SVG, and font assets.
*   `/core/`: The "brain" of the theme. Contains all core PHP logic.
    *   `init.php`: Initializes the theme, includes necessary files, and sets up theme supports.
    *   `/acf-json/`: Synchronized JSON files for Advanced Custom Fields.
    *   `/ajax/`: Handlers for custom AJAX functionality.
    *   `/gutenberg.php`: Configuration and registration for custom Gutenberg blocks.
*   `/views/`: Contains all Twig template files used by Timber.
    *   `base.twig`: The main template that others extend.
    *   `/blocks/`: Twig templates for individual custom Gutenberg blocks.
    *   `/overall/`: Templates for global elements like the header and footer.

## Prerequisites

Before working with this theme, you must have the following plugins installed and activated in your WordPress environment:

1.  **Timber Library:** Required to render the Twig templates.
2.  **Advanced Custom Fields Pro:** Required for the content fields and architecture.

## Installation & Setup

1.  Clone this repository into your `wp-content/themes/` directory.
2.  Install and activate the required plugins listed above.
3.  Navigate to **Custom Fields -> Tools** in the WordPress admin area and click the "Sync" button to import all the field groups from the `core/acf-json` directory.
4.  Activate the "RememberUs" theme.

## Development Workflow

To make changes to the theme's styles or JavaScript:

1.  It is highly recommended to use the **Prepros** application. Simply open the theme folder in Prepros, and it will automatically watch for changes in the `/assets/scss/` and `/assets/js/` directories and compile them to their respective `/assets/css/` and `/assets/js/*.min.js` destinations.
2.  If not using Prepros, you will need to set up your own SASS compilation tool to process `assets/scss/style.scss` into `assets/css/style.min.css` (and other relevant files).
3.  Edit the `.twig` files in the `/views/` directory to make changes to the HTML structure.
4.  Edit the `.php` files in the `/core/` directory to make changes to the theme's functionality and logic.

---

This theme was built with care and dedication by a volunteer developer.
