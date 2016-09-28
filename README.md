# TinyPHP-framework

超轻量级php框架，框架核心只有4个文件（2个类文件、1个函数文件、1个入口文件），参考了CodeIgniter/ThinkPHP两个框架的实现方式；本框架没有封装任何快速开发的工具类，只实现了简易路由、MVC架构、单例模式、资源载入，更加适合cli模式的程序开发；CodeIgniter的用户能立即上手，想学习自己搭建框架的也可以参考。

## cli 模式

```
php index.php Welcome index
```

## FastCGI 模式

```
http://www.test.com/index.php/welcome/index
// 需要做url重写才能去掉 index.php
```
