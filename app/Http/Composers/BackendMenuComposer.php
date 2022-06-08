<?php

namespace App\Http\Composers;

use App\Models\BackendMenu;
use Illuminate\View\View;
use Request;

class BackendMenuComposer
{
    public $blockNodes = [];

    public function compose(View $view)
    {
        $view->with('backendMenus', $this->backendMenu());
    }

    private function backendMenu()
    {
        $backendMenus = BackendMenu::where(['status' => 1])->get()->toArray();
        $myMenu = '';
        $nodes  = $this->menuTree($backendMenus, $this->blockNodes);
        $this->frontendMenu($nodes, $myMenu);

        return $myMenu;
    }

    private function menuTree(array $nodes, array $blockNodes = null)
    {
        $tree = [];
        foreach ($nodes as $id => $node) {
            if (isset($node['link']) && !isset($blockNodes[$node['link']])) {

                if (in_array($node['link'], $blockNodes)) {
                    continue;
                }

                if (($node['link'] != '#') && !blank(auth()->user()) && !auth()->user()->can($node['link'])) {
                    continue;
                }

                if ($node['parent_id'] == 0) {
                    $tree[$node['id']] = $node;
                } else {
                    if (!isset($tree[$node['parent_id']]['child'])) {
                        $tree[$node['parent_id']]['child'] = [];
                    }
                    $tree[$node['parent_id']]['child'][$node['id']] = $node;
                }
            }
        }

        return $tree;
    }

    private function frontendMenu(array $nodes, string &$menu)
    {
        foreach ($nodes as $node) {

            $f              = 0;
            $dropdown       = 'nav-item dropdown ';
            $dropdownToggle = 'has-dropdown';
            $active         = '';

            if ($node['link'] == '#' && !isset($node['child'])) {
                continue;
            }

            if (isset($node['child'])) {
                $f          = 1;
                $childArray = collect($node['child'])->pluck('link')->toArray();

                $segmentLink = Request::segment(2);

                if (in_array($segmentLink, $childArray)) {
                    $active = 'active';
                }
            }

            if (Request::segment(2) == $node['link']) {
                $active = 'active';
            }

            $menu .= '<li class="' . ($f ? $dropdown : '') . $active . '">';
            $menu .= '<a class="nav-link ' . ($f ? $dropdownToggle : '') . '" href="' . url('admin/' . $node['link']) . '" >' .
                '<i class="' . ($node['icon'] != null ? $node['icon'] : 'fa-home') . '"></i> <span>' .(trans('menu.'.$node['name'])) . '</span></a>';

            if ($f) {
                $menu .= '<ul class="dropdown-menu">';
                $this->frontendMenu($node['child'], $menu);
                $menu .= "</ul>";
            }
            $menu .= "</li>";
        }
    }
}
