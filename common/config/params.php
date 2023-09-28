<?php

// this contains the application parameters that can be maintained via GUI
return array(
    'tables' => array(
        'edu_course_activities_relation' => 'edu_course_activities_relation',
        'user' => 'users',
        'useradmin' => 'users_admin',
        'site' => 'sites',
        'site_introduce' => 'site_introduces',
        'domain' => 'domains',
        'category' => 'categories',
        'newcategory' => 'news_categories',
        'news' => 'news',
        'album' => 'albums',
        'image' => 'images',
        'video' => 'videos',
        'videos_categories' => 'videos_categories',
        'menu' => 'menus',
        'menu_admin' => 'menus_admin',
        'menu_group' => 'menu_groups',
        'categorypage' => 'categorypage',
        'widget' => 'widgets',
        'pagewidget' => 'page_widgets',
        'pagewidgetorder' => 'page_widget_order',
        'pagewidgetconfig' => 'page_widget_config',
        'banner' => 'banners',
        'banner_group' => 'banner_groups',
        'product' => 'product',
        'productcategory' => 'product_categories',
        'productimage' => 'product_images',
        'form' => 'forms',
        'formfield' => 'form_fields',
        'formsession' => 'form_sessions',
        'formfieldvalue' => 'form_field_values',
        'folder' => 'folders', // Quản lý folder
        'file' => 'files', // quản lý file
        'order' => 'orders', // Đơn hàng
        'orderproduct' => 'order_products',
        'theme' => 'themes',
        'themecategory' => 'theme_categories',
        'themeimage' => 'theme_images',
        'post' => 'posts', // bài viết
        'postcategory' => 'post_categories', // Danh mục bài biết
        'job' => 'jobs', // Tin tuyển dụng
        'trade' => 'trades', // Bảng loại nghề nghiệp
        'map' => 'maps',
        'productgroups' => 'product_groups',
        'tour_groups' => 'tour_groups',
        'tour_to_groups' => 'tour_to_groups',
        'product_to_group' => 'product_to_groups',
        'product_relation' => 'product_relation',
        'product_to_promotion' => 'product_to_promotions',
        'promotion' => 'promotions',
        'productinfo' => 'product_info',
        'product_attribute_set' => 'product_attribute_set',
        'product_attribute' => 'product_attribute',
        'product_attribute_option' => 'product_attribute_option',
        'product_attribute_option_index' => 'product_attribute_option_index',
        'product_tab' => 'product_tab_content',
        'site_support' => 'site_support',
        'product_configurable' => 'product_configurable',
        'product_configurable_value' => 'product_configurable_value',
        'manufacturers' => 'manufacturers',
        'manufacturer_info' => 'manufacturer_info',
        'edu_course' => 'edu_course',
        'edu_course_categories' => 'edu_course_categories',
        'edu_course_info' => 'edu_course_info',
        'albums_categories' => 'albums_categories', // Danh muc album
        'edu_course_images' => 'edu_course_images',
        'edu_course_schedule' => 'edu_course_schedule',
        'edu_course_register' => 'edu_course_register',
        'edu_course_shift' => 'edu_course_shift',
        'edu_lecturer' => 'edu_lecturer',
        'real_estate_consultant' => 'real_estate_consultant',
        'real_estate_video_relation' => 'real_estate_video_relation',
        'edu_rel_course_lecturer' => 'edu_rel_course_lecturer',
        'site_users' => 'site_users',
        'banner_partial' => 'banner_partial',
        'product_configurable_images' => 'product_configurable_images',
        'real_estate' => 'real_estate',
        'real_estate_categories' => 'real_estate_categories',
        'real_estate_news' => 'real_estate_news',
        'real_estate_project' => 'real_estate_project',
        'real_estate_project_info' => 'real_estate_project_info',
        'real_estate_project_register' => 'real_estate_project_register',
        'real_estate_images' => 'real_estate_images',
        'car' => 'car',
        'car_categories' => 'car_categories',
        'car_form' => 'car_form',
        'car_images' => 'car_images',
        'car_images_panorama' => 'car_images_panorama',
        'car_info' => 'car_info',
        'car_panorama_options' => 'car_panorama_options',
        'car_receipt_fee' => 'car_receipt_fee',
        'car_versions' => 'car_versions',
        'tour' => 'tour',
        'tour_categories' => 'tour_categories',
        'tour_comforts' => 'tour_comforts',
        'tour_hotel' => 'tour_hotel',
        'tour_hotel_group' => 'tour_hotel_group',
        'tour_hotel_images' => 'tour_hotel_images',
        'tour_hotel_info' => 'tour_hotel_info',
        'tour_hotel_room' => 'tour_hotel_room',
        'tour_hotel_room_images' => 'tour_hotel_room_images',
        'tour_images' => 'tour_images',
        'tour_info' => 'tour_info',
        'tour_season' => 'tour_season',
        'tour_style' => 'tour_style',
        'tour_hotels_list' => 'tour_hotels_list',
        'tour_partners' => 'tour_partners',
        'tour_province_info' => 'tour_province_info',
        'tour_tourist_destinations' => 'tour_tourist_destinations',
        'tour_booking' => 'tour_booking',
        'tour_booking_room' => 'tour_booking_room',
        'tour_booking_tour' => 'tour_booking_tour',
        'categorypage_images' => 'categorypage_images',
        'news_images' => 'news_images',
        'shop' => 'shop',
        'shop_images' => 'shop_images',
        'shop_product_category' => 'shop_product_category',
        'shop_store' => 'shop_store',
        'product_rel_shop' => 'product_rel_shop',
        'product_rating' => 'product_rating',
        'product_rating_detail' => 'product_rating_detail',
        'product_news_relation' => 'product_news_relation',
        'product_categories_banner' => 'product_categories_banner',
        'eve_event_news_relation' => 'eve_event_news_relation',
        'eve_event_register' => 'eve_event_register',
        'eve_event_video_relation' => 'eve_event_video_relation',
        'eve_events' => 'eve_events',
        'eve_event_categories' => 'eve_event_categories',
        'eve_event_file_relation' => 'eve_event_file_relation',
        'eve_event_info' => 'eve_event_info',
        'bds_project_config_consultant_relation' => 'bds_project_config_consultant_relation',
        'bds_project_config' => 'bds_project_config',
        'bds_project_config_images' => 'bds_project_config_images',
        'real_estate_consultant' => 'real_estate_consultant',
        'bds_project_config_images' => 'bds_project_config_images',
        'job_apply' => 'job_apply',
        'job_apply_files' => 'job_apply_files',
        'job_apply_work_history' => 'job_apply_work_history',
        'user_job_history' => 'user_job_history',
        'user_job_info' => 'user_job_info',
        'se_categories' => 'se_categories', // service categoies
        'se_services' => 'se_services', // service
        'se_daysoff' => 'se_daysoff', // dayoff
        'se_provider_schedule_breaks' => 'se_provider_schedule_breaks',
        'se_provider_schedules' => 'se_provider_schedules',
        'se_provider_services' => 'se_provider_services',
        'se_providers' => 'se_providers', // Providers
        'se_providers_info' => 'se_providers_info',
        'se_services_info' => 'se_services_info',
        'product_warranties' => 'product_warranties',
        'gift_card' => 'gift_card',
        'brand' => 'brand',
        'edu_course_video_relation' => 'edu_course_video_relation',
        'edu_course_news_relation' => 'edu_course_news_relation',
        'videos_product_rel' => 'videos_product_rel',
        'tour_news_relation' => 'tour_news_relation',
    ),
    'languages' => array(
        'vi' => 'Vietnamese',
        'en' => 'English',
        'jp' => 'Japanese',
        'cn' => 'China',
        'kr' => 'Korean',
    ),
    'defaultPageSize' => 10,
    'pageSizeName' => 'pageSize',
    'ipssystem' => array('112.213.87.152','127.0.0.1','112.213.88.197',),
    'privateKey' => 'web3nhatpro',
    'defaultEmail' => 'support@nanoweb.vn',
    'webRoot' => dirname(dirname(dirname(__FILE__))),
    'htdocs' => dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))),
    'server_ip' => array(
        '112.213.87.152',
        '112.213.88.197',
        '35.166.150.10',
        '172.31.21.119',
        '127.0.0.1',
    ),
    'cachePage' => false,
    'baokim' => array(
        'host' => 'https://www.baokim.vn',
        'link_get_account_info' => '/accounts/rest/sso_oauth_api/get_account_info/',
        'link_get_info' => '/payment/rest/payment_pro_api/get_seller_info',
        'link_pay_card' => '/payment/rest/payment_pro_api/pay_by_card',
        'link_pay_acc' => '/payment/rest/payment_pro_api/pay_by_account',
        'link_verify_otp' => '/payment/rest/payment_pro_api/verify_by_otp',
        'link_payment' => '/payment/order/version11',
        'url_verify' => '/bpn/verify',
        'url_pay_via' => '/accounts/login',
        'api_user' => 'web3nhat',
        'api_password' => 'G6eqjZW13s6h4ID7lBV77nUpxaS17',
        'merchan_id' => 18665,
        'secure_pass' => 'e12a2155de216895',
        'email_bussiness' => 'qtuan85@gmail.com',
        'pri_key' => "-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAwhOFHBXozntunTnfkgXU/UUZQTeT1m3fgX7hBtop6MAmYmoQ
aTGs9kRO+LBNSKc4hzAHB1Ju5JHIG1MkTfQQRP2DaUIcMG/oOSXxSnqqW5Jj7F/P
/vJcI97i0/CbnLJ/l8XvRFukNU7csS27HOS1vBh+v9l+Qrv2Tq1RuVmBiTvyI4C9
294zLgVAJtlk+VZc0BjI/7bBX5ZuwLSyjxVtphWKwq6lupG/QrGuCx2vjE2yjA1T
CiCtU9sfmZPeJJc4IllSu8xxY2BCR2Ohw4ynyuRg+Z3991C+1fPb9gx96C1YrqOy
w4k6Rah+nkAtOYXyJ+sSC6RZX6Oicj0qCybVxwIDAQABAoIBAA+HeFMy/ZnoDoXO
J7GLfet2J/sr80xpJkU6Xc8qjcft+CRP0FhafTiHZrpHgSebGc7XbPiNBAqOD7EA
Chuit9qNXoKBo7fMfIx2GMSY5CDHqe80C3Se9/h20TecPRdgwQzn7alOm+kYElir
DBnXwyL14s5/HLdCSwcony1xmAfe/Ggb2bNYKoTY/4WXxKZFNM4n2Wxqih6BZJTA
7e+Tk1pgJ744JEpvIruio3sWNl6jeYFPkUf+Vs8z/9hsFNhFNAwFPhU6pzMqm6FI
fAC3Du58n2MwTzeaNFtCg5DZJ0WeJG1E+FqSpka2x9lIhCPORc4rzDCCHmNL9kO/
u+GkDaECgYEA4md31MKQGMUZQwAeK0GySTkfSeQ8dFNyZtII98ssWvh2O9cTS6oS
i/M6ILwdg4r6tRgQiy+BZ4d4i21xm78gErKQ+1WC2fGNBRXHROQ3nnZpYytBfgBN
b2DREQgs04G1wnCEfUQM/hC19VcZuBR98iPBH6PtNv43EcP5B2YKHQ0CgYEA23I1
vAfVubOJ8eT1sn2ODlk8sLFyj8dt40/XiMBSYEz8vVPjFsP6jfnfFrHrmOy7D/co
MxQ+3gjIKoKkcXB+8QtZtygnye5R1VCnPDQgIqPIOidraxNB/otBs+sa06mSPTpX
9BrGM4xgizo+mgj9YHVXuGUQbUuiYjhrmRtzESMCgYAJn+BmOQcrJmXWhVDDAf30
QutjlsJDJ7D7Uf5zmj1+eIV+MbxuQQKc1HAqKBURHH1f6W/6msBjiEzFkJd9yXgx
k0m6hX4UicI27yATe6gpolsEjjgwhQ7Fp1X75V8SdrclVucq9BOhUVCK53L+clCQ
VJjHIY7aAaCRrsUNXXccmQKBgC4mw+RKpYlLmAxWgdHLFBAydlAW0agpYhP3W7X3
9JsqNdE/jjfgeZZYYbGtM4ZS6zh9W2f6rwoVQLuoBBuTdC8PmwupF00hoPZC4xkH
QWbnmRmZ5r57K1r0QJotLNQtCoNz/MFqzBpVQIyncDkHAPrDUvKF1sGVsY4EnaRy
oG2PAoGBAKNER1Ego/pQk8mVOd1PT5X1zNSCHdgzzJ1iLwiHgT9ibSQQvl2CVStp
/yM00lSbHQghhNCz9tnWrHwTcxO1aUJCjqN9SemYN+taYePjjdcs/pao/5YViEvi
WAPRyXzpDXeA2NGHXweEcKcGWU7PirUdavENSiuhPkwjB+p1ECk5
-----END RSA PRIVATE KEY-----
",
    ),
    'baokim_dev' => array(
        'host' => 'http://kiemthu.baokim.vn',
        'link_get_account_info' => '/accounts/rest/sso_oauth_api/get_account_info/',
        'link_get_info' => '/payment/rest/payment_pro_api/get_seller_info',
        'link_pay_card' => '/payment/rest/payment_pro_api/pay_by_card',
        'link_pay_acc' => '/payment/rest/payment_pro_api/pay_by_account',
        'link_verify_otp' => '/payment/rest/payment_pro_api/verify_by_otp',
        'link_payment' => '/payment/order/version11',
        'url_verify' => '/bpn/verify',
        'url_pay_via' => '/accounts/login',
        'api_user' => 'merchant',
        'api_password' => '1234',
        'merchan_id' => 647,
        'secure_pass' => 'ae543c080ad91c23',
        'email_bussiness' => 'dev.baokim@bk.vn',
        'pri_key' => "-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDZZBAIQz1UZtVm
p0Jwv0SnoIkGYdHUs7vzdfXYBs1wvznuLp/SfC/MHzHVQw7urN8qv+ZDxzTMgu2Q
3FhMOQ+LIoqYNnklm+5EFsE8hz01sZzg+uRBbyNEdcTa39I4X88OFr13KoJC6sBE
397+5HG1HPjip8a83v8G4/IPcna5/3ydVbJ9ZeMSUXP6ZyKAKay4M22/Wli7PLrm
1XNR9JgIuQLma74yCGkaXtCJQswjyYAmwDPpz4ZknSGuBYUmwaHMgrDOQsOXFW7/
7M2KbjenwggAW98f0f97AR2DEq9Eb5r8vzyHURnHGD3/noZxl993lM2foPI3SKBO
1KpSeXRzAgMBAAECggEANMINBgRTgQVH6xbSkAxLPCdAufTJeMZ56bcKB/h2qVMv
Wvejv/B1pSM489nHaPM5YeWam35f+PYZc5uWLkF23TxvyEsIEbGLHKktEmR73WkS
eqNI+/xd4cJ3GOtS2G2gEXpBVwdQ/657JPvz4YZNdjfmyxMOr02rNN/jIg6Uc8Tz
vbpGdtP49nhqcOUpbKEyUxdDo6TgLVgmLAKkGJVW40kwvU9hTTo6GXledLNtL2kD
l6gpVWAiT6xlTsD5m74YzsxCSjkh60NdYeUDYwMbv0WWH3kJq6qD063ac3i/i8H+
B5nGf4KbKg1bBjPLNymUj7RRnKjHr301i2u8LUQYuQKBgQD15YCoa5uHd6DHUXEK
kejU34Axznr3Gs6LqcisE7t0oQ9hB4s16U9f4DBHDOvnkLb0zkadwdEmwo/D/Tdf
5c/JEk8q/aO9Wk8uV4Bswnx1OV9uKMzMOZbv/So1DQg1aW1MgvRnj3SiKpDUkNwr
en4NT9tbH21SmVIO9Da5KpiFRwKBgQDiUrg1hp8EDaeZFTG9DvcwyTTrpD/YT9Wr
s/NtEnPMjy0NXWcEXwGzx90P+qjJ+J29Hk89QHON6S7o0X2lUIer3uXokc86ce76
5UIbR6u7R1T6TUNfwqwwNfIbgtFN4+7ybodPNZ5DWslKLqMr5wpwIOr7/U5ih7BH
JK0cSriddQKBgGXzNZiepOlRrBN3rMqZHFPGJrx/w3PYZXJ6fnz54WrFrD6qhglg
Jky2As4yiUyFL5XoQFcAGNtdJ4Y24lKcUb4oHTLR3qWPX+zy0ohFSpy/oNVnjSHP
bskpyeoc8R5UC8EBOpwFWnIx+8JmHSLZspGKXoQ1T3pDn0Yb8uRqyLnZAoGBAKdk
NwqfvwzobIU0v8ztPLbAmnuOyAndQlP0jJ6nfy5U1yWDZ6Y7/q5RrJcc9aosT76I
pGLRQKY9SYy5JQ0YOsBL5A/XiEXZ7r9ywSocIFAruhZG/wXcni4qOB9Q6i2J4Dk+
tqVHKv72LtrHE7hs8bNtJV+rQkZtxVtZLRA308PhAoGBALVEaYMRm97V+Tnsej6q
fuT/6oKHPqZpur2rNfEKVn5Aq2kmFrvyUhvXi0IAWQ/XS3XJ7faQnprrWT6pYiSy
2YQuaghlNG1SATVd5eUadq2pA8DuSzqWFa0Ac1IAyliBO2uLPL7LzuEKmmuQk0vI
TU2Q8idAb77K7mvVguA3LDhN
-----END PRIVATE KEY-----
",
    ),
    'trial_date' => 15,
	'sys_log' => false,
);

