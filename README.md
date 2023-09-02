# API_Products_PHP_MVC
مشروع API مع نظام المصادقة  JWT .<br>
يتم تطبيق المشروع باستخدام نمط التصميم Model-View-Controller (MVC) ، الذي يسهل تنظيم وتطوير التطبيقات وجعلها قابلة للصيانة وقابلة للتوسع. <br>
يعتبر إنشاء API باستخدام PHP ونظام المصادقة JWT مشروعًا مثيرًا ومهمًا لتطوير تطبيقات الويب والهواتف المحمولة ، 
سيكون هذا المشروع قادرًا على تسجيل حسابات المستخدمين، وتسجيل دخولهم للحصول على رمز مميز  (Token)  للقيام بعمليات المصادقة الخاصة بالمستخدمين على الـ API ، 
سيمكن المستخدم أيضًا من إضافة أصناف ومنتجات بتفاصيل مفصلة وصور للمنتجات.
لتنفيذ هذا المشروع بشكل فعال، سنقوم باستخدام نمط البرمجة الكائنية (OOP) لتنظيم وإدارة الكود بشكل أفضل. 
## سنقوم بتقسيم المشروع إلى مكونات رئيسية تشمل:
#### التوثيق وإنشاء حسابات المستخدمين :
- إنشاء صفحة تسجيل حساب جديد حيث يمكن للمستخدمين إدخال معلوماتهم الشخصية. <br>
- تخزين معلومات المستخدمين في قاعدة البيانات مع تشفير كلمات المرور.
#### تسجيل الدخول وإنشاء JWT :
- إنشاء نظام تسجيل دخول يتحقق من صحة معلومات الاعتماد (ايميل المستخدم وكلمة المرور).
- إصدار رمز مميز (Token) باستخدام تقنية JWT بعد تحقق الهوية.
#### إدارة الأصناف والمنتجات :
- إنشاء نماذج للأصناف والمنتجات باستخدام OOP لتنظيم البيانات والتفاصيل.
- تنفيذ واجهات برمجة (API endpoints) لإضافة واستعراض الأصناف والمنتجات.
#### إضافة الصور:      	
- إمكانية إرفاق صورة واحدة أو صور متعددة للمنتجات.
- تخزين الصور في مكان آمن وإرجاع الروابط لها.
#### الأمان والمصادقة:
- استخدام JWT لتأمين جميع نقاط النهاية (endpoints) والتحقق من هوية المستخدم.
- تنفيذ أمان مناسب لمنع وصول غير المصرح به إلى البيانات.
#### إعداد بيئة التطوير والإنتاج:    
- تكوين قاعدة بيانات لتخزين المعلومات.
- إعداد الخوادم والبيئات اللازمة لتشغيل التطبيق في بيئة الإنتاج.
#### وثائق واجهة البرمجة  (API Documentation) :      	
- إعداد وثائق توضيحية لواجهة البرمجة لمساعدة المطورين على فهم كيفية استخدام المشروع.


هذا المشروع سيمكن المطورين من إنشاء تطبيقات متعددة المنصات (ويب وموبايل) التي تستخدم API لإدارة حسابات المستخدمين والأصناف والمنتجات بشكل آمن وفعال.       	


## Requirements
- OOP Concept
- Composer
- Include JWT
- MVC Pattern


## My Learned
| # | Code |
|---|------|
| 1 | `@` |
| 2 | `file_get_contents("php://input");` |  
| 3 | `$var = (condition) ? true code : flase code;`|
| 4 | `if(condition): // code else: //code endif;` |
| 5 | `(type) code` |
| 6 | `extract(array)` |
| 7 | `DIRECTORY_SPERATOR windows ( \ ) - Linux ( / )` |
| 8 | `define("name", value)` |
| 9 | `defined("xname") ? null : define("xname", value)` |
| 10 | `__get()` |
| 11 | `Autoload` |
| 12 | `Trait` |
| 13 | `Namespace` |
| 14 | `Anonymous function` |
| 15 | `Singleton Pattern` |
| 16 | `Single responsibility principle` |


