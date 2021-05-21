

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


## Run with docker

Here is an example:

```bash
docker run --rm -it -v ${PWD}:/root/wp 4a520d073035 \
	wp-setProperty --source local://test.com --key test --value xxx
```

/


```bash
docker run --rm -it -v ${PWD}:/root/wp mostafabarmshory/wp \
 wp-clone --source https://blog.elbaan.com --source-type wp --dist local://blog.elbaan.com
```

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



# examples


wp-clean \
	--verbose \
	--source local://blog.elbaan.com
	
	wp-clone \
	--verbose \
	--source https://blog.elbaan.com \
	--source-type wp \
	--dist local://blog.elbaan.com 
	
	
	
	wp-clone \
	--verbose \
	--source https://blog.nobitex.ir \
	--source-type wp \
	--dist local://blog.nobitex.ir
	
	
	wp-clone \
	--verbose \
	--source https://arzdigital.com \
	--source-type wp \
	--dist local://arzdigital.com
	
	
	wp-removeStyle  --source local://arzdigital.com

	
	
wp-upload \
 --verbose \
 --source local://test.com \
 --dist https://test.viraweb123.ir \
 --dist-type std \
 --dist-login admin \
 --dist-pass admin
	
wp-setProperty \
	--verbose \
	--source local://test.com \
	--key state \
	--value init
	
wp-update \
 --verbose \
 --source local://test.com \
 --canonical-link-prefix "/blog/posts" \
 --update-language fa \
 --update-template "/api/v2/cms/contents/blog-post-template/content#main-body"
	
	