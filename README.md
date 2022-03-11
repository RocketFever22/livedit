# Livedit
A simple Laravel 5 package that offers a standarized way to query for resource usage.
Ideal for not intensive and not-so-real time resource tracking.

## Package requirements
This is a [Laravel 5](https://laravel.com/docs/5.3/installation) package. Go through it's documentation for more information.

## Installing & setting up

+ `$ composer requrie ricardotano/livedit`
+ Add `Ricks\livedit\LiveditServiceProvider::class,` to your `config/app.php` Service providers array.
+ `$ php artisan vendor:publish`
+ Optional: Update `/config/livedit.php` file to set your own migration parameters or let it as is.
+ `$ php artisan migrate`

## How does it work
#### Routes

`GET livedit/ask/{resource_type}`

This route returns a list of ids using the specified resource in the last minute

`POST livedit/publish`

This route is used to add a resource usage. The record will be removed after a minute (or the time in seconds you configured into `config/livedit.php` file) to keep the table short.

#### Example

Publish a new resource usage.
`resource_name` is the name of the resource you want to track, it can be changed in `config/livedit.php` file. 

```
$.post('livedit/publish', {
   resource_name : string_resource_name,
   resource_id : int_resource_id
})
.then(handleSuccess, handleError);
```

Get a list of resources for the past minute, for a given `resource_name`

```
$.get('livedit/ask/resource_name')
.then(handleSuccess, handleError);
```

## The big elephant in the room
Yes, you can use web scokets for a more fancy and usefull tracking, but sometimes you need someting that will be used in just one place and setting up a socket solution is killing a mosquito with a cannon.

## Last words
Thanks for reading this and please, remember I created this for everyone, so everyone is welcome to add support or new features.


