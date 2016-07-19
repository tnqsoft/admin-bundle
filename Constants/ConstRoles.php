<?php

namespace TNQSoft\AdminBundle\Constants;

class ConstRoles
{
    //ROLE NAME CONSTANTS
    const ROLE_BANNER               = 'ROLE_BANNER';
    const ROLE_MENU                 = 'ROLE_MENU';
    const ROLE_PAGE                 = 'ROLE_PAGE';
    const ROLE_NEWS_CATEGORY        = 'ROLE_NEWS_CATEGORY';
    const ROLE_NEWS                 = 'ROLE_NEWS';
    const ROLE_PARTNER              = 'ROLE_PARTNER';
    const ROLE_PRODUCT_CATEGORY     = 'ROLE_PRODUCT_CATEGORY';
    const ROLE_PRODUCT              = 'ROLE_PRODUCT';
    const ROLE_SALE                 = 'ROLE_SALE';
    const ROLE_TESTIMONIAL          = 'ROLE_TESTIMONIAL';
    const ROLE_PHOTO                = 'ROLE_PHOTO';
    const ROLE_USER                 = 'ROLE_USER';

    //ACTIONS CONSTANTS
    const ACTION_LIST               = 'LIST';
    const ACTION_ADD                = 'ADD';
    const ACTION_EDIT               = 'EDIT';
    const ACTION_DELETE             = 'DELETE';
    const ACTION_ACTIVE             = 'ACTIVE';
    const ACTION_SETDEFAULT         = 'SETDEFAULT';
    const ACTION_EXPORT             = 'EXPORT';
    const ACTION_IMPORT             = 'IMPORT';
    const ACTION_UPDATE_PRICE       = 'UPDATE_PRICE';
    const ACTION_UPLOAD             = 'UPLOAD';
    const ACTION_CHANGEPASS         = 'CHANGEPASS';
    const ACTION_PROFILE            = 'PROFILE';
    const ACTION_SORT               = 'SORT';

    static public function getListRole()
    {
        return array(
            //User Management
            array(
                'title' => 'QL Người dùng',
                'description' => 'Quản lý Người dùng',
                'roles' => array(
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_CHANGEPASS,
                        'description' => 'Đổi Mật khẩu',
                    ),
                    array(
                        'name' => static::ROLE_USER.'_'.static::ACTION_PROFILE,
                        'description' => 'Cật nhật Hồ sơ',
                    ),
                ),
            ),
            //Banner Management
            array(
                'title' => 'QL Quảng cáo',
                'description' => 'Quản lý Quảng cáo',
                'roles' => array(
                    array(
                        'name' => static::ROLE_BANNER.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_BANNER.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_BANNER.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_BANNER.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Menu',
                'description' => 'Quản lý Menu',
                'roles' => array(
                    array(
                        'name' => static::ROLE_MENU.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_MENU.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_MENU.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_MENU.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                    array(
                        'name' => static::ROLE_MENU.'_'.static::ACTION_SORT,
                        'description' => 'Sắp xếp',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Trang tĩnh',
                'description' => 'Quản lý Trang tĩnh',
                'roles' => array(
                    array(
                        'name' => static::ROLE_PAGE.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_PAGE.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_PAGE.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_PAGE.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Danh mục tin',
                'description' => 'Quản lý Danh mục tin',
                'roles' => array(
                    array(
                        'name' => static::ROLE_NEWS_CATEGORY.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_NEWS_CATEGORY.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_NEWS_CATEGORY.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_NEWS_CATEGORY.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Tin tức',
                'description' => 'Quản lý Tin tức',
                'roles' => array(
                    array(
                        'name' => static::ROLE_NEWS.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_NEWS.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_NEWS.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_NEWS.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Đối tác',
                'description' => 'Quản lý Đối tác',
                'roles' => array(
                    array(
                        'name' => static::ROLE_PARTNER.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_PARTNER.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_PARTNER.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_PARTNER.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Danh mục sản phẩm',
                'description' => 'Quản lý Danh mục sản phẩm',
                'roles' => array(
                    array(
                        'name' => static::ROLE_PRODUCT_CATEGORY.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT_CATEGORY.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT_CATEGORY.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT_CATEGORY.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Sản phẩm',
                'description' => 'Quản lý Sản phẩm',
                'roles' => array(
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_EXPORT,
                        'description' => 'Xuất Excel',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_IMPORT,
                        'description' => 'Nhập Excel',
                    ),
                    array(
                        'name' => static::ROLE_PRODUCT.'_'.static::ACTION_UPDATE_PRICE,
                        'description' => 'Cập nhật giá',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Giảm giá',
                'description' => 'Quản lý Giảm giá',
                'roles' => array(
                    array(
                        'name' => static::ROLE_SALE.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_SALE.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_SALE.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_SALE.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            //Menu Management
            array(
                'title' => 'QL Ý kiến khách hàng',
                'description' => 'Quản lý Ý kiến khách hàng',
                'roles' => array(
                    array(
                        'name' => static::ROLE_TESTIMONIAL.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_TESTIMONIAL.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_TESTIMONIAL.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_TESTIMONIAL.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
            array(
                'title' => 'QL Album ảnh',
                'description' => 'Quản lý Album ảnh',
                'roles' => array(
                    array(
                        'name' => static::ROLE_PHOTO.'_'.static::ACTION_LIST,
                        'description' => 'Danh sách',
                    ),
                    array(
                        'name' => static::ROLE_PHOTO.'_'.static::ACTION_ADD,
                        'description' => 'Thêm mới',
                    ),
                    array(
                        'name' => static::ROLE_PHOTO.'_'.static::ACTION_EDIT,
                        'description' => 'Cập nhật',
                    ),
                    array(
                        'name' => static::ROLE_PHOTO.'_'.static::ACTION_ACTIVE,
                        'description' => 'Kích hoạt',
                    ),
                ),
            ),
        );
    }
}