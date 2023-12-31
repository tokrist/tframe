# Table of contents

1. [Meet Tframe](#meet-tframe)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Support](#support)
5. [Updates](#updates)

## Meet Tframe

Tframe is a web application framework, for making your life simple and easy. **Please note**, that it is still in
progress. Tframe is based on `PHP` and `MySQL` or `PostgreSQL` (it uses PDO). It is free to use for any project you
want.

## Installation

To install Tframe just download the source zip, extract, and it is ready to use. Please refer
to [configuration](#configuration) before using it. In `/sql/base.sql` you find the basic SQL commands you need to run.
There is a pre-configured account `Superadmin`.

> [!IMPORTANT]
> The email for login is `admin@example.com` with the password of `Superadmin1*`

## Configuration

Under `/common/config` you will find a `.env.example` file. Rename ti to just `.env`, and fill the fields in it.
For the `_URL` paths include `http://` or `https://` otherwise your app could crash. For the pages root set the `/web`
folder under admin/public/api.

> [!CAUTION]
> Your app won't work until you set up the API. It is used for the DataTables queries, so it will report a problem
> unless you install the api correctly.

> [!TIP]
> Look into the `aliases.php` and `globals.php` files too and modify/add variables you like.

## Support

| Version | PHP |      Release      |      Support       |
|:-------:|:---:|:-----------------:|:------------------:|
|  v1.0   | 8.3 | 04th January 2024 | :white_check_mark: |
|  v1.1   |  -  |    in progress    |        TBA         |

## Updates

- [ ] https://github.com/tokrist/tframe/issues/1