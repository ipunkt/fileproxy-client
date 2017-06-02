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

### Setting Credentials

Since version 1.1.0 the fileproxy has the ability to protect api calls with a secret token header. You can add that to the client like so
 
```php
$fileproxy->setCredentials('S3cr3T');
```
 
Or, you can configure another header name than the default one:
```php
$fileproxy->setCredentials('S3cr3T', 'X-ANOTHER-SECURITY-TOKEN-NAME');
```

### Setting Headers

Another security level can be added by adding custom http headers for each request. So your infrastructure can verify the request by parsing them. You can achieve this like so:

```php
$fileproxy->addHeader('X-HEADER', 'custom value');
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

#### Updating an uploaded file

```php
$reference = 'UUID-FROM-LOCAL-STORAGE';
$fileToUpload = new \SplFileInfo('/absolute/file/path.ext');

/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->update($reference, $fileToUpload);
```

`$file` is a File entity with the main information about the file itself - the reference.


#### Storing a remote file

```php
$url = 'https://domain.tld/images/picture.jpg';

/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->storeRemote($url);
```

`$file` is a File entity with the main information about the file itself - the reference.

#### Updating a stored remote file

```php
$reference = 'UUID-FROM-LOCAL-STORAGE';
$url = 'https://domain.tld/images/picture.jpg';

/** @var \Ipunkt\Fileproxy\Entities\File $file */
$file = $fileproxy->files()->updateRemote($reference, $url);
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
