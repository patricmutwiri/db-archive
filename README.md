# Archive

Archive database tables which have grown over time to different tables,time-suffixed, to free commonly-used tables of this dead weight.

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "patricmutwiri/archive": "dev-master"
    }
}
```

```bash 
$ composer update
```

## Usage

```php
$archive = new Patricmutwiri\Archive\Archive;
echo $archive->getDatabases();
// > db1, db2, db3 
```

## Licence

MIT

## 

~<a href="https://patric.xyz" title="Patrick Mutwiri" >Jibambe</a>