@extends('layout.admin')
@section('title', 'Dashboard')

@section('content')

<section class="content" style="margin: 100px 15px 0 0;">
  <div class="container-fluid">
    <div class="block-header text-center">
      <h2>Welcome {{ auth('admin')->user()->name }}</h2>
    </div>
    <style>
    	a:link { text-decoration: none; }
    </style>
    <!-- Widgets -->
    <?php /*?><div class="row clearfix">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/dashboard'); }}"><div class="info-box bg-orange hover-zoom-effect" style="cursor:pointer">
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Dashboard</div>
            </div>
        </div></a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/'); }}"><div class="info-box bg-pink hover-zoom-effect" style="cursor:pointer">
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Accounts</div>
            </div>
        </div></a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/change-password'); }}"><div class="info-box bg-cyan hover-zoom-effect" style="cursor:pointer">
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number text-center">Change Password</div>
            </div>
        </div></a>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/setting'); }}"><div class="info-box bg-light-green hover-zoom-effect" style="cursor:pointer">
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Settings</div>
            </div>
        </div></a>
      </div>
      <!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/logout'); }}"><div class="info-box bg-red hover-zoom-effect" style="cursor:pointer">
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Logout</div>
            </div>
        </div></a>
      </div>-->
    </div><?php */?>
    <!-- #END# Widgets --> 
    <div class="row clearfix">
      <div class="col-lg-12 text-center">
        <div class="alert alert-info"> Email System Console </div>
      </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="{{ url('admins/add-send-grid-email/'); }}"><div class="info-box-4 bg-orange hover-zoom-effect" style="cursor:pointer; height:auto">
            
            <div class="content" style="margin:auto;">
                <div class="number">Bulk Email Using API</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="{{ url('admins/send-grid-emails/'); }}"><div class="info-box-4 bg-orange hover-zoom-effect" style="cursor:pointer; height:auto">
            
            <div class="content" style="margin:auto;">
                <div class="number">API Autorun Control Panel</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ url('admins/add-smtp-email/'); }}"><div class="info-box-4 bg-light-green hover-zoom-effect" style="cursor:pointer; height:auto">
                
                <div class="content" style="margin:auto;">
                    <div class="number">Bulk Emailing Using SMTP Credentials</div>
                </div>
            </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ url('admins/smtp-emails/'); }}"><div class="info-box-4 bg-light-green hover-zoom-effect" style="cursor:pointer; height:auto">
                
                <div class="content" style="margin:auto;">
                    <div class="number">SMTP - Autorun Control Panel</div>
                </div>
            </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ url('admins/add-smtp-email-mime/'); }}"><div class="info-box-4 bg-pink hover-zoom-effect" style="cursor:pointer; height:auto">
                
                <div class="content" style="margin:auto;">
                    <div class="number">Bulk Emailing Using SMTP Credentials (MIME)</div>
                </div>
            </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ url('admins/smtp-emails-mime/'); }}"><div class="info-box-4 bg-pink hover-zoom-effect" style="cursor:pointer; height:auto">
                
                <div class="content"style="margin:auto;">
                    <div class="number">MIME - Autorun Control Panel</div>
                </div>
            </div></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ url('admins/upload/'); }}"><div class="info-box-4 bg-cyan hover-zoom-effect" style="cursor:pointer; height:auto">
                
                <div class="content" style="margin:auto;">
                    <div class="number">Upload File</div>
                </div>
            </div></a>
        </div>
    </div>  
    <!-- CPU Usage -->
    <!--<div class="row clearfix">
      <div class="col-lg-12">
        <div class="alert alert-info"> <i class="fa fa-folder-open"></i><b>&nbsp; </b>Location Management<b></b> </div>
      </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/countries/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Country</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="{{ url('admins/states/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
                <div class="icon">
                    <i class="material-icons col-cyan">gps_fixed</i>
                </div>
                <div class="content">
                    <div class="text">&nbsp;</div>
                    <div class="number">State</div>
                </div>
            </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="{{ url('admins/cities/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
                <div class="icon">
                    <i class="material-icons col-cyan">gps_fixed</i>
                </div>
                <div class="content">
                    <div class="text">&nbsp;</div>
                    <div class="number">City</div>
                </div>
            </div></a>
        </div>
    </div>    
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="alert alert-info"> <i class="fa fa-folder-open"></i><b>&nbsp; </b>Subscription Management<b></b> </div>
      </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/subscriptions/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Subscription</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/coupon-code/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Coupon Code</div>
            </div>
        </div></a>
        </div>
    </div>
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="alert alert-info"> <i class="fa fa-folder-open"></i><b>&nbsp; </b>Product Management<b></b> </div>
      </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/category/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Categories</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/products/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Products</div>
            </div>
        </div></a>
        </div>
    </div>
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="alert alert-info"> <i class="fa fa-folder-open"></i><b>&nbsp; </b>Content Management System<b></b> </div>
      </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/inner-pages/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Inner Pages</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/cms/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">CMS Pages</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/header-navigations/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Header Navigations</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/footer-navigations/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Footer Navigations</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/contacts/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Contact Us</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/blog-categories/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Blog Categories</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/blogs/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Blogs</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/tags/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Tags</div>
            </div>
        </div></a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/users/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Customers</div>
            </div>
        </div></a>
        </div>
    </div>
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="alert alert-info"> <i class="fa fa-folder-open"></i><b>&nbsp; </b>Gallery Management<b></b> </div>
      </div>        
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ url('admins/gallery/'); }}"><div class="info-box-4 hover-zoom-effect" style="cursor:pointer">
            <div class="icon">
                <i class="material-icons col-cyan">gps_fixed</i>
            </div>
            <div class="content">
                <div class="text">&nbsp;</div>
                <div class="number">Gallery</div>
            </div>
        </div></a>
        </div>        
    </div>-->
  </div>
</section>
@endsection