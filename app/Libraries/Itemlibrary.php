<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class Itemlibrary extends BaseController
{
    public function getsub()
    {
        $item = new \App\Models\ItemModel();
        $item->join('sub_item', 'sub_item.item = item.id', 'LEFT');
        $item->select('sub_item.id');
        $item->select('sub_item.nama');
        $item->select('item.status as itemstatus');
        $item->select('item.id as itemid');
        $item->select('sub_item.status as substatus');
        $item->select('item.nama as namaitem');
        $item->where('sub_item.status', 1);
        $item->where('item.status', 1);
        $item = $item->orderBy('nama', 'asc')->findAll();

        $group = array();
        foreach ( $item as $value ) {
            $group[$value['namaitem']][] = $value;
        }
        $itemfix = array();
        foreach($group as $type => $labels){
            $itemfix[] = array(
                'namaitem' => $type,
                'nama' => $labels
            );
        }
        array_multisort(array_map(function($element) {
            return $element['namaitem'];
        }, $itemfix), SORT_ASC, $itemfix);
        return $itemfix;
    }
}
