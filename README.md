# API_Products_PHP_MVC
مشروع API باستخدام PHP MVC مع نظام المصادقة  JWT .
يعتبر إنشاء API باستخدام PHP ونظام المصادقة JWT مشروعًا مثيرًا ومهمًا لتطوير تطبيقات الويب والهواتف المحمولة. 
سيكون هذا المشروع قادرًا على تسجيل حسابات المستخدمين، وتسجيل دخولهم للحصول على رمز مميز  (Token)  للقيام بعمليات المصادقة الخاصة بالمستخدمين على الـ API .
سيمكن المستخدم أيضًا من إضافة أصناف ومنتجات بتفاصيل مفصلة وصور للمنتجات.
لتنفيذ هذا المشروع بشكل فعال، سنقوم باستخدام نمط البرمجة الكائنية (OOP) لتنظيم وإدارة الكود بشكل أفضل. 
## سنقوم بتقسيم المشروع إلى مكونات رئيسية تشمل:
  # التوثيق وإنشاء حسابات المستخدمين:
    -	إنشاء صفحة تسجيل حساب جديد حيث يمكن للمستخدمين إدخال معلوماتهم الشخصية.
    - تخزين معلومات المستخدمين في قاعدة البيانات مع تشفير كلمات المرور.
  # تسجيل الدخول وإنشاء JWT :
    - إنشاء نظام تسجيل دخول يتحقق من صحة معلومات الاعتماد (ايميل المستخدم وكلمة المرور).
    - إصدار رمز مميز (Token) باستخدام تقنية JWT بعد تحقق الهوية.
  # إدارة الأصناف والمنتجات:
    - إنشاء نماذج للأصناف والمنتجات باستخدام OOP لتنظيم البيانات والتفاصيل.
    - تنفيذ واجهات برمجة (API endpoints) لإضافة واستعراض الأصناف والمنتجات.
  # إضافة الصور:      	
    - إمكانية إرفاق صورة واحدة أو صور متعددة للمنتجات.
    - تخزين الصور في مكان آمن وإرجاع الروابط لها.
  # الأمان والمصادقة:
    - استخدام JWT لتأمين جميع نقاط النهاية (endpoints) والتحقق من هوية المستخدم.
    - تنفيذ أمان مناسب لمنع وصول غير المصرح به إلى البيانات.
  # إعداد بيئة التطوير والإنتاج:    
    - تكوين قاعدة بيانات لتخزين المعلومات.
    - إعداد الخوادم والبيئات اللازمة لتشغيل التطبيق في بيئة الإنتاج.
  # وثائق واجهة البرمجة  (API Documentation) :      	
    - إعداد وثائق توضيحية لواجهة البرمجة لمساعدة المطورين على فهم كيفية استخدام المشروع.
هذا المشروع سيمكن المطورين من إنشاء تطبيقات متعددة المنصات (ويب وموبايل) التي تستخدم API لإدارة حسابات المستخدمين والأصناف والمنتجات بشكل آمن وفعال.       	



















