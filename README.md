#LibrarySystemForSISE

　　这是 2016 年广大华软学院某专业下的项目实训 **图书馆新生入馆教育与考核系统** 的简化版系统实现源码

---
　　系统采用 Yii 2.0 框架进行开发，[完整版](https://classtest.yumisakura.cn)使用到了 SMTP、PHPExcel、UEditor、ECharts 四个第三方插件(简化版里面全部被移除了，如有需要请邮件联系 **isakura@yumisakura.cn**)
  
>使用说明：
>项目拷贝到本地后，需要先用 /config 下的 libsys.sql 创建本地数据库，然后将同一目录下的 db_default.php 拷贝一份命名为 db.php，同时修改里面对应的设置。