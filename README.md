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

## Configs

```

DATABASES="db1"
TABLES="table1,table2,table3"
ARCHIVE_FROM="2015-12-31"   // Archive from which date
ARCHIVE_TO="2000-01-01"     // If this is empty, we'll archive all data from ARCHIVE_FROM.
DATE_COLUMN="datetimeadded,created_at,date_time_added" // the column to use as key for dates set in ARCHIVE_FROM and ARCHIVE_TO`

````

## Licence

MIT

## 

~<a href="https://patric.xyz" title="Patrick Mutwiri" >Jibambe</a>