<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use AvoRed\Framework\Database\Contracts\MenuGroupModelInterface;
use AvoRed\Framework\Database\Models\CategoryFilter;
use AvoRed\Framework\Database\Models\Category;

class NavComposer
{
    /**
     * @var \AvoRed\Framework\Database\Repository\MenuGroupRepository
     */
    protected $menuGroupRepository;

    /**
     * home controller construct.
     */
    public function __construct(
        MenuGroupModelInterface $menuGroupRepository
    ) {
        $this->menuGroupRepository = $menuGroupRepository;
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function compose(View $view)
    {
        if (Auth::guard('customer')->check()) {
            $menus = $this->menuGroupRepository->getTreeByIdentifier('main-auth-menu');
        } else {
            $menus = $this->menuGroupRepository->getTreeByIdentifier('main-menu');
        }

        //$filter_menus = $this->menuGroupRepository->getTreeByIdentifier('main-frontend-filter-menu');
        //$filter_menus = CategoryFilter::with('category')->get();
        
        $filter_menus = Category::all();
        foreach($filter_menus as &$fm){
            $fm->categoryFilters = [];
            $categoryFilters = CategoryFilter::where('category_id',$fm->id)->get();
            if($categoryFilters->count()>0){
                foreach($categoryFilters as &$cf){
                    $cf->propertyFilter = $cf->filter->dropdown;
                }
                $fm->categoryFilters = $categoryFilters;
            }
        }
        $view->with(compact('menus','filter_menus'));
    }
}
