<?php use App\Http\Controllers\CMSController; ?>

<!-- #Left Sidebar ==================== -->
<div class="sidebar">
    <div class="sidebar-inner">
    <!-- ### $Sidebar Header ### -->
    <div class="sidebar-logo green darken-1">
        <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
            <a class="sidebar-link td-n" href="/cms">
            <div class="peers ai-c fxw-nw">
                <div class="peer">
                <div class="logo">
                    <span class="fa fa-leaf fa-3x mt-2 ml-2 white-ic"></span>
                </div>
                </div>
                <div class="peer peer-greed">
                <h5 class="lh-1 mB-0 logo-text white-text">{{env('APP_NAME')." CMS"}}</h5>
                </div>
            </div>
            </a>
        </div>
        <div class="peer">
            <div class="mobile-toggle sidebar-toggle">
            <a href="" class="td-n">
                <i class="ti-arrow-circle-left"></i>
            </a>
            </div>
        </div>
        </div>
    </div>

    <!-- ## $Sidebar Menu ### -->
    <ul class="sidebar-menu scrollable pos-r">
        <li class="nav-item mT-30 actived">
            <a class="sidebar-link" href="/cms">
                <span class="icon-holder">
                <i class="c-blue-500 ti-home"></i>
                </span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <?php $cats = CMSController::getCategories() ?>
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                <i class="c-blue-grey-400 ti-folder"></i>
                </span>
                <span class="title">Categories</span>
                <span class="arrow">
                <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu show">
                <li>
                    <a class="sidebar-link" href="/cms/categories">
                        <span class="icon-holder">
                        <i class="c-blue-500 ti-eye"></i>
                        </span>
                        <span class="title"><strong>Preview</strong></span>
                    </a>
                </li>
                <li>
                    <a class="sidebar-link" href="/cms/categories?toggle-mode=modal&target=addNewModal&auto-toggle=true">
                        <span class="icon-holder">
                        <i class="c-blue-500 ti-plus"></i>
                        </span>
                        <span class="title"><strong>Add New</strong></span>
                    </a>
                </li>
                @foreach($cats as $index => $cat)
                    <!-- category name -->
                    <li>
                        <a class="dropdown-toggle grey-text" data-toggle="dropdown" data-target="#cat_drop_{{$index}}" href="javascript:void(0);">
                            <span class="icon-holder">
                            <i class="@if($cat->trashed()) c-red-200 @else c-blue-400 @endif ti-folder"></i>
                            </span>
                            <span class="title @if($cat->trashed()) c-red-200 @else c-grey-800 @endif">{{$cat->category_name}}</span>
                            <span class="arrow">
                            <i class="ti-angle-right"></i>
                            </span>
                        </a>
                        <ul id="cat_drop_{{$index}}" class="dropdown-menu">
                            <li>
                                <a class="sidebar-link" href="/cms/categories/{{$cat->id}}">
                                    <span class="icon-holder">
                                    <i class="ti-pencil c-red-300"></i>
                                    </span>
                                    <span class="title"><strong>Modify</strong></span>
                                </a>
                            </li>
                            @foreach($cat->subcategories as $subCat)
                            <li>
                            <a class='sidebar-link' href="/cms/categories/{{$cat->id}}/{{$subCat->id}}">{{$subCat->sub_category_name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                <i class="c-orange-500 ti-files"></i>
                </span>
                <span class="title">Pages Setup</span>
                <span class="arrow">
                <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                <a class='sidebar-link' href="/cms/home">Home</a>
                </li>
                <li>
                <a class='sidebar-link' href="datatable.html">Data Table</a>
                </li>
            </ul>
        </li>
    </ul>
    </div>
</div>