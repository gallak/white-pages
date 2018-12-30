# White pages ESR edition

White pages ESR is an specific version for Educationnal Science and Research people.
You can use Supann features ( specific for French Educationnal Research and Science) and sympa mailing list features

Sympa support is quit poor, but enough for the moment.
Special accreditation must be set ( please take care of privacy of your mailing list
# White Pages


White Pages ESR is based on white-pages 0.2

You can see it at https://github.com/ltb-project/white-pages
Thanks to Clement !

## Presentation

White Pages ESR is a PHP application that allows users to search and display data stored in an LDAP directory.
It can fetch Sympa [http://www.sympa.org] Mailing list, subject homepage and subcribers trough the SOAP services
It can show supann attributes v2009 ( use in french scientific environment) : [https://services.renater.fr/documentation/supann/index]

It use all features of original whites-pages like

It has the following features:
* Quick search: a simple input in menu bar searching on some classic attributes  ( only for user and group, not for sympa mailing and supann structure)
* Advanced search: a full form to search on several attributes ( idem as above)
* Directory: display of all entries in a table form
* Gallery: display of all entries with their photo
* Search and display groups and members
* Export results as CSV
* Export entry as vCard

## Prerequisite

* PHP >= 5.6 (for ldap_escape function)
* PHP extensions required:
  * php-ldap
  * php-gd
  * php-soap (for sympa features)
* Smarty 3

## Documentation

Documentation is available on http://ltb-project.org/wiki/documentation/white-pages

