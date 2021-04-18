

## Commands

### wp-clone

To clone site

example 

```shell
wp-clone \
	--verbose \
	--source https://blog.elbaan.com \
	--source-type wp \
	--dist local://blog.elbaan.com \
```

### 


## Install from local folder

TO install and access commandlines from local folder, create a composer.json file in ~/.config/composer 
and write following config:

```json
{
    "require": {
        "mostafabarmshory/wp": "@dev"
    },
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/mostafabarmshory/wp"
        }
    ]
}
```

Must change the "/path/to/mostafabarmshory/wp" path to yours.

Then install/update the global:

```shell
composer global install
```

Or

```shell
composer global update
```

Now add the following path into your $PATH:

```
~/.config/composer/vendor/bin
```

Now all commands can be accessed from terminal