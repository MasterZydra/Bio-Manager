# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Types of changes: `Added`, `Changed`, `Deprecate`, `Removed`, `Fixed`, `Secruity`

## [Unreleased]

### Added
- Added support for `allow[Edit|Delete]` functions to prevent delete and edit operations of used entities

## v2.0.1 - 22.02.2024 - Minor styling improvements

### Added
- Added values parameter to `__()` so that placeholders can be used without `sprintf`

### Changed
- Minor styling improvements

## v2.0.0 - 21.02.2024 - Same frontend with new backend

### Added
- Added bioman CLI that can be extended with commands
- Added `registerFn` to simplify registering global available functions
- Added unit test framework with bioman CLI command to run them
- Added i18n framework
- Added routing with `routes` file to register routes
- Added support for database migrations and seeders
- Added database class that supports prepared and unprepared SQL statements
- Added base model for models that are stored in the database
- Added facade Path with function for joining paths
- Added facade File with function to find files in folders with option for recursive search, only files and only directories
- Added facade URL with function for joining URLs
- Added facade Convert with function for converting a boolean into an integer
- Added bioman CLI command to create a new commands, controllers, migrations, models, seeders, testcases and users
- Added web cli
- Added permission system based on roles
- Added docker image and build pipeline. The docker image is published in the GitHub container registry
- Added custom error and exception handler

## 1.3.11 - Unreleased 

### Added
- Added namespaces and autoloader so that the includes can be removed
- Added gateway design pattern to encapsulate database queries
- Added prepared statements for updating an entry
- Added prepared implementation for insert

### Changed
- Use prepared statements and data objects for adding, editing or showing elements (e.g. plot, supplier, product ...)
- Move documentation from wiki into markdown files
- Plot, product, supplier work with gateway design pattern now instead of SQL in the files directly

### Fixed
- Fixed errors and warnings to be more compatible with the PSR12 coding standard.

## 1.3.10 - 28.06.2021 - Graphical improvements and small changes background logic
### Added
- Added sorting of suppliers by state and name
- Added documentation of supported types in table generator
- Added thousand separator to invoices
- Added statistic to get the distribution of volume per plot
- Added select box for invoice selection
- Added invoice year and number to title and document name for supplier payments
- Add total volume to crop volume distribution

### Changed
- Unified file names of statistics files
- Move all statistics to statistic area
- More opions for supplier payments. Only assigned to invoice and only for one specific invoice.

### Fixed
- Fixed filename in ConfigChecker
- Fixed documentation in source files
- Fixed crop volume distribution calculation

### Removed
- Remove time stamp from supplier payments document name


## 1.3.9 - 08.10.2020 - Adding new statistics. Changes in background logic
### Added
- Add class to generate a PDF document and use it for invoice
- Add helper functions for message boxes
- Add form to configure the database connection
- Add configuration for common settings. Add setting for organization name in header.
- Add statistics.
    - Add PDF to show all active suppliers.
    - Add PDF to show supplier payments

### Changed
- Layout: Set point as thousand separator

### Fixed
- Fix JSLint warnings


## 1.3.8 - 30.12.2019 - Make data configurable in forms
### Added
- Form to edit invoice data
- Add check to form if given GET parameter “id” is a numeric
- Check if configurations exist and set
- Add and use helper function to trim string and remove/replace HTML special characters for GET and POST parameters
- Add form to make database connection configurable
- Add not-pseudo class to fix input CSS for checkbox

### Changed
- Check if imprint is configured before include/showing the values to prevent warnings
- Move settings for invoice from data base into config file
- Code formatting
- Update to PHP 7.4.0
  - Use new features
  - Update TCPDF version
- Replace old table generator completely


## 1.3.7 - 21.11.2019 - Darkmode, improvements in core logic and security
### Added
- Add class for prepared statements
- CSS for **dark mode**
- Add parameter to **table** generator to give data types of the columns and **format** them
  - bool: show as “Ja” und “Nein”
  - date: show in German format “dd.mm.YYYY”
  - int: align right
- Add option to open selected actions in data table in a new tab

### Changed
- Outsourcing of person data from imprint into config file for better maintainablity
- Use new option to only show invoice action in new tab
- Clean up code for better readability
- New table generator. Has columns and data types in one parameter. Changed order of the parameters according to actual use of the parameters.
- Change link color in light mode to green

### Fixed
- Use **prepared statements** to prevent sql injections
- Add missing required stars
- Small changes so HTML validator throws less warnings

### Removed
- No JavaScript script necessary to format cell content right.
- Simplify CSS by removing type of input field in CSS rules


## 1.3.6 - 16.09.2019 - Add recipients for more than one recipient for invoices. Design changes.
### Added
- Add table for recipients
- Add forms (add, edit, delete and show) for recipients
- Add recipient to invoice forms (add, edit, show)
- Add template for overview pages
- Show star after field name if it is required

### Changed
- Add impressum and system information link in footer instead of index page
- Change invoice generator logic to get recipient from invoice table instead of setting table
- Rebuild templates form and deleteForm without eval function
- Change delete forms to work with changed templates

### Fixed
- Fixing CSS for inputs in table cells so it uses the complete width of a cell
- Show form only if an entry has been found
- Add footer again after fixing for overlapping issue


## 1.3.5 - 03.09.2019 - Legal contents
### Added
- Add about.php for system information
- Add impressum and privacy policy


## 1.3.4 - 03.09.2019 - Fine tunings
### Added
- Add favicon.
- Add delete page for user.
- Add documentation.
- Add further permission checks.
- Add feature to **show own delivery notes**.
- Add **delete** and **edit** pages for **invoices**.


## 1.3.3 - 28.08.2019 - Unique database entries
### Added
- Add logic to check if entry is unique before adding and saving a change.  
  **Unique field:**
  - User login
  - Product name
  - Pricing (year and product)
  - Plot number
  - Supplier name


## 1.3.2 - 26.08.2019 - Add pricing
### Added
- Add tables for pricing of the products per year.
- Add product to delivery note.

### Changed
- Get price of product for invoice from data base.


## 1.3.1 - 23.08.2019 - Add product
### Added
- Add forms for adding, editing and deleting a product.


## 1.3 - 23.08.2019 - Add invoices
### Added
- Invoices can be added and showed as PDF.  
  First version of the implementation.

## 1.2 - 22.08.2019 - New box design for start page
### Changed
- Sections like **delivery note**, **supplier**, ... are organized in floating boxes. 

### Remove
- The logout button is removed from the header.
- The footer was removed because of overlapping problems.


## 1.1 - 21.08.2019 - Add management of volume distribution of a delivery note
### Added
- Add form and logic to manage the volume distribution of a delivery note to plots.
- Add new table generator for the additional action.


## 1.0 - 19.08.2019 - Create connection between all contents
### Added
- Add option to select the supplier in a select element.  
  The object is implemented in the forms for **plots**, **delivery notes** and **users**.


## 0.8 - 18.08.2019 - Finishing all contents
### Added
- Added the forms and logic to **add**, **edit**, **delete** and **show** the **suppliers**, **delivery notes** and  **plots**


## 0.5 - 18.08.2019 - Finishing user system with all basic functions
### Added
- All basic functions for user management are implemented.  
- A user can be **added**, **deleted** and **modified**.  
- A user can has permissions which are used for managing the page access.  
- The **password** of a user can be **changed**, in case the user has forget its password.  
- The user can login and logout.
