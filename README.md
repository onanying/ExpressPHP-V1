# TinyPHP

一个框架，路由足以，其他都可以自己去高效的实现；于是我参考了CodeIgniter的设计思想写了这个超轻量级的php框架；

    设计思想：只搭建一个基本的MVC框架模型、简单的路由、接近原生的数据库类

- 多数使用方法与CodeIgniter完全一样，无需重新学习。
- 增加了命名空间，不用再为取类名费脑筋。
- 只有框架功能，其他library/helper你需要自己动手开发或直接从CI去Copy。
- db类有mysql/redis两个；其中mysql类为手写sql，当然我做了过滤来保证安全，使用起来也与CI的db类很相似。

## 相同之处

### 获取核心对象

```php
$instance = get_instance();
$instance->load->library('session');
```

### 加载资源

```php
// 加载模型
$this->load->model('model_name');
// 初始化类
$this->load->library('session');
// 加载视图
$this->load->view('name');
```

## 不同之处

### 加载资源后的对象访问

```php
// 模型的加载与访问
$this->load->model('model_name');

// 类的加载与访问
$this->load->library('session');
```

### 路由

URI中的倒数第二段为控制器类名，最后一段为控制器中的方法名

    // Welcome控制器
    http://www.test.com/index.php/控制器/方法名
    http://www.test.com/index.php/welcome/index
    // admin目录下的Welcome控制器
    http://www.test.com/index.php/目录/控制器/方法名
    http://www.test.com/index.php/admin/welcome/index

不支持URI段的传参

    // 会寻找 admin/welcome 目录下的 index 控制器
    // 所以这是错误的做法
    http://www.test.com/index.php/admin/welcome/index/123
