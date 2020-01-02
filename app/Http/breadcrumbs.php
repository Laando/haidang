<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Trang chủ', route('home'));
});
Breadcrumbs::register('cart', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Giỏ hàng', route('usercart'));
});
Breadcrumbs::register('user-home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thông tin tài khoản');
});
Breadcrumbs::register('user-address', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Địa chỉ giao hàng');
});
Breadcrumbs::register('user-order', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thông tin đơn hàng');
});
Breadcrumbs::register('user-point', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Điểm tích lũy');
});
Breadcrumbs::register('user-wishlist', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sản phẩm yêu thích');
});
Breadcrumbs::register('search', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tìm kiếm', route('search'));
});
Breadcrumbs::register('region', function($breadcrumbs,$region)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($region->title, route('region'));
});
//Home > Help
Breadcrumbs::register('tro-giup', function($breadcrumbs,$title)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($title);
});
// Home > tour-trong-nuoc
Breadcrumbs::register('tour-du-lich', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tour du lịch', route('tour-du-lich'));
});
// Home > tour-trong-nuoc
Breadcrumbs::register('tour-trong-nuoc', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tour trong nước', route('tour-trong-nuoc'));
});
Breadcrumbs::register('bang-gia', function($breadcrumbs ,$type_price)
{
    $breadcrumbs->parent('home');
    switch($type_price){
        case 1 :
            $breadcrumbs->push('Bảng giá tour trong nước');
            break;
        case 2 :
            $breadcrumbs->push('Bảng giá tour nước ngoài');
            break;
        case 3 :
            $breadcrumbs->push('Bảng giá tour đoàn');
            break;
        case 4 :
            $breadcrumbs->push('SUPER SALE');
            break;
        default :
            $breadcrumbs->push('Bảng giá tour trong nước');
            break;
    }

});

// Home > tour-trong-nuoc > Chu de
Breadcrumbs::register('chu-de-tour', function($breadcrumbs , $subjecttour)
{
    $breadcrumbs->parent('tour-trong-nuoc');
    $breadcrumbs->push($subjecttour->title , route('chu-de-tour',$subjecttour->slug));
});
// Home > tour-trong-nuoc > Diem den
Breadcrumbs::register('diem-den', function($breadcrumbs , $subjecttour)
{
    $breadcrumbs->parent('tour-trong-nuoc');
    $breadcrumbs->push($subjecttour->title , route('diem-den',$subjecttour->slug));
});
// Home > tour-trong-nuoc > chu de
Breadcrumbs::register('chu-de', function($breadcrumbs , $subjecttour)
{
    $breadcrumbs->parent('tour-trong-nuoc');
    $breadcrumbs->push($subjecttour->title , route('chu-de-tour',$subjecttour->slug));
});
//Home > tin-tuc > { diem -den }
Breadcrumbs::register('tin-tuc-diem-den', function($breadcrumbs, $destinationpoint) {
    $breadcrumbs->view = config('breadcrumbs.view_blog');
    $breadcrumbs->parent('home');
    $breadcrumbs->push($destinationpoint->title);
});
Breadcrumbs::register('thue-xe-home', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thuê xe du lịch',route('thue-xe-home'));
});
Breadcrumbs::register('thue-xe', function($breadcrumbs, $destinationpoint) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thuê xe du lịch',route('thue-xe-home'));
    $breadcrumbs->push($destinationpoint->title);
});
//Home > tin-tuc > { parent }
Breadcrumbs::register('tin-tuc', function($breadcrumbs, $subjectblog) {
    $breadcrumbs->view = config('breadcrumbs.view_blog');
    $breadcrumbs->parent('home');
    if($subjectblog!=null) {
        $ancestors = $subjectblog->ancestors()->get();
        if ($ancestors != null) {
            foreach ($ancestors as $ancestor) {
                $breadcrumbs->push($ancestor->title,$ancestor->slug);
            }
        }
        $breadcrumbs->push($subjectblog->title);
    }

});
//Home > tin-tuc >{category}> { name }
Breadcrumbs::register('tin-tuc-blog', function($breadcrumbs, $blog) {
    $breadcrumbs->view = config('breadcrumbs.view_blog');
    $breadcrumbs->parent('home');
    $breadcrumbs->push($blog->title, $blog->slug.'.html');
});
// Home > tour-trong-nuoc > tour detail
Breadcrumbs::register('tour-detail', function($breadcrumbs , $tour)
{
    $breadcrumbs->parent('home');
    if($tour->isOutbound == 1){
        $breadcrumbs->push('Tour nước ngoài',route('tour-nuoc-ngoai'));
    } else {
        $breadcrumbs->push('Tour trong nước',route('tour-trong-nuoc'));
    }
    $breadcrumbs->push($tour->title , route('tour-detail',$tour->slug));
});
// Home > tour-nuoc-ngoai
Breadcrumbs::register('tour-nuoc-ngoai', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tour nước ngoài', route('tour-nuoc-ngoai'));
});


// Home > Blog
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});
//Home > Userhome
Breadcrumbs::register('userhome', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Trang cá nhân');
});
Breadcrumbs::register('khach-san', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Khách sạn',route('khach-san'));
});
Breadcrumbs::register('khach-san-diem-den', function($breadcrumbs,$hoteldestinationpoint)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Khách sạn',route('khach-san'));
    $breadcrumbs->push('Khách sạn '.$hoteldestinationpoint->title ,route('khach-san-diem-den',$hoteldestinationpoint->slug));
});
Breadcrumbs::register('khach-san-detail', function($breadcrumbs,$hotel)
{
    $hoteldestinationpoint = $hotel->destinationpoint;
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Khách sạn',route('khach-san'));
    $breadcrumbs->push('Khách sạn '.$hoteldestinationpoint->title ,route('khach-san-diem-den',$hoteldestinationpoint->slug));
    $breadcrumbs->push($hotel->title);
});
Breadcrumbs::register('khach-san-tim-kiem', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Khách sạn',route('khach-san'));
    $breadcrumbs->push('Tìm kiếm');
});