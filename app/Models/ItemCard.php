<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCard extends Model
{
    //
    protected $table='item_cards';
     protected $fillable = [
        'name',
        'item_type',
        'inv_itemscard_categories_id',
        'parent_inv_itemscard_id',
        'dose_has_retailunit',
        'retail_uom',
        'uom_id',
        'retail_uom_quantity_to_parent',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
        'item_code',
        'barcode',
        'price',
        'retail_price',
        'wholesale_price',
        'nos_gomla_price',
        'nos_gomla_price_retail',
        'wholesale_price_retail',
        'coast_price',
        'coast_price_retail',
        'has_fixed_price',
        'Quantity',
        'Quantity_retail',
        'Quantity_all_retail',
        'image',
    ];
       // الفئة
    public function inv_itemscard_categoriesid()
    {
        return $this->belongsTo(InvItemscardCategory::class,'inv_itemscard_categories_id');
    }
      // وحدة الصنف اذا كان جمله او تجزئه
        public function uomid()
    {
        return $this->belongsTo(Inv_uom::class,'uom_id');
    }
        public function retail_uom_id()
    {
        return $this->belongsTo(Inv_uom::class,'retail_uom');
    }
     // الصنف الأب  كرتون ماء = أب
    public function parent_inv_itemscardid()
    {
        return $this->belongsTo(ItemCard::class,'parent_inv_itemscard_id');
    }
       // الأصناف التابعة  حبة ماء = ابن
    public function parent_inv_itemscardid_children()
    {
        return $this->hasMany(ItemCard::class,'parent_inv_itemscard_id');
    }
        public function addedBy()
{
    return $this->belongsTo(Admin::class, 'added_by');
}

public function updatedBy()
{
    return $this->belongsTo(Admin::class, 'updated_by');
}
}


