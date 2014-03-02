# RBSChange Module Faker

Have a project [RBSChange 4](https://github.com/RBSChange/Change), but your database is empty?

This module provides a command to load random data for products or orders, for instance.
It integrates [Faker](https://github.com/fzaninotto/Faker), a PHP library that generates fake data.

## Installation

Add the requirement [`heristop/module-faker`](https://packagist.org/packages/heristop/rbs-module-faker) to your `composer.json` file:

``` json
{
    "require": {
        "heristop/rbs-module-faker": "*"
    }
}
```

Install the module in the modules manager.

## Usage

How it's works?

Specify entities to load, and the number of documents you want to create, in your configuration file `project.json`:

``` json
    "Heri":{
        "Faker":{
            "entities":{
                "Rbs_Media_Image":{
                    "number": 5
                },
                "Rbs_Brand_Brand":{
                    "number": 5
                },
                "Rbs_Stock_Sku":{
                    "number": 5
                },
                "Rbs_Catalog_Product":{
                    "number": 5
                }
            }
        }
    }
```

Lastly, run this command:

``` json
    php bin/change.phar faker:populate
```

In the previous example, the `Image` and `Brand` models share a relationship. If `Image` documents are populated first, Faker is smart enough to relate the populated Brand documents to one of the populated `Image` documents.

## More configuration

You can add your own formatter for each column of each entity, with or without arguments:

``` json
    "Heri":{
        "Faker":{
            "entities":{
                "Rbs_Media_Image":{
                    "number": 1,
                    "custom_formatters":{
                        "path":{
                            "method": "storeImage",
                            "parameters":{
                                "width": "320",
                                "height": "240",
                                "category": "cats"
                            }
                        }
                    }
                }
            }
        }
    }
```

With the example above, we choose to generate an image of cat:

![ScreenShot](https://raw.github.com/heristop/HeriFakerModule/master/Resources/doc/media_sample.png)

You can use all formatters provided by Faker:

``` json
    "Heri":{
        "Faker":{
            "entities":{
                "Rbs_Stock_Sku":{
                    "custom_formatters":{
                        "ean13":{
                            "method": "randomElement",
                            "parameters":{
                                "values": [
                                    "1234567891234",
                                    "1234567891235",
                                    "1234567891236"
                                ]
                            }
                        }
                    }
                }
            }
        }
    }
```

## License

This module is released under the MIT license. See the complete license in the
module:

    Resources/meta/LICENSE