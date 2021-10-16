<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $name name
@property varchar $category category
@property varchar $keywords keywords
@property text $description description
@property longtext $fulldescription fulldescription
@property int $viewcount viewcount
@property varchar $setdate setdate
@property varchar $image image
@property varchar $linkcatalog linkcatalog
@property varchar $linkvideo linkvideo
@property int $gallerycat gallerycat
@property int $slideshowcat slideshowcat
@property int $linkcat linkcat
@property int $contentscat contentscat
@property int $advertisecat advertisecat
@property int $pollingcat pollingcat
@property int $productcat productcat
@property int $faqcat faqcat
@property int $sort sort
@property varchar $style style
@property int $portalid portalid
@property varchar $status status
@property Portalid $setting belongsTo
@property Faqcat $faqcat belongsTo
@property Productcat $productcat belongsTo
@property Pollingcat $pollingcat belongsTo
@property Advertisecat $advertisecat belongsTo
@property Contentscat $category belongsTo
@property Linkcat $linkcat belongsTo
@property Slideshowcat $slideshowcat belongsTo
@property Gallerycat $gallerycat belongsTo
   
 */
class Service extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'services';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'code',
'name',
'category',
'keywords',
'description',
'fulldescription',
'viewcount',
'setdate',
'image',
'linkcatalog',
'linkvideo',
'gallerycat',
'slideshowcat',
'linkcat',
'contentscat',
'advertisecat',
'pollingcat',
'productcat',
'faqcat',
'sort',
'style',
'portalid',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * portalid
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function portalid()
    {
        return $this->belongsTo(Setting::class,'portalid');
    }

    /**
    * faqcat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function faqcat()
    {
        return $this->belongsTo(Faqcat::class,'faqcat');
    }

    /**
    * productcat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function productcat()
    {
        return $this->belongsTo(Productcat::class,'productcat');
    }

    /**
    * pollingcat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function pollingcat()
    {
        return $this->belongsTo(Pollingcat::class,'pollingcat');
    }

    /**
    * advertisecat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function advertisecat()
    {
        return $this->belongsTo(Advertisecat::class,'advertisecat');
    }

    /**
    * contentscat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function contentscat()
    {
        return $this->belongsTo(Category::class,'contentscat');
    }

    /**
    * linkcat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function linkcat()
    {
        return $this->belongsTo(Linkcat::class,'linkcat');
    }

    /**
    * slideshowcat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function slideshowcat()
    {
        return $this->belongsTo(Slideshowcat::class,'slideshowcat');
    }

    /**
    * gallerycat
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function gallerycat()
    {
        return $this->belongsTo(Gallerycat::class,'gallerycat');
    }




}