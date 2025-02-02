<?php

use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Color;
use App\Models\Admin\CutomerService;
use App\Models\Admin\GeneralSettings;
use App\Models\Admin\ProductTag;
use App\Models\Admin\SiteContent\AboutUsPage;
use App\Models\Admin\SiteContent\FooterInformation;
use App\Models\Admin\SiteContent\Homepage;
use App\Models\Admin\SiteContent\SocialLink;
use App\Models\Admin\Size;
use App\Models\Front\CompareList;
use App\Models\Front\Wishlist;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Billing;
use App\Models\Admin\Shipping;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Stock;
use App\Models\Admin\Product;
use App\Models\Admin\Template;
use App\Models\Admin\ShippingMethod;
use App\Models\Admin\Order;
use App\Models\Menu;
use App\Models\Design;
use App\Models\Tax;
use App\Models\DeliveryCharge;
use App\Models\Language;
use App\Models\Admin\OrderDetails;

if(!function_exists('fileUpload'))
{
    function fileUpload($img, $path, $user_file_name = null, $width = null, $height = null)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
            unlink($path . $user_file_name);
        }
        // saving image in target path
        $imgName = uniqid() . time() . '.' . $img->getClientOriginalExtension();
        $imgPath = public_path($path . $imgName);
        // making image
        $makeImg = Image::make($img)->orientate();
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $makeImg->fit($width, $height);
        }
        if ($makeImg->save($imgPath)) {
            return $imgName;
        }
        return false;
    }
}