## Explain Project
| # | Department | Method | Endpoint | Data Type | Data |
|---|------------|--------|----------|------------|-----|
| 1 | Register | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/register/create | Json - Return Json | { "name" : "HamedEid", "email" : "hamed62@gmail.com", "password" : "test_password"} |
| 2 | Login & Token | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/login/token | Json - Return Json | { "email" : "hamed62@gmail.com", "password" : "test_password" } | 
| 3 | Display All Category | GET | http://apiproducts-001-site1.gtempurl.com/api_products/public/category/default/ | Return Json |  |
| 4 | Display Category By ID | GET | http://apiproducts-001-site1.gtempurl.com/api_products/public/category/default/2 | Return Json | |
| 5 | Add Category | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/category/add | Json - Return Json | { "category_name" : "Laptop" } |
| 6 | Update Category By ID | PATCH | http://apiproducts-001-site1.gtempurl.com/api_products/public/category/update/2 | Json - Return Json | { "category_name" : "PC" } |
| 7 | Delete Category By ID | DELETE | http://apiproducts-001-site1.gtempurl.com/api_products/public/category/delete/2 | Return Json | |
| 8 | Display All Products | GET | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/default | Return Json | |
| 9 | Display Product By ID | GET | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/default/3 | Return Json | |
| 10 | Add Product | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/add | **POST_DATA** - Return Json | ( product_name, discount_percentage, price_before_discount, price_after_discount, description, category_id, detail_title OR detail_title[], detail_description OR detail_description[], img[] )|
| 11 | Update Product And Details Product By Product/Detail ID | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/update/4 | **POST_DATA** - Return Json | ( product_name, discount_percentage, price_before_discount, price_after_discount, description, category_id, detail_id OR detail_id[], detail_title OR detail_title[], detail_description OR detail_description[] ) |
| 12 | Update Image For Product By product_id And img_id | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/update/1/images/2 | **POST_DATA** - Return Json | ( img ) |
| 13 | Update Detail For Product By product_id And detail_id | POST | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/update/1/details/1 | **POST_DATA** - Return Json | ( detail_title, detail_description ) |
| 14 | Delete Product By ID | DELETE | http://apiproducts-001-site1.gtempurl.com/api_products/public/product/delete/1 | Return Json | |


## My Mistakes
طبعا انا بذكر الاخطاء اللى واجهتها فى عمل المشروع منها يستفيد الشخص اللى هايستخدم نفس المشروع و منها انا عملت Search على الاخطاء اللى قبلتها عشان اطلع من المشروع ده بأكبر استفادة و مكررش نفس الاخطاء فى المشروع القادم .<br>
اعتبر الأخطاء اللى انا وقعت فيها دى Task ليك انك تفهم المشروع وتقدر تعدل عليه انا بالطبع عرفت حلول الأخطاء . 
- استخدام Method POST بدلا من Method PATCH او Method PUT فى تعديل المنتجات Update Products واختلاف استلام البيانات بعد ما كنت هاستم بيانات Json و اعملها Encode دلوقتى بقيت استخدم POST Inputs طبعا عمليا الكود شغال مافيهوش اى مشكلة خالص لكن علميا الواحد يستخدم الكود الصحيح افضل
- عدم استخدام Throwable للتحكم فى الاخطاء الناتجة من API
- استخدام متغيرات فى بعض الاماكن وقيمتها فارغة حتى لو كنت متحقق انها موجودة و لا تساوى قيمة فارغة كان ديما بيطلع خطأ بسبب ان قيمة متغير فارغة او لم يتم التعرف على قيمته وليكن مثلا ك undefine array ... و هكذا
- ماتحققتش من المدخلات كام حرف مطلوب عشان اتخذ الاجراء المناسب ..... الخ **(فى المنتجات)** لكن معمول Validation على ال Data اللى بستقبلها من المستخدم فى كامل المشروع .


## Screen Shot
Index - Default Page


![Index Page](http://apiproducts-001-site1.gtempurl.com/api_products/src_files/api_images/1-Home.png)


**More Images For Screen Shot, Visit [Drive]**(https://drive.google.com/drive/folders/14UwBvoEAWU5KhJBt8BzEs-LHqeNAz8cA?usp=drive_link)


## Database

![ERD_Database](https://github.com/hamedeid20/API_Products_PHP_MVC/blob/master/api_products/src_files/ERD_api_product.png)
![RS_Database](https://github.com/hamedeid20/API_Products_PHP_MVC/blob/master/api_products/src_files/RS_api_product.png)


## Resources
| # | Name | Link | 
|---|------|------|
| 1 | Playlist APIs | https://www.youtube.com/playlist?list=PLFbnPuoQkKsdvZW_zLex4O0tHa_NSKnbI |
| 2 | Course PHP ( Trait - Autoload - Namespace - OOP - MVC - & More... I Recomented This Course ) | https://www.youtube.com/playlist?list=PLrwRNJX9gLs3kkSDgCHFlpgL6qLrlHUBG |
| 3 | HTTP response status codes | https://developer.mozilla.org/en-US/docs/Web/HTTP/Status |
| 4 | SOLID Principles | https://www.youtube.com/playlist?list=PLrwRNJX9gLs3ZtZgJtw5k15CDobtfSNQt | 
| 5 | Android Developer - I recomented posts published from Eslam Mohsen (POSTS => OOP - SOLID Principles - Design Pattern - & More... )| https://www.linkedin.com/in/eslammohs7n/
| 6 | Android Developer - I recomented posts published from Ahmed Samir Elsaka (POSTS => Design Pattern - Data Structure - & More... ) | https://www.linkedin.com/in/devahmedsamir/









