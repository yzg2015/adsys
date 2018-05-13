# The ThinkPHP5 Image Package

[![Build Status](http://img.shields.io/travis/top-think/think-image.svg)](http://travis-ci.org/top-think/think-image)
[![Coverage Status](http://img.shields.io/codecov/c/github/top-think/think-image.svg)](http://codecov.io/github/top-think/think-image)
[![Downloads](http://img.shields.io/github/downloads/top-think/think-image/total.svg)](http://github.com/top-think/think-image/releases)
[![Releases](http://img.shields.io/github/release/top-think/think-image.svg)](http://github.com/top-think/think-image/releases/latest)
[![Releases Downloads](http://img.shields.io/github/downloads/top-think/think-image/latest/total.svg)](http://github.com/top-think/think-image/releases/latest)
[![Packagist Status](http://img.shields.io/packagist/v/top-think/think-image.svg)](http://packagist.org/packages/topthink/think-image)
[![Packagist Downloads](http://img.shields.io/packagist/dt/top-think/think-image.svg)](http://packagist.org/packages/topthink/think-image)

## 安装

> composer require topthink/think-image

## 使用

~~~
$image = \think\Image::open('./image.jpg');
或者
$image = \think\Image::open(request()->file('image'));


$image->crop(...)
    ->thumb(...)
    ->water(...)
    ->text(....)
    ->save(..);

~~~