function allsetting($array = null)
{
    if (!isset($array[0])) {
        $allsettings = Setting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = Setting::whereIn('slug', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = Setting::where(['slug' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}

function currencySymbol($array = null)
{
    if (!isset($array[0])) {
        $allsettings = Currency::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->currency] = $setting->symbol;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = Currency::whereIn('currency', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->currency] = $setting->symbol;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = Currency::where(['currency' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->symbol;
            return $output;
        }
        return false;
    }
}

if(!function_exists('template_settings'))
{
    function template_settings()
    {
        return 'uploaded_files/template_settings/';
    }
}
if(!function_exists('AdminProfilePicture'))
{
    function AdminProfilePicture()
    {
        return 'uploaded_files/admin_profile/';
    }
}
if(!function_exists('SliderImage'))
{
    function SliderImage()
    {
        return 'uploaded_files/slider/';
    }
}
if(!function_exists('PromotionImage'))
{
    function PromotionImage()
    {
        return 'uploaded_files/promotion/';
    }
}
if(!function_exists('GeneralSettingsImage'))
{
    function GeneralSettingsImage()
    {
        return 'uploaded_files/general_settings/';
    }
}
if(!function_exists('GeneralSettings'))
{
    function GeneralSettings()
    {
        return GeneralSettings::first();
    }
}
if(!function_exists('BlogImage'))
{
    function BlogImage()
    {
        return 'uploaded_files/blog/';
    }
}
if(!function_exists('Category'))
{
    function Category()
    {
        return Category::where('en_Description',null)->orWhere('Category_Icon',null)->get();
    }
}

if(!function_exists('ChildCategoryList'))
{
    function ChildCategoryList($id)
    {
        return Category::where('parent_id', $id)->get();
    }
}

if(!function_exists('ChildCatList'))
{
    function ChildCatList($name)
    {
        $ParentCategory = Category::where('en_Category_Name', $name)->first();
        return Category::where('parent_id', $ParentCategory->id)->get();
    }
}

if(!function_exists('getSizeId'))
{
    function getSizeId($key)
    {
        $size =  Size::where('Size', $key)->first();
        return $size->id;
//    return $key;
    }
}

if(!function_exists('ChildCategory'))
{
    function ChildCategory()
    {
        return Category::whereNotNull('parent_id')->get();
    }
}

if(!function_exists('ParentCategory'))
{
    function ParentCategory()
    {
        return Category::where('parent_id', null)->get();
    }
}

if(!function_exists('ParentCategoryName'))
{
    function ParentCategoryName($id)
    {
        return Category::where('id', $id)->first();
    }
}


if(!function_exists('Category_Des_Icon'))
{
    function Category_Des_Icon()
    {
        return Category::where('parent_id', null)->get();
    }
}
if(!function_exists('BrandImage'))
{
    function BrandImage()
    {
        return 'uploaded_files/brand/';
    }
}

if(!function_exists('DesignImage'))
{
    function DesignImage()
    {
        return 'uploaded_files/design/';
    }
}

if(!function_exists('TemplateImage'))
{
    function TemplateImage()
    {
        return 'uploaded_files/templates/';
    }
}

if(!function_exists('ShippingMethodImage'))
{
    function ShippingMethodImage()
    {
        return 'uploaded_files/shipping_methods/';
    }
}

if(!function_exists('Template'))
{
    function Template()
    {
        return Template::where('Status',1)->orderBy('created_at', 'desc')->get();
    }
}

if(!function_exists('TemplateDesign'))
{
    function TemplateDesign($id)
    {
        return Template::where('id', $id)->first();
    }
}



if(!function_exists('ShippingMethod'))
{
    function ShippingMethod()
    {
        return ShippingMethod::where('Status',1)->orderBy('created_at', 'desc')->get();
    }
}

if(!function_exists('GetShippingMethod'))
{
    function GetShippingMethod($id)
    {
        return ShippingMethod::where('id', $id)->first();
    }
}

if(!function_exists('DesignLogo'))
{
    function DesignLogo()
    {
        return 'uploaded_files/design/logo/';
    }
}

if(!function_exists('Brnad'))
{
    function Brnad()
    {
        return Brand::get();
    }
}


if(!function_exists('BrandCloth'))
{
    function BrandCloth()
    {
        $product = Product::select('Brand_Id')->where('Category_Id', 6)->distinct()->get();
        return Brand::whereIn('id', $product)->get();
    }
}

if(!function_exists('BrandBeauty'))
{
    function BrandBeauty()
    {
        $product = Product::select('Brand_Id')->where('Category_Id', 23)->distinct()->get();
        return Brand::whereIn('id', $product)->get();
    }
}

if(!function_exists('PetSupplies'))
{
    function PetSupplies()
    {
        $parent_categories = Category::select('id')->where('parent_id', 24)->get();

        $product = Product::select('Brand_Id')->whereIn('Category_Id', $parent_categories)->distinct()->get();

        return Brand::whereIn('id', $product)->get();
    }
}

if(!function_exists('Design'))
{
    function Design($id)
    {
        return Design::where('id', $id)->first();
    }
}

if(!function_exists('productColor'))
{
    function productColor()
    {
        return Color::get();
    }
}

if(!function_exists('productSize'))
{
    function productSize()
    {
        return Size::get();
    }
}

if(!function_exists('productSizeStock'))
{
    function productSizeStock($id)
    {
        $stock = Stock::select('size_id')->where('product_id', $id)->get();
        $stock_sizes = [];

        foreach ( $stock as $key => $value ){
            $stock_sizes [] = $value->size_id;
        }

        return json_encode($stock_sizes);
    }
}

if(!function_exists('productStock'))
{
    function productStock($id)
    {
        return Stock::where('product_id', $id)->get();
    }
}

if(!function_exists('productTag'))
{
    function productTag()
    {
        return ProductTag::get();
    }
}

if(!function_exists('ImageGallery'))
{
    function ImageGallery()
    {
        return 'uploaded_files/imgae_gallery/';
    }
}

if(!function_exists('ProductImage'))
{
    function ProductImage()
    {
        return 'uploaded_files/product_image/';
    }
}

if(!function_exists('checkBoxValue'))
{
    function checkBoxValue($value = null) {
        return $value != null ? 1 : 0;
    }
}


if(!function_exists('langConverter')){
    function langConverter($en, $fr)
    {
        if(app()->getLocale() == 'en') {
            return $en;
        }
        return $fr;
    }
}

if(!function_exists('currency')){
    function currency()
    {
        if(session()->has('currency')) {
            return session()->get('currency');
        }
        return 'USD';
    }
}

if(!function_exists('currencyConverter')){
    function currencyConverter($price)
    {
        if(session()->has('currency')) {
            $currency = Currency::where('currency', session()->get('currency'))->first();
            if(!empty($currency)) {
                $convert_price = $price * $currency->convert_from_usd;
                return $convert_price;
            }
        }
        return $price;
    }
}

if(!function_exists('convertToINR')){
    function convertToINR($price)
    {
        $currency = Currency::where('iso', 'inr')->first();
        if(!empty($currency)) {
            $convert_price = $price * $currency->convert_from_usd;
        }else {
            $convert_price = $price * 74.39;
        }
        return $convert_price;
    }
}


if(!function_exists('colorSelected')){
    function colorSelected($product_id, $color_id)
    {
        $count = DB::table('color_product')->where('Product_Id', $product_id)->where('Color_Id', $color_id)->count();
        if($count == 0) {
            return 0;
        }
        else {
            return 1;
        }
    }
}

if(!function_exists('sizeSelected')){
    function sizeSelected($product_id, $size_id)
    {
        $count = DB::table('size_product')->where('Product_Id', $product_id)->where('Size_Id', $size_id)->count();
        if($count == 0) {
            return 0;
        }
        else {
            return 1;
        }
    }
}
if(!function_exists('productCategoryCount')){
    function productCategoryCount($id){
        $category=Category::with('products')->where('id',$id)->first();
        $count = $category->products->count('id');
        return $count;
    }
}

if(!function_exists('productColorCount')){
    function productColorCount($id){
        $category=Color::with('products')->where('id',$id)->first();
        $count = $category->products->count('id');
        return $count;
    }
}
if(!function_exists('productBrandCount')){
    function productBrandCount($id){
        $category=Brand::with('products')->where('id',$id)->first();
        $count = $category->products->count('id');
        return $count;
    }
}
if(!function_exists('cartCountItem')){
    function cartCountItem(){
        return Cart::count();
    }
}

if(!function_exists('cartContentSideShow')){
    function cartContentSideShow(){
        return Cart::content();

    }
}


if(!function_exists('CutomerServiceContent')){
    function CutomerServiceContent($location){
        return CutomerService::where('location',$location)->first();
    }
}

if(!function_exists('TestimonialImage'))
{
    function TestimonialImage()
    {
        return 'uploaded_files/testimonial/';
    }
}


if(!function_exists('wishlistCount')){
    function wishlistCount(){
        return Wishlist::count('id');
    }
}
if(!function_exists('compareListCount')){
    function compareListCount(){
        return CompareList::count('id');
    }
}
if(!function_exists('siteContentHomePage')){
    function siteContentHomePage($location){
        return Homepage::where('Location',$location)->first();
    }
}

if(!function_exists('aboutUsPage'))
{
    function aboutUsPage()
    {
        return 'uploaded_files/about_us_page/';
    }
}

if(!function_exists('siteContentAboutPage')){
    function siteContentAboutPage($location){
        return AboutUsPage::where('Location',$location)->first();
    }
}
if(!function_exists('getSocialLink')){
    function getSocialLink(){
        return SocialLink::first();
    }
}
if(!function_exists('footerInformation')){
    function footerInformation(){
        return FooterInformation::first();
    }
}
if(!function_exists('footerImage'))
{
    function footerImage()
    {
        return 'uploaded_files/footer/';
    }
}
if(!function_exists('hasBlillingAddress')){
    function hasBlillingAddress($user_id){
        $count_address = Billing::where('User_Id', $user_id)->count();
        if($count_address != 0) {
            return 1;
        }
        return 0;
    }
}
if(!function_exists('hasShippingAddress')){
    function hasShippingAddress($user_id){
        $count_address = Shipping::where('User_Id', $user_id)->count();
        if($count_address != 0) {
            return 1;
        }
        return 0;
    }
}
if(!function_exists('subtotal')){
    function subtotal(){
        if(\Cart::count() != 0) {
            return \Cart::subtotal();
        }
        return 0;

    }
}

if(!function_exists('tax_amount')){
    function tax_amount($subtotal, $country = null){
        $tax = 0;
        if($country != null) {
            $tax_percentage = Tax::where('country', $country)->where('status', ACTIVE)->first();
            if(!is_null($tax_percentage)) {
                $tax = ($subtotal * $tax_percentage->percentage) / 100;
            }
        }
        return $tax;
    }
}

if(!function_exists('tax_rate')){
    function tax_rate($country = null){
        $tax_rate = 0;
        if($country != null) {
            $tax = Tax::where('country', $country)->where('status', ACTIVE)->first();
            if(!is_null($tax)) {
                $tax_rate = $tax->percentage;
            }
        }
        return $tax_rate;
    }
}

if(!function_exists('delivery_charge')){
    function delivery_charge($country = null){
        $dc = 0;
        if($country != null) {
            $delivery_charge = DeliveryCharge::where('country', $country)->where('status', ACTIVE)->first();
            if(!is_null($delivery_charge)) {
                $dc = $delivery_charge->charge;
            }
        }
        return $dc;
    }
}

if(!function_exists('hasPerviousReview')){
    function hasPerviousReview($product_id, $user_id = null){
        if($user_id == null) {
            $user_id = Auth::id();
        }
        $check_review = ProductReview::where('product_id', $product_id)->where('user_id', $user_id)->count();
        if($check_review != 0) {
            return 1;
        }
        return 0;
    }
}

if(!function_exists('reviewRating')){
    function reviewRating($review_id){
        $review = ProductReview::whereId($review_id)->first();
        $html = '';
        if($review->rating == 1) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif ($review->rating == 2) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif ($review->rating == 3) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif ($review->rating == 4) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif ($review->rating == 5) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                </ul>';
        }

        return $html;
    }
}

if(!function_exists('productReview')){
    function productReview($product_id){
        $review = ProductReview::where('product_id', $product_id)->avg('rating');
        $html = '';
        if(round($review) == 1) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif (round($review) == 2) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif (round($review) == 3) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif (round($review) == 4) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }elseif (round($review) == 5) {
            $html =  '<ul class="product-review">
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                    <li class="review-item active"><i class="flaticon-star"></i></li>
                </ul>';
        }else {
            $html =  '<ul class="product-review">
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                    <li class="review-item"><i class="flaticon-star"></i></li>
                </ul>';
        }

        return $html;
    }
}

if(!function_exists('productReviewNumber')){
    function productReviewNumber($product_id){
        $review = ProductReview::where('product_id', $product_id)->avg('rating');

        return round($review, 1);
    }
}

if(!function_exists('productReviewerNumber')){
    function productReviewerNumber($product_id){
        $review = ProductReview::where('product_id', $product_id)->count();

        return $review;
    }
}

if(!function_exists('selectProductTag')){
    function selectProductTag($tag, $product_id){
        if(ProductTag::where('tag', $tag)->where('product_id', $product_id)->exists()) {
            return 'selected';
        }
        return null;
    }
}

if(!function_exists('productTypeText')){
    function productTypeText($product_id){
        $product = Product::whereId($product_id)->first();
        if(!empty($product)) {
            if($product->type == PRODUCT_PHYSICAL) {
                return __('Physical');
            }elseif($product->type == PRODUCT_DIGITAL) {
                return __('Digital');
            }elseif($product->type == PRODUCT_LICENSE) {
                return __('License');
            }elseif($product->type == PRODUCT_AFFILIATE) {
                return __('Affiliate');
            }
        }
        return __('N/A');
    }
}

if(!function_exists('randomString')){
    function randomString($a)
    {
        $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $c = strlen($x) - 1;
        $z = '';
        for ($i = 0; $i < $a; $i++) {
            $y = rand(0, $c);
            $z .= substr($x, $y, 1);
        }
        return $z;
    }
}

if(!function_exists('orderCount')){
    function orderCount($status = null)
    {
        if($status != null) {
            return Order::where('Order_Status', $status)->count();
        }else {
            return Order::count();
        }
    }
}

if(!function_exists('staticMenuName')){
    function staticMenuName($slug)
    {
        $menu = Menu::select('en_name', 'fr_name')->where('slug', $slug)->first();
        if(app()->getLocale() == 'en') {
            return $menu->en_name;
        }
        return $menu->fr_name;
    }
}

if(!function_exists('getLanguage')){
    function getLanguage($locale)
    {
        return Language::where('locale', $locale)->first();
    }
}

if(!function_exists('getLanguage')){
    function getLanguage($locale)
    {
        return Language::where('locale', $locale)->first();
    }
}

if(!function_exists('langString')){
    function langString($locale, $brace = true)
    {
        $primary = Language::where('locale', $locale)->first();
        $lang = $primary->name;
        if($brace == true) {
            return '('.$lang.')';
        }else {
            return $lang;
        }

    }
}

if(!function_exists('orderCountUser')){
    function orderCountuser($user_id)
    {
        return Order::where('User_Id', $user_id)->count();

    }
}

if(!function_exists('validDigitalSend')){
    function validDigitalSend($order_id)
    {
        $order_types = [];
        $order_details = OrderDetails::where('Order_Id', $order_id)->with('product')->get();
        foreach($order_details as $od) {
            array_push($order_types, $od->product->type);
        }
        return in_array(PRODUCT_DIGITAL, $order_types);

    }
}

