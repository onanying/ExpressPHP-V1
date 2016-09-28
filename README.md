# TinyPHP-framework

⚡ 一个框架，路由足以，其他的都可以自己去高效的实现；于是我写了这个超轻量级的php框架；

- 完全参考了CodeIgniter的设计思想，使用方法也与之完全一样，无需重新学习。
- 只实现了基本的路由功能：根据url实例化Controller，并调用方法。 

## cli 模式

```
php index.php Welcome index
```

## FastCGI 模式

```
// 未加url重写
http://www.test.com/index.php/welcome/index

// 开启apache的rewrite后
http://www.test.com/welcome/index
```
