## About Project

基于Laravel 8.83.6 实现的只有2个角色的权限管理

通过`user_role`表记录`user`与`role`的对应关系，`role`记录角色信息，`users`记录用户信息

在`checkLogin`这个`middleware`里实现判断登录；`AppServiceProvider`里定义权限，在具体用到的地方根据`Gate`去判断是否有权限

2022-04-20 12:44:34