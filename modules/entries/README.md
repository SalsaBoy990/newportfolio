# Entries module

- Entries CRUD
- TinyMCE Text Editor https://www.tiny.cloud/docs/tinymce/6/php-projects/
- htmlpurifier (sanitizing html content for the text editor) http://htmlpurifier.org/


## 3rd party dependencies

### Install: 

`composer install`

Used versions:
```
"tinymce/tinymce": "6.3.1",
"ezyang/htmlpurifier": "4.16.0"
```

Copy the 3rd party-dependencies into the assets folder.

### Update dependencies:

1. Update version numbers in `composer.json`. The version numbers are FIXED ON PURPOSE!
2. `composer update`
3. Copy the folders fom `vendor` folder to the `assets` folder.


## TODO

- hierarchical categories for the entries _(relation)_
- tags for the entries _(relation)_
- document upload for entries _(relation)_
- authentication & authorization _(permissions to add categories, file / document uploads etc.)_


## Author

&copy; 2023 András Gulácsi
MIT licence
