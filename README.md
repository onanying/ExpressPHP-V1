# php-small-framework

轻量级php框架，框架的核心只有4个文件（2个类文件、1个函数文件、1个入口文件）；大量融合了CodeIgniter框架的优点，也扩展了一些ThinkPHP的优点，本框架没有封装任何快速开发的工具类，只是现实了MVC架构与单例模式，更好适合cli模式的程序开发；CodeIgniter的用户能立即上手，想学习自己搭建框架的也可以参考。

## cli 模式

```
php index.php Welcome index
```

## FastCGI 模式

```
http://www.test.com/index.php/welcome/index
// 需要做url重写才能去掉 index.php
```
