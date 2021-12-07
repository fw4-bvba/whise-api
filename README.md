# Whise API

PHP client for the [Whise](https://www.whise.eu) API. For terms of use and API credentials, refer to the official
documentation.

## Installation

`composer require fw4/whise-api`

## Usage

```php
use Whise\Api\WhiseApi;

$api = new WhiseApi();

// Retrieve existing access token from storage (getAccessTokenFromDataStore to be implemented)
$accessToken = getAccessTokenFromDataStore();

if (!$accessToken) {
    // Request and store new access token (saveAccessTokenToDataStore to be implemented)
    $accessToken = $api->requestAccessToken('username', 'password');
    saveAccessTokenToDataStore($accessToken);
}

$api->setAccessToken($accessToken);
```

All endpoints are provided as methods of the WhiseApi class. For more information about available endpoints and
response format, refer to the official API documentation.

### Available endpoints

Use the following methods to access available endpoints:

#### Administration

```php
$api->admin()->clients()->list($parameters);
$api->admin()->clients()->settings($parameters);
$api->admin()->clients()->token($parameters);
$api->admin()->offices()->list($parameters);
$api->admin()->representatives()->list($parameters);
```

#### Estates

```php
$api->estates()->list($filter, $sorting, $fields);
$api->estates()->get($id, $filter, $fields);
$api->estates()->update($parameters);
$api->estates()->create($parameters);
$api->estates()->delete($id);
$api->estates()->regions()->list($parameters);
$api->estates()->usedCities()->list($filter);
$api->estates()->pictures()->upload($estate_id, $file);
$api->estates()->pictures()->delete($estate_id, $picture_id);
$api->estates()->documents()->upload($estate_id, $file);
$api->estates()->documents()->delete($estate_id, $document_id);
$api->estates()->exports()->list($office_id, $parameters);
$api->estates()->exports()->changeStatus($estate_id, $export_status, $id_in_media, $export_message);
$api->estates()->owned()->list($username, $password, $filter, $sorting, $fields);
```

#### Contacts

```php
$api->contacts()->list($filter, $sorting, $fields);
$api->contacts()->get($id, $filter, $fields);
$api->contacts()->update($parameters);
$api->contacts()->create($parameters);
$api->contacts()->upsert($parameters);
$api->contacts()->delete($id);
$api->contacts()->origins()->list($parameters);
$api->contacts()->titles()->list($parameters);
$api->contacts()->types()->list($parameters);
```

#### Calendars

```php
$api->calendars()->list($filter, $sorting, $fields, $aggregation);
$api->calendars()->create($parameters);
$api->calendars()->delete($id);
$api->calendars()->update($parameters);
$api->calendars()->actions()->list($parameters);
```

#### Activity

```php
$api->activities()->calendars($filter, $aggregation);
$api->activities()->histories($filter, $aggregation);
$api->activities()->audits($filter, $aggregation);
$api->activities()->historyExports($filter, $aggregation);
```

### Pagination

Endpoints that retrieve multiple items return a traversable list of objects. Pagination for large lists happens
automatically.

```php
$estates = $api->estates()->list();

// Traversing over the response takes care of pagination in the background
foreach ($estates as $estate) {
    echo $estate->name . PHP_EOL;
}
```

### Manual pagination

For situations where manual pagination is required, a `page` method is provided. Calling this method with both a
desired page index (starting at 0), and the amount of items to retrieve per page, returns a traversable list of
objects. This list also provides multiple methods for dealing with paging metadata:

- `getPage()` to retrieve the current page index (starting at 0).
- `getPageSize()` to retrieve the maximum amount of items per page.
- `count()` to retrieve the actual amount of items on the current page.
- `getTotalCount()` to retrieve the total amount of items across all pages. This method is currently not available on
`activities` endpoints.
- `getPageCount()` to retrieve the total amount of pages. This method is currently not available on
`activities` endpoints.

#### Example

```php
$page_index = 2;
$items_per_page = 20;

$estates = $api->estates()->list([
    'CategoryIds' => [1]
]);
$page = $estates->page($page_index, $items_per_page);

echo 'Showing ' . $page->count() . ' items out of ' . $page->getTotalCount() . PHP_EOL;
echo 'Page ' . ($page->getPage() + 1) . ' of ' . $page->getPageCount() . PHP_EOL;
foreach ($page as $estate) {
    echo $estate->name . PHP_EOL;
}
```

### Caching

It's possible to enable caching by using a [PSR-6 compatible cache adapter](https://www.php-fig.org/psr/psr-6/). Do
note that this will cause all read operations to be cached, overriding any cache-control policy used by the Whise API,
violating RFC.

```php
use Cache\Adapter\Redis\RedisCachePool;

$redis = new \Redis();
$redis->connect('127.0.0.1', 6379);
$cache = new RedisCachePool($redis);

$api = new Whise\Api\WhiseApi($access_token);
$api->setCache($cache);
```

You can change the default cache lifetime of one hour, as well as the cache key prefix, by using the second and third
parameters of `setCache` respectively. These can also be changed at runtime by using the `setCacheTtl` and
`setCachePrefix` methods.

Responses are cached per access token, so make sure to reuse your access token to share a cache across script
executions.

To determine whether a response was returned from cache, call the `isCacheHit` method. This method is not available
when using automatic pagination.

```php
$estate = $api->estates()->get(1);
if ($estate->isCacheHit()) {
    echo 'Response fetched from cache' . PHP_EOL;
} else {
    echo 'Response fetched from API' . PHP_EOL;
}
```

## License

`fw4/whise-api` is licensed under the MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
