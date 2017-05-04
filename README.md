# fileproxy-client

[![Latest Stable Version](https://poser.pugx.org/ipunkt/fileproxy-client/v/stable.svg)](https://packagist.org/packages/ipunkt/fileproxy-client) [![Latest Unstable Version](https://poser.pugx.org/ipunkt/fileproxy-client/v/unstable.svg)](https://packagist.org/packages/ipunkt/fileproxy-client) [![License](https://poser.pugx.org/ipunkt/fileproxy-client/license.svg)](https://packagist.org/packages/ipunkt/fileproxy-client) [![Total Downloads](https://poser.pugx.org/ipunkt/fileproxy-client/downloads.svg)](https://packagist.org/packages/ipunkt/fileproxy-client)

A client library for fileproxy

## Quickstart

```
composer require ipunkt/fileproxy-client
```

## Usage

Setting up our client.

```php
$client = new \Guzzle\Http\Client();

$fileproxy = new \Ipunkt\Fileproxy\FileproxyClient('https://file-proxy.app', $client);
```

### Files resource

Files resource handles all stuff with the related proxy files. These files are the source for the aliases provided by the service.

#### Uploading a new file

```php
$fileToUpload = new \SplFileInfo('/absolute/file/path.ext');

/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->store($fileToUpload);
```

`$file` is a File entity with the main information about the file itself - the reference.

#### Storing a remote file

```php
$url = 'https://domain.tld/images/picture.jpg';

/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->storeRemote($url);
```

`$file` is a File entity with the main information about the file itself - the reference.

#### Requesting a file by reference

```php
/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->get($reference);// $reference is a UUID4
```

`$file` is a File entity. You can fetch the hits from it for example.

### FileAlias resource

You can create or retrieve aliases with this resource.

#### Creating an alias

```php
/** @var \Ipunkt\Fileproxy\Entities\Alias $alias */
$alias = $fileproxy->fileAliases($reference /* only once needed */)->create('limited-file.jpg', 5 /* hits only */);// $reference is a UUID4
```
The created `$alias` will be returned and includes the download url and the alias id.

#### Fetching all aliases

```php
/** @var \Ipunkt\Fileproxy\Entities\Alias[]|array $aliases */
$aliases = $fileproxy->fileAliases($reference /* only once needed */)->all();// $reference is a UUID4
```
You can iterate over all existing `$aliases`.


### Alias resource

Alias resource handles requesting and deleting of aliases.

#### Requesting an alias

```php
/** @var \Ipunkt\Fileproxy\Entities\Alias $alias */
$alias = $fileproxy->alias()->get($aliasId);// $aliasId = "${reference}.${alias}"
```
`$alias` is an Alias entity. The main information about an alias is the download url and the hits and hits left statistics data.

#### Deleting an alias

```php
$fileproxy->alias()->delete($aliasId);// $aliasId = "${reference}.${alias}"
```

Alias was deleted when no exception was thrown.

### Statistics resource

#### Requesting statistics

```php
/** @var \Ipunkt\Fileproxy\Entities\Statistic $stats */
$stats = $fileproxy->statistics()->stats();
```

`$stats` returns the main statistics for the current service: size in bytes, file and alias count serving and hits summarized.